<?php

namespace App\Http\Controllers;

use App\Ai\Agents\CampusBuddy;
use App\Http\Requests\SendMessageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Ai\Contracts\ConversationStore;

class ChatController extends Controller
{
    public function __construct(private ConversationStore $store) {}

    // GET /chat and GET /chat/{conversation}
    public function index(Request $request, ?string $conversation = null): View
    {
        $user = $request->user();
        $messages = collect();

        if ($conversation) {
            $this->authorizeConversation($request, $conversation);
            $page = $this->store
                ->paginateConversationMessages($conversation, perPage: 100);
            $messages = collect($page->items())
                ->sortBy('createdAt')
                ->map(fn ($m) => [
                    'role' => $m->role instanceof \BackedEnum
                        ? $m->role->value : $m->role,
                    'content' => $m->content,
                ])
                ->values();
        }

        // Get this user's 10 most recently updated conversations
        $conversations = $user->conversations()
            ->latest('updated_at')
            ->take(10)
            ->get();

        return view('chat.index', compact('conversations', 'conversation', 'messages'));
    }

    // POST /chat (normal form submit)
    public function store(SendMessageRequest $request): RedirectResponse
    {
        try {
            $response = $this->ask($request);
        } catch (\Throwable $e) {
            report($e);

            return back()->withInput()
                ->with('error', 'CampusBuddy is offline. Is the AI provider running?');
        }

        return redirect()->route('chat.show', $response->conversationId);
    }

    // POST /chat/send (called by fetch - Part E)
    public function send(SendMessageRequest $request): JsonResponse
    {
        try {
            $response = $this->ask($request);
        } catch (\Throwable $e) {
            report($e);

            return response()->json(
                ['message' => 'CampusBuddy is not available right now: ' . $e->getMessage()], 503
            );
        }

        return response()->json([
            'conversation_id' => $response->conversationId,
            'reply' => (string) $response,
        ]);
    }

    // Shared: send the message to the agent (new or existing conversation)
    private function ask(SendMessageRequest $request)
    {
        $user = $request->user();
        $conversationId = $request->validated('conversation_id');

        if ($conversationId) {
            $this->authorizeConversation($request, $conversationId);
        }

        return (new CampusBuddy)
            ->continueOrStart($conversationId, as: $user) // null = new chat
            ->prompt($request->validated('message'));
    }

    // A user may only open or continue their OWN conversations
    private function authorizeConversation(Request $request, string $conversationId): void
    {
        $user = $request->user();

        if (! $this->store->conversationBelongsTo($conversationId, $user->getMorphClass(), $user->getKey())) {
            abort(403);
        }
    }
}

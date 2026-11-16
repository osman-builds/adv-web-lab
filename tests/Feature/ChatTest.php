<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Ai\Contracts\ConversationStore;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/chat');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_chat_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/chat');

        $response->assertStatus(200)
            ->assertSee('CampusBuddy')
            ->assertSee('+ New chat');
    }

    public function test_user_cannot_access_another_users_conversation(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $store = app(ConversationStore::class);
        $conversationId = $store->storeConversation($user1->getMorphClass(), $user1->getKey(), 'Secret Chat');

        $response = $this->actingAs($user2)->get("/chat/{$conversationId}");

        $response->assertStatus(403);
    }
}

@extends('layouts.app')

@section('content')
<style>
    .chat-box {
        height: 55vh;
        overflow-y: auto;
        background: #f7f8fb;
        border-radius: 8px;
        padding: 16px;
    }
    .bubble {
        max-width: 75%;
        padding: 10px 14px;
        border-radius: 14px;
        margin-bottom: 10px;
        white-space: pre-line;
    }
    .bubble.user {
        background: #1a2456;
        color: #fff;
        margin-left: auto;
    }
    .bubble.assistant {
        background: #fff;
        border: 1px solid #e3e6ef;
    }
</style>

<div class="container">
    <h2>CampusBuddy <small class="text-muted">— {{ config('app.student_id', 'SW01085171') }}</small></h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-3">
            <a href="{{ route('chat.index') }}" class="btn btn-outline-primary w-100 mb-2">+ New chat</a>

            <div class="list-group">
                @foreach ($conversations as $c)
                    <a href="{{ route('chat.show', $c->id) }}"
                       @class(['list-group-item list-group-item-action', 'active' => $c->id == $conversation])>
                        {{ $c->title ?? 'Chat ' . $loop->iteration }}
                        <small class="d-block">{{ $c->updated_at->diffForHumans() }}</small>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="col-md-9">
            <div id="chat-box" class="chat-box mb-3">
                @forelse ($messages as $m)
                    <div class="bubble {{ $m['role'] }}">{{ $m['content'] }}</div>
                @empty
                    <p class="text-muted">Say hello to CampusBuddy!</p>
                @endforelse
            </div>

            <form id="chat-form" method="POST" action="{{ route('chat.store') }}" class="d-flex gap-2">
                @csrf
                <input type="hidden" name="conversation_id" value="{{ $conversation }}">
                <input name="message" value="{{ old('message') }}" autocomplete="off"
                       class="form-control @error('message') is-invalid @enderror"
                       placeholder="Type your message...">
                <button class="btn btn-primary">Send</button>
            </form>

            @error('message')
                <div class="text-danger small">{{ $message }}</div>
            @enderror

            <small class="text-muted d-block mt-2">
                AI-generated answers may be wrong. Do not share personal data.
            </small>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('chat-form');
    const box = document.getElementById('chat-box');
    box.scrollTop = box.scrollHeight;

    function addBubble(role, text) {
        const div = document.createElement('div');
        div.className = 'bubble ' + role;
        div.textContent = text; // SAFE: never use innerHTML for AI output
        box.appendChild(div);
        box.scrollTop = box.scrollHeight;
        return div;
    }

    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const text = form.message.value.trim();
        if (!text) return;

        addBubble('user', text);
        form.message.value = '';

        const reply = addBubble('assistant', 'CampusBuddy is thinking...');
        const button = form.querySelector('button');
        button.disabled = true;

        try {
            const res = await fetch('{{ route('chat.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({
                    message: text,
                    conversation_id: form.conversation_id.value || null,
                }),
            });

            const data = await res.json();
            if (!res.ok) throw new Error(data.message || 'Request failed');

            reply.textContent = data.reply;
            form.conversation_id.value = data.conversation_id; // same chat next time
            history.replaceState(null, '', '/chat/' + data.conversation_id);
        } catch (err) {
            reply.textContent = 'Sorry: ' + err.message;
            reply.classList.add('text-danger');
        } finally {
            button.disabled = false;
            form.message.focus();
        }
    });
</script>
@endsection

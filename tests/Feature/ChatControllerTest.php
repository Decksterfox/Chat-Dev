<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use App\Services\DeepSeekService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock da API DeepSeek para evitar chamadas reais durante testes
        Http::fake([
            'https://api.deepseek.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Esta é uma resposta de teste do bot.'
                        ]
                    ]
                ]
            ], 200)
        ]);
    }

    public function test_unauthenticated_user_cannot_access_chat(): void
    {
        $response = $this->get('/chat');
        
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_chat(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/chat');
        
        $response->assertStatus(200);
        $response->assertViewIs('chat.app');
    }

    public function test_user_can_send_message(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->postJson('/chat/send', [
                'message' => 'Olá, Professor Jubileu!'
            ]);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'conversation_id',
            'bot_response'
        ]);
        
        $this->assertDatabaseHas('messages', [
            'content' => 'Olá, Professor Jubileu!',
            'sender' => 'user'
        ]);
        
        $this->assertDatabaseHas('messages', [
            'sender' => 'bot'
        ]);
    }

    public function test_message_validation_requires_content(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->postJson('/chat/send', [
                'message' => ''
            ]);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['message']);
    }

    public function test_message_validation_limits_length(): void
    {
        $user = User::factory()->create();
        
        $longMessage = str_repeat('a', 4001);
        
        $response = $this->actingAs($user)
            ->postJson('/chat/send', [
                'message' => $longMessage
            ]);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['message']);
    }

    public function test_user_can_view_their_conversations(): void
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Conversation'
        ]);
        
        $response = $this->actingAs($user)
            ->get("/chat/{$conversation->id}");
        
        $response->assertStatus(200);
        $response->assertViewHas('currentConversation', $conversation);
    }

    public function test_user_cannot_view_other_users_conversations(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $conversation = Conversation::factory()->create([
            'user_id' => $user2->id
        ]);
        
        $response = $this->actingAs($user1)
            ->get("/chat/{$conversation->id}");
        
        $response->assertStatus(404);
    }

    public function test_user_can_delete_their_conversation(): void
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create([
            'user_id' => $user->id
        ]);
        
        $response = $this->actingAs($user)
            ->deleteJson("/chat/delete/{$conversation->id}");
        
        $response->assertStatus(200);
        $this->assertDatabaseMissing('conversations', [
            'id' => $conversation->id
        ]);
    }

    public function test_user_cannot_delete_other_users_conversations(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $conversation = Conversation::factory()->create([
            'user_id' => $user2->id
        ]);
        
        $response = $this->actingAs($user1)
            ->deleteJson("/chat/delete/{$conversation->id}");
        
        $response->assertStatus(404);
        $this->assertDatabaseHas('conversations', [
            'id' => $conversation->id
        ]);
    }

    public function test_sending_message_creates_conversation_if_none_exists(): void
    {
        $user = User::factory()->create();
        
        $this->assertEquals(0, Conversation::count());
        
        $response = $this->actingAs($user)
            ->postJson('/chat/send', [
                'message' => 'Nova conversa'
            ]);
        
        $response->assertStatus(200);
        $this->assertEquals(1, Conversation::count());
    }

    public function test_messages_are_sanitized(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->postJson('/chat/send', [
                'message' => '<script>alert("XSS")</script>Hello'
            ]);
        
        $response->assertStatus(200);
        
        $message = Message::where('sender', 'user')->first();
        $this->assertStringNotContainsString('<script>', $message->content);
    }
}

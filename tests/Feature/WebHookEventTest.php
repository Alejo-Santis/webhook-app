<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WebHookEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_processes_a_valid_message_sent_event()
    {
        $payload = [
            'event' => 'MessageSent',
            'timestamp' => now()->timestamp,
            'uuid' => 'test-uuid-001',
            'payload' => [
                'status' => 'delivered',
                'details' => 'Delivered successfully',
                'output' => 'OK',
                'time' => now()->toTimeString(),
                'sent_with_ssl' => true,
                'timestamp' => now()->toIso8601String(),
                'message' => [
                    'id' => 1,
                    'token' => 'abc123',
                    'to' => 'cliente@example.com',
                    'from' => 'noreply@example.com',
                    'subject' => 'Test Subject',
                    'timestamp' => now()->toIso8601String(),
                    'direction' => 'outbound',
                    'spam_status' => 'clean',
                    'tag' => 'test'
                ]
            ]
        ];

        $response = $this->postJson('/webhook', $payload);

        $response->assertStatus(200)
            ->assertJson([
                'message' => '✔️ Evento MessageSent registrado con éxito'
            ]);

        $this->assertDatabaseHas('message_sents', [
            'uuid' => 'test-uuid-001',
            'message_to' => 'cliente@example.com',
            'status' => 'delivered'
        ]);
    }
}

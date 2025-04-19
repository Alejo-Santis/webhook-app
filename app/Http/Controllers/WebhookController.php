<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\MessageSent;
use App\Models\MessageDelayed;
use App\Models\MessageDeliveryFailed;
use App\Models\MessageHeld;
use App\Models\MessageBounced;
use App\Models\MessageLinkClicked;
use App\Models\MessageLoaded;
use App\Models\DomainDnsError;

class WebhookController extends Controller
{
    /**
     * Procesa los webhooks recibidos de Relaynx
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function process(Request $request)
    {
        // Obtener el JSON del payload
        $payload = $request->getContent();
        $data = json_decode($payload);

        // Verificar si hay datos válidos
        if (!$data || !isset($data->event)) {
            return response()->json(['error' => 'Evento no especificado'], 400);
        }

        // Extraer información principal
        $event = $data->event;
        $timestamp = $data->timestamp ?? null;
        $uuid = $data->uuid ?? null;
        $payload = $data->payload ?? null;

        // Verificar si hay payload
        if (!$payload) {
            return response()->json(['error' => 'Payload no encontrado'], 400);
        }

        // Manejar diferentes tipos de eventos
        try {
            switch ($event) {
                case 'MessageSent':
                    $this->processMessageSent($payload, $event, $timestamp, $uuid);
                    break;
                case 'MessageDelayed':
                    $this->processMessageDelayed($payload, $event, $timestamp, $uuid);
                    break;
                case 'MessageDeliveryFailed':
                    $this->processMessageDeliveryFailed($payload, $event, $timestamp, $uuid);
                    break;
                case 'MessageHeld':
                    $this->processMessageHeld($payload, $event, $timestamp, $uuid);
                    break;
                case 'MessageBounced':
                    $this->processMessageBounced($payload, $event, $timestamp, $uuid);
                    break;
                case 'MessageLinkClicked':
                    $this->processMessageLinkClicked($payload, $event, $timestamp, $uuid);
                    break;
                case 'MessageLoaded':
                    $this->processMessageLoaded($payload, $event, $timestamp, $uuid);
                    break;
                case 'DomainDNSError':
                    $this->processDomainDnsError($payload, $event, $timestamp, $uuid);
                    break;
                default:
                    Log::warning("Evento desconocido recibido: {$event}", [
                        'uuid' => $uuid,
                        'timestamp' => $timestamp
                    ]);
                    return response()->json(['message' => 'Evento no soportado'], 422);
            }

            Log::info("Evento {$event} procesado correctamente", [
                'uuid' => $uuid
            ]);

            return response()->json([
                'message' => "✔️ Evento {$event} registrado con éxito"
            ], 200);
        } catch (\Exception $e) {
            Log::error("Error al procesar evento {$event}: " . $e->getMessage(), [
                'uuid' => $uuid,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Error interno al procesar el evento',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Procesa un evento MessageSent
     */
    private function processMessageSent($payload, $event, $timestamp, $uuid)
    {
        $data = [
            'status' => $payload->status ?? null,
            'details' => $payload->details ?? null,
            'output' => $payload->output ?? null,
            'time' => $payload->time ?? null,
            'sent_with_ssl' => $payload->sent_with_ssl ?? false,
            'timestamp' => $payload->timestamp ?? null,
            'event' => $event,
            'uuid' => $uuid
        ];

        // Procesar datos del mensaje
        if (isset($payload->message)) {
            $msg = $payload->message;
            $data = array_merge($data, [
                'message_id' => $msg->id ?? null,
                'message_token' => $msg->token ?? null,
                'message_direction' => $msg->direction ?? null,
                'message_message_id' => $msg->message_id ?? null,
                'message_to' => $msg->to ?? null,
                'message_from' => $msg->from ?? null,
                'message_subject' => $msg->subject ?? null,
                'message_timestamp' => $msg->timestamp ?? null,
                'message_spam_status' => $msg->spam_status ?? null,
                'message_tag' => $msg->tag ?? null
            ]);
        }

        // Datos adicionales de tiempo
        $data['date_linux'] = time();

        // Crear registro
        MessageSent::create($data);
    }

    /**
     * Procesa un evento MessageDelayed
     */
    private function processMessageDelayed($payload, $event, $timestamp, $uuid)
    {
        $data = [
            'status' => $payload->status ?? null,
            'details' => $payload->details ?? null,
            'output' => $payload->output ?? null,
            'time' => $payload->time ?? null,
            'sent_with_ssl' => $payload->sent_with_ssl ?? false,
            'timestamp' => $payload->timestamp ?? null,
            'event' => $event,
            'uuid' => $uuid
        ];

        // Procesar datos del mensaje
        if (isset($payload->message)) {
            $msg = $payload->message;
            $data = array_merge($data, [
                'message_id' => $msg->id ?? null,
                'message_token' => $msg->token ?? null,
                'message_direction' => $msg->direction ?? null,
                'message_message_id' => $msg->message_id ?? null,
                'message_to' => $msg->to ?? null,
                'message_from' => $msg->from ?? null,
                'message_subject' => $msg->subject ?? null,
                'message_timestamp' => $msg->timestamp ?? null,
                'message_spam_status' => $msg->spam_status ?? null,
                'message_tag' => $msg->tag ?? null
            ]);
        }

        // Datos adicionales de tiempo
        $data['date_linux'] = time();

        // Crear registro
        MessageDelayed::create($data);
    }

    /**
     * Procesa un evento MessageDeliveryFailed
     */
    private function processMessageDeliveryFailed($payload, $event, $timestamp, $uuid)
    {
        $data = [
            'status' => $payload->status ?? null,
            'details' => $payload->details ?? null,
            'output' => $payload->output ?? null,
            'time' => $payload->time ?? null,
            'sent_with_ssl' => $payload->sent_with_ssl ?? false,
            'timestamp' => $payload->timestamp ?? null,
            'event' => $event,
            'uuid' => $uuid
        ];

        // Procesar datos del mensaje
        if (isset($payload->message)) {
            $msg = $payload->message;
            $data = array_merge($data, [
                'message_id' => $msg->id ?? null,
                'message_token' => $msg->token ?? null,
                'message_direction' => $msg->direction ?? null,
                'message_message_id' => $msg->message_id ?? null,
                'message_to' => $msg->to ?? null,
                'message_from' => $msg->from ?? null,
                'message_subject' => $msg->subject ?? null,
                'message_timestamp' => $msg->timestamp ?? null,
                'message_spam_status' => $msg->spam_status ?? null,
                'message_tag' => $msg->tag ?? null
            ]);
        }

        // Datos adicionales de tiempo
        $data['date_linux'] = time();

        // Crear registro
        MessageDeliveryFailed::create($data);
    }

    /**
     * Procesa un evento MessageHeld
     */
    private function processMessageHeld($payload, $event, $timestamp, $uuid)
    {
        $data = [
            'status' => $payload->status ?? null,
            'details' => $payload->details ?? null,
            'output' => $payload->output ?? null,
            'time' => $payload->time ?? null,
            'sent_with_ssl' => $payload->sent_with_ssl ?? false,
            'timestamp' => $payload->timestamp ?? null,
            'event' => $event,
            'uuid' => $uuid
        ];

        // Procesar datos del mensaje
        if (isset($payload->message)) {
            $msg = $payload->message;
            $data = array_merge($data, [
                'message_id' => $msg->id ?? null,
                'message_token' => $msg->token ?? null,
                'message_direction' => $msg->direction ?? null,
                'message_message_id' => $msg->message_id ?? null,
                'message_to' => $msg->to ?? null,
                'message_from' => $msg->from ?? null,
                'message_subject' => $msg->subject ?? null,
                'message_timestamp' => $msg->timestamp ?? null,
                'message_spam_status' => $msg->spam_status ?? null,
                'message_tag' => $msg->tag ?? null
            ]);
        }

        // Datos adicionales de tiempo
        $data['date_linux'] = time();

        // Crear registro
        MessageHeld::create($data);
    }

    /**
     * Procesa un evento MessageBounced
     */
    private function processMessageBounced($payload, $event, $timestamp, $uuid)
    {
        $data = [
            'event' => $event,
            'timestamp' => $timestamp,
            'uuid' => $uuid,
            'date_linux' => time()
        ];

        // Procesar datos del mensaje original
        if (isset($payload->original_message)) {
            $orig = $payload->original_message;
            $data = array_merge($data, [
                'original_message_id' => $orig->id ?? null,
                'original_message_token' => $orig->token ?? null,
                'original_message_direction' => $orig->direction ?? null,
                'original_message_message_id' => $orig->message_id ?? null,
                'original_message_to' => $orig->to ?? null,
                'original_message_from' => $orig->from ?? null,
                'original_message_subject' => $orig->subject ?? null,
                'original_message_timestamp' => $orig->timestamp ?? null,
                'original_message_spam_status' => $orig->spam_status ?? null,
                'original_message_tag' => $orig->tag ?? null
            ]);
        }

        // Procesar datos del mensaje de rebote
        if (isset($payload->bounce)) {
            $bounce = $payload->bounce;
            $data = array_merge($data, [
                'bounce_id' => $bounce->id ?? null,
                'bounce_token' => $bounce->token ?? null,
                'bounce_direction' => $bounce->direction ?? null,
                'bounce_message_id' => $bounce->message_id ?? null,
                'bounce_to' => $bounce->to ?? null,
                'bounce_from' => $bounce->from ?? null,
                'bounce_subject' => $bounce->subject ?? null,
                'bounce_timestamp' => $bounce->timestamp ?? null,
                'bounce_spam_status' => $bounce->spam_status ?? null,
                'bounce_tag' => $bounce->tag ?? null
            ]);
        }

        // Crear registro
        MessageBounced::create($data);
    }

    /**
     * Procesa un evento MessageLinkClicked
     */
    private function processMessageLinkClicked($payload, $event, $timestamp, $uuid)
    {
        $data = [
            'url' => $payload->url ?? null,
            'token' => $payload->token ?? null,
            'ip_address' => $payload->ip_address ?? null,
            'user_agent' => $payload->user_agent ?? null,
            'event' => $event,
            'timestamp' => $timestamp,
            'uuid' => $uuid
        ];

        // Procesar datos del mensaje
        if (isset($payload->message)) {
            $msg = $payload->message;
            $data = array_merge($data, [
                'message_id' => $msg->id ?? null,
                'message_token' => $msg->token ?? null,
                'message_direction' => $msg->direction ?? null,
                'message_message_id' => $msg->message_id ?? null,
                'message_to' => $msg->to ?? null,
                'message_from' => $msg->from ?? null,
                'message_subject' => $msg->subject ?? null,
                'message_timestamp' => $msg->timestamp ?? null,
                'message_spam_status' => $msg->spam_status ?? null,
                'message_tag' => $msg->tag ?? null
            ]);
        }

        // Datos adicionales de tiempo
        $data['date_linux'] = time();

        // Crear registro
        MessageLinkClicked::create($data);
    }

    /**
     * Procesa un evento MessageLoaded
     */
    private function processMessageLoaded($payload, $event, $timestamp, $uuid)
    {
        $data = [
            'ip_address' => $payload->ip_address ?? null,
            'user_agent' => $payload->user_agent ?? null,
            'event' => $event,
            'timestamp' => $timestamp,
            'uuid' => $uuid
        ];

        // Procesar datos del mensaje
        if (isset($payload->message)) {
            $msg = $payload->message;
            $data = array_merge($data, [
                'message_id' => $msg->id ?? null,
                'message_token' => $msg->token ?? null,
                'message_direction' => $msg->direction ?? null,
                'message_message_id' => $msg->message_id ?? null,
                'message_to' => $msg->to ?? null,
                'message_from' => $msg->from ?? null,
                'message_subject' => $msg->subject ?? null,
                'message_timestamp' => $msg->timestamp ?? null,
                'message_spam_status' => $msg->spam_status ?? null,
                'message_tag' => $msg->tag ?? null
            ]);
        }

        // Datos adicionales de tiempo
        $data['date_linux'] = time();

        // Crear registro
        MessageLoaded::create($data);
    }

    /**
     * Procesa un evento DomainDNSError
     */
    private function processDomainDnsError($payload, $event, $timestamp, $uuid)
    {
        $data = [
            'domain' => $payload->domain ?? null,
            'uuid' => $payload->uuid ?? null,
            'dns_checked_at' => $payload->dns_checked_at ?? null,
            'spf_status' => $payload->spf_status ?? null,
            'spf_error' => $payload->spf_error ?? null,
            'dkim_status' => $payload->dkim_status ?? null,
            'dkim_error' => $payload->dkim_error ?? null,
            'mx_status' => $payload->mx_status ?? null,
            'mx_error' => $payload->mx_error ?? null,
            'return_path_status' => $payload->return_path_status ?? null,
            'return_path_error' => $payload->return_path_error ?? null,
            'event' => $event,
            'timestamp' => $timestamp
        ];

        // Crear registro
        DomainDnsError::create($data);
    }
}

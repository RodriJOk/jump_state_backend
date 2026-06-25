<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class MailgunService
{
    public function send(string $to, string $subject, string $html, ?string $text = null): void
    {
        $apiKey = config('services.mailgun.secret');
        $domain = config('services.mailgun.domain');

        if (empty($apiKey) || empty($domain)) {
            throw new RuntimeException('Mailgun no está configurado. Revisa MAILGUN_API_KEY y MAILGUN_DOMAIN.');
        }

        $endpoint = config('services.mailgun.endpoint', 'api.mailgun.net');
        $fromName = config('mail.from.name', config('app.name', 'JumpState'));
        $fromAddress = config('mail.from.address');

        $payload = [
            'from' => "{$fromName} <{$fromAddress}>",
            'to' => $to,
            'subject' => $subject,
            'html' => $html,
        ];

        if ($text !== null) {
            $payload['text'] = $text;
        }

        $response = Http::withBasicAuth('api', $apiKey)
            ->asForm()
            ->post("https://{$endpoint}/v3/{$domain}/messages", $payload);

        if ($response->failed()) {
            throw new RuntimeException(
                'Mailgun respondió con error: ' . $response->body(),
                $response->status()
            );
        }
    }
}

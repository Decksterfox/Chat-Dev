<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeepSeekService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('deepseek.api_key');
        $this->baseUrl = config('deepseek.base_url');
        
        if (empty($this->apiKey)) {
            throw new \RuntimeException(
                'DeepSeek API key is not configured. Please set DEEPSEEK_API_KEY in your .env file.'
            );
        }
    }

    public function sendMessage($message)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => 'deepseek-chat',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->getSystemPrompt()
                    ],
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 2000,
            ]);

            if ($response->successful()) {
                return $response->json()['choices'][0]['message']['content'];
            }

            Log::error('DeepSeek API Error: ' . $response->body());
            return 'Desculpe, ocorreu um erro ao processar sua mensagem.';

        } catch (\Exception $e) {
            Log::error('DeepSeek Service Exception: ' . $e->getMessage());
            return 'Desculpe, ocorreu um erro de conexão. Tente novamente.';
        }
    }

    private function getSystemPrompt()
    {
        return "Você é o Professor Jubileu, um assistente de IA especializado em ensinar programação para iniciantes em Análise e Desenvolvimento de Sistemas.

Diretrizes:
- Seja claro e use exemplos práticos
- Adapte sua explicação ao nível do aluno
- Use analogias do mundo real quando útil
- Forneça exemplos de código quando relevante
- Encoraje a prática e experimentação

Formatação:
- **Negrito** para termos importantes
- *Itálico* para ênfase
- Blocos de código com syntax highlighting
- Listas para passos ou itens";
    }
}

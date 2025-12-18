<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AIController extends Controller
{
    public function enhanceText(Request $request)
    {
        $request->validate([
            'userInput' => 'required|string',
            'action' => 'required|string|in:make_better,make_longer,fix_grammar',
        ]);

        $userInput = $request->input('userInput');
        $action = $request->input('action');

        $prompts = [
            'make_better' => "Improve the clarity, flow, and quality of the following text. Return ONLY the improved text with no explanations, no intros, no outros, no markdown, and no additional words.",
            'make_longer' => "Expand the following text to make it more detailed and comprehensive. Return ONLY the expanded text with no explanations, no intros, no outros, no markdown, and no additional words.",
            'fix_grammar' => "Correct the grammar and spelling of the following text without changing its meaning. Return ONLY the corrected text with no explanations, no intros, no outros, no markdown, and no additional words."
        ];

        $systemPrompt = $prompts[$action] ?? $prompts['make_better'];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                'Content-Type' => 'application/json',
                'HTTP-Referer' => url('/'),
                'X-Title' => 'Text Enhancer',
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'openai/gpt-oss-20b:free',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userInput],
                ],
                'temperature' => 0.7,
                'max_tokens' => 10000,
            ]);

            if ($response->failed()) {
                Log::error('AI API Error: ' . $response->body());
                throw new \Exception(__('AI Provider Error: :status', ['status' => $response->status()]));
            }

            $data = $response->json();
            $result = $data['choices'][0]['message']['content'] ?? __('No response received.');

            return response()->json([
                'result' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Core\ServiceBuilder;

class ChatController extends Controller
{
    public function show()
    {
        return view('chat');
    }

    public function sendMessage(Request $request)
    {
        try {
            $message = $request->input('message');
            $response = $this->generateResponse($message);
            
            return response()->json([
                'response' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'response' => 'Sorry, I encountered an error. Please try again.'
            ], 500);
        }
    }

    private function generateResponse($message)
    {
       
        $apiKey = config('gemini.api_key');
        
        if (!$apiKey) {
            throw new \Exception('Gemini API key not configured');
        }

        $client = new \GuzzleHttp\Client();
        
        $response = $client->post('https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'key' => $apiKey
            ],
            'json' => [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $message]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ]
            ]
        ]);

        $result = json_decode($response->getBody(), true);
        
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return $result['candidates'][0]['content']['parts'][0]['text'];
        }
        
        throw new \Exception('Invalid response from Gemini API');
    }
}
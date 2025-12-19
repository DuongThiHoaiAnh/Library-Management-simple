<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function send(Request $request)
    {
        $question = trim($request->message);

        if (!$question) {
            return response()->json([
                'reply' => "Chào bạn! 😊 Bạn có muốn mình gợi ý một cuốn sách hay không?"
            ]);
        }

        $prompt = "
Bạn là một chatbot AI thân thiện, trò chuyện với người dùng về sách như một người bạn mê sách.
Trả lời trực tiếp, dễ hiểu, chỉ một câu ngắn gọn và trọng tâm.
Nếu không biết rõ, hãy nói: 'Mình chưa rõ, nhưng bạn có thể thử đọc các thể loại sách liên quan.'.

Câu hỏi: $question
";

        try {
            $response = Http::timeout(45)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'x-goog-api-key' => env('GEMINI_API_KEY'),
                ])
                ->post(
                    'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent',
                    [
                        'contents' => [
                            ['parts' => [['text' => $prompt]]]
                        ]
                    ]
                );

            $data = $response->json();

            $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if ($reply) {
                $reply = trim(explode("\n", $reply)[0]);
                $reply = strlen($reply) > 200 ? substr($reply, 0, 200) . '...' : $reply;
            } else {

                $reply = "Mình vẫn ở đây 😊 Hãy thử hỏi lại hoặc nhờ mình gợi ý sách!";
            }
        } catch (\Throwable $e) {

            $reply = "Mình vẫn sẵn sàng trò chuyện 😊 Bạn có muốn mình gợi ý một cuốn sách hay không?";
        }

        return response()->json(['reply' => $reply]);
    }
}

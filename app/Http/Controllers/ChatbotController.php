<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function __construct(protected ChatbotService $chatbotService)
    {
    }

    /**
     * Handle chat request from the AI Chatbot Widget.
     */
    public function ask(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'message' => 'required|string|max:1000',
                'history' => 'nullable|array',
            ]);

            $result = $this->chatbotService->generateReply(
                $validated['message'],
                $validated['history'] ?? []
            );

            return response()->json([
                'status' => 'success',
                'reply' => $result['reply'],
                'suggested_courses' => $result['suggested_courses'],
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('ChatbotController Error: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'status' => 'success',
                'reply' => '👋 Chào bạn! Mình đã nhận được câu hỏi. Bạn có thể xem ngay danh sách khóa học nổi bật trên hệ thống Indochine (React, Laravel, UI/UX Design) hoặc để lại thông tin liên hệ để được tư vấn viên hỗ trợ trực tiếp nhé!',
                'suggested_courses' => [],
            ], 200);
        }
    }
}

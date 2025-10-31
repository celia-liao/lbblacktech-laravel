<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * 獲取所有已綁定 LINE 的使用者
     * 
     * @return JsonResponse
     */
    public function getAllBoundUsers(): JsonResponse
    {
        try {
            $users = Pet::select('pet_id', 'line_user_id')
                ->whereNotNull('line_user_id')
                ->where('line_user_id', '!=', '')
                ->get()
                ->map(function ($user) {
                    return [
                        'pet_id' => (int) $user->pet_id,
                        'line_user_id' => $user->line_user_id
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}


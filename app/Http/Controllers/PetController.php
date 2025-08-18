<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * 根據slug顯示寵物紀念頁面
     */
    public function show($slug)
    {
        try {
            // 根據slug查找寵物
            $pet = Pet::where('slug', $slug)
                      ->where('is_public', true)
                      ->firstOrFail();

            // 增加瀏覽次數
            $pet->increment('view_count');

            // 回傳視圖
            return view('pets.memorial', compact('pet'));
            
        } catch (\Exception $e) {
            // 如果找不到，返回404
            abort(404, '找不到該毛孩的紀念頁面');
        }
    }
}

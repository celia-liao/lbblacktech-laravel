<?php

namespace App\Models\Traits;

use Illuminate\Http\UploadedFile;

trait StoresPetImages
{
    /**
     * 儲存圖片並回傳檔名
     */
    public function storePetImage(UploadedFile $file, string $type): string
    {
        // 從關聯的 Pet 取得 slug，如果沒有就用 default
        $slug = $this->pet->website_slug ?? 'default';

        // 根據類型決定要放哪個子資料夾
        $subPath = match ($type) {
            'background' => "image/main/life/background",
            'photo'      => "image/main/life/photo",
            'original'   => "image/main/life/photo/original",
            default      => "uploads",
        };

        // 組合完整路徑
        $path = "pets/{$slug}/{$subPath}";

        // 用原始檔名（之後可以改成 uniqid()）
        $filename = $file->getClientOriginalName();

        // 儲存檔案到 public disk
        $file->storeAs($path, $filename, 'public');

        return $filename; // DB 欄位只存檔名
    }

    /**
     * 取得圖片完整 URL
     */
    public function getPetImageUrl(?string $filename, string $type): ?string
    {
        if (!$filename) return null;

        $slug = $this->pet->website_slug ?? 'default';

        $subPath = match ($type) {
            'background' => "image/main/life/background",
            'photo'      => "image/main/life/photo",
            'original'   => "image/main/life/photo/original",
            default      => "uploads",
        };

        return asset("storage/pets/{$slug}/{$subPath}/{$filename}");
    }
}

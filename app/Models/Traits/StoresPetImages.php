<?php

namespace App\Models\Traits;

use Illuminate\Http\UploadedFile;

trait StoresPetImages
{
    /* Timeline Event */
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

    /* Photo Gallery */
    public function getPhotoGalleryImageUrl(?string $filename): ?string
    {
        if (!$filename) return null;

        $slug = $this->pet->website_slug ?? 'default';
    
        switch ($this->photo_category) {
            case 'header':
                return asset("storage/pets/{$slug}/image/header/photo/{$filename}");
            case 'bubble_small':
                return asset("storage/pets/{$slug}/image/main/bobs/photo/{$filename}");
            case 'bubble_large':
                return asset("storage/pets/{$slug}/image/main/bobs/photo/original/{$filename}");
            case 'loading_people':
                return asset("storage/pets/{$slug}/image/loading/people/{$filename}");
            case 'loading_pet':
                return asset("storage/pets/{$slug}/image/loading/pet/{$filename}");
            case 'letter_photo':
                return asset("storage/pets/{$slug}/image/main/letter/photo/{$filename}");
            default:
                return asset("storage/pets/{$slug}/uploads/{$filename}");
        }
    }

    public function storePhotoGalleryImage(UploadedFile $file, string $category): string
    {
        // 從關聯的 Pet 取得 slug，如果沒有就用 default
        $slug = $this->pet->website_slug ?? 'default';

        // 根據類別決定要放哪個子資料夾
        $subPath = match ($category) {
            'header' => "image/header/photo",
            'bubble_small' => "image/main/bobs/photo",
            'bubble_large' => "image/main/bobs/photo/original",
            'loading_people' => "image/loading/people",
            'loading_pet' => "image/loading/pet",
            'hand_n' => "image/main/interaction/photo",
            'hand_p' => "image/main/interaction/photo",
            'letter_photo' => "image/main/letter/photo",
            default => "uploads",
        };

        // 組合完整路徑
        $path = "pets/{$slug}/{$subPath}";

        // 使用原始文件名
        $filename = $file->getClientOriginalName();

        // 儲存檔案到 public disk
        $file->storeAs($path, $filename, 'public');

        // 返回文件名
        return $filename;
    }

    /* Life Slide */
    public function getLifeSlideUrl(?string $filename, string $type): ?string
    {
        if (!$filename) return null;

        $slug = $this->pet->website_slug ?? 'default';
        $subPath = match ($type) {
            'image' => "image/main/film/photo",
            'video' => "image/main/film/photo/video/mp4",
            default => "uploads",
        };
        return asset("storage/pets/{$slug}/{$subPath}/{$filename}");
    }

    public function storeLifeSlide(UploadedFile $file, string $type): string
    {
        // 從關聯的 Pet 取得 slug，如果沒有就用 default
        $slug = $this->pet->website_slug ?? 'default';

        // 根據類別決定要放哪個子資料夾
        $subPath = match ($type) {
            'image' => "image/main/film/photo",
            'video' => "image/main/film/photo/video/mp4",
            default => "uploads",
        };

        // 組合完整路徑
        $path = "pets/{$slug}/{$subPath}";

        // 使用原始文件名
        $filename = $file->getClientOriginalName();

        // 儲存檔案到 public disk
        $file->storeAs($path, $filename, 'public');

        // 返回文件名
        return $filename;
    }

    /* Pet Video */
    public function getPetVideoUrl(?string $filename): ?string
    {
        if (!$filename) return null;

        $slug = $this->pet->website_slug ?? 'default';
        
        // 根據 category 決定路徑
        $subPath = match ($this->category) {
            'header' => "image/header/photo",
            'bubble' => "image/main/interaction/photo",
            default => "image/main/interaction/photo",
        };
        
        return asset("storage/pets/{$slug}/{$subPath}/{$filename}");
    }

    public function storePetVideo(UploadedFile $file): string
    {
        // 從關聯的 Pet 取得 slug，如果沒有就用 default
        $slug = $this->pet->website_slug ?? 'default';

        // 根據 category 決定子路徑
        $subPath = match ($this->category) {
            'header' => "image/header/photo",
            'bubble' => "image/main/interaction/photo",
            default => "image/main/interaction/photo",
        };

        // 組合完整路徑
        $path = "pets/{$slug}/{$subPath}";

        // 使用原始文件名
        $filename = $file->getClientOriginalName();

        // 儲存檔案到 public disk
        $file->storeAs($path, $filename, 'public');

        // 返回文件名
        return $filename;
    }
}





<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class FontSubsetService
{
    /**
     * 生成字體子集
     * 
     * @param string $text 要保留的文字（來自 slogan 或 letter_content）
     * @param string $slug Pet 的 website_slug
     * @return string 返回字體檔案的 asset URL
     * @throws \RuntimeException
     */
    public static function generateSubset($text, $slug)
    {
        // 獲取 Pet 及其相關的所有文字
        $pet = \App\Models\Pet::where('website_slug', $slug)->first();
        
        // 收集所有需要包含的文字
        $allTexts = [];
        
        // 添加傳入的文字
        if (!empty($text)) {
            $allTexts[] = $text;
        }
        
        // 如果找到 Pet，添加 slogan
        if ($pet && !empty($pet->slogan)) {
            $allTexts[] = $pet->slogan;
        }
        
        // 如果找到 Pet，添加 Letter content
        if ($pet && $pet->letter && !empty($pet->letter->letter_content)) {
            $allTexts[] = $pet->letter->letter_content;
        }
        
        // 合併所有文字，移除 HTML 標籤
        $combinedText = implode(' ', $allTexts);
        $cleanText = strip_tags($combinedText);
        
        // 如果沒有任何文字，返回空
        if (empty(trim($cleanText))) {
            Log::warning('沒有文字需要生成字體', ['slug' => $slug]);
            return '';
        }
        
        // Python 腳本路徑
        $scriptPath = base_path('python_scripts/subset_font_fontforge.py');
        
        // 輸入字體路徑（完整字體檔案）
        // 使用 public/assets/fonts 下的字體作為輸入
        $inputFont = public_path('assets/fonts/ChenYuluoyan-Thin.ttf');
        
        // 臨時字元檔案
        $keepCharsFile = base_path('python_scripts/keep_chars.txt');
        
        // 輸出目錄和檔案
        $outputDir = base_path('python_scripts/output');
        $outputFont = "{$outputDir}/ChenYuluoyan-Thin.ttf";
        
        // 確保輸出目錄存在
        if (!File::exists($outputDir)) {
            File::makeDirectory($outputDir, 0755, true);
        }
        
        // 將合併後的文字寫入 keep_chars.txt
        file_put_contents($keepCharsFile, $cleanText);
        
        // 檢查輸入字體是否存在
        if (!File::exists($inputFont)) {
            throw new \RuntimeException("完整字體檔案不存在：{$inputFont}");
        }
        
        // 檢查 Python 腳本是否存在
        if (!File::exists($scriptPath)) {
            throw new \RuntimeException("Python 腳本不存在：{$scriptPath}");
        }
        
        // 執行 fontforge 腳本
        // 使用 fontforge -script 來執行 Python 腳本
        $process = new Process([
            'fontforge',
            '-script',
            $scriptPath,
            $inputFont,
            $outputFont,
            $keepCharsFile
        ]);
        
        $process->setTimeout(180); // 設定 3 分鐘超時
        $process->run();
        
        // 記錄執行結果
        Log::info('FontSubset Process Output:', [
            'output' => $process->getOutput(),
            'error' => $process->getErrorOutput(),
            'success' => $process->isSuccessful()
        ]);
        
        // 錯誤處理
        if (!$process->isSuccessful()) {
            throw new \RuntimeException(
                "字體生成失敗：" . $process->getErrorOutput()
            );
        }
        
        // 檢查輸出檔案是否成功生成
        if (!File::exists($outputFont)) {
            throw new \RuntimeException("字體檔案生成失敗，輸出檔案不存在");
        }
        
        // 根據 slug 建立目標目錄
        $targetDir = public_path("storage/pets/{$slug}/font");
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }
        
        // 複製輸出字體到目標位置
        $targetPath = "{$targetDir}/ChenYuluoyan-Thin.ttf";
        File::copy($outputFont, $targetPath);
        
        // 回傳給前端可用的 asset() 路徑
        $assetUrl = asset("storage/pets/{$slug}/font/ChenYuluoyan-Thin.ttf");
        
        Log::info('字體子集生成成功', [
            'slug' => $slug,
            'combined_text' => $cleanText,
            'text_length' => mb_strlen($cleanText),
            'sources' => [
                'slogan' => $pet && $pet->slogan ? '✓' : '✗',
                'letter' => $pet && $pet->letter ? '✓' : '✗',
            ],
            'output_path' => $targetPath,
            'asset_url' => $assetUrl
        ]);
        
        return $assetUrl;
    }

    /**
     * 為 TimelineEvent 生成 GenSenRounded 字體子集
     * 
     * @param string $slug Pet 的 website_slug
     * @return array 返回兩個字體檔案的 asset URL ['bold' => url, 'regular' => url]
     * @throws \RuntimeException
     */
    public static function generateGenSenRoundedSubset($slug)
    {
        // 獲取 Pet 及其所有 TimelineEvent
        $pet = \App\Models\Pet::where('website_slug', $slug)->first();
        
        if (!$pet) {
            Log::warning('找不到 Pet', ['slug' => $slug]);
            return ['bold' => '', 'regular' => ''];
        }
        
        // 收集所有 TimelineEvent 的文字
        $timelineEvents = $pet->timelineEvents;
        $allTexts = [];
        
        foreach ($timelineEvents as $event) {
            if (!empty($event->event_title)) {
                $allTexts[] = $event->event_title;
            }
            if (!empty($event->event_description)) {
                $allTexts[] = $event->event_description;
            }
        }
        
        // 合併所有文字（主標題 + 副標題）
        $combinedText = strip_tags(implode(' ', $allTexts));
        
        $results = [];
        
        // 生成 Bold 字體（包含所有文字）
        if (!empty($combinedText)) {
            $results['bold'] = self::generateGenSenFont($combinedText, $slug, 'B');
        } else {
            $results['bold'] = '';
        }
        
        // 生成 Regular 字體（包含所有文字）
        if (!empty($combinedText)) {
            $results['regular'] = self::generateGenSenFont($combinedText, $slug, 'R');
        } else {
            $results['regular'] = '';
        }
        
        return $results;
    }

    /**
     * 生成 GenSenRounded 字體子集（內部方法）
     * 
     * @param string $text 要保留的文字
     * @param string $slug Pet 的 website_slug
     * @param string $weight 字體粗細 ('B' 或 'R')
     * @return string 返回字體檔案的 asset URL
     */
    private static function generateGenSenFont($text, $slug, $weight = 'B')
    {
        $fontFileName = "GenSenRounded2TW-{$weight}-subset.otf";
        
        // Python 腳本路徑
        $scriptPath = base_path('python_scripts/subset_font_fontforge.py');
        
        // 輸入字體路徑
        $inputFont = public_path("assets/fonts/GenSenRounded2TW-{$weight}-subset.otf");
        
        // 臨時字元檔案
        $keepCharsFile = base_path("python_scripts/keep_chars_{$weight}.txt");
        
        // 輸出目錄和檔案
        $outputDir = base_path('python_scripts/output');
        $outputFont = "{$outputDir}/{$fontFileName}";
        
        // 確保輸出目錄存在
        if (!File::exists($outputDir)) {
            File::makeDirectory($outputDir, 0755, true);
        }
        
        // 將文字寫入 keep_chars 檔案
        file_put_contents($keepCharsFile, $text);
        
        // 檢查輸入字體是否存在
        if (!File::exists($inputFont)) {
            throw new \RuntimeException("完整字體檔案不存在：{$inputFont}");
        }
        
        // 檢查 Python 腳本是否存在
        if (!File::exists($scriptPath)) {
            throw new \RuntimeException("Python 腳本不存在：{$scriptPath}");
        }
        
        // 執行 fontforge 腳本
        $process = new Process([
            'fontforge',
            '-script',
            $scriptPath,
            $inputFont,
            $outputFont,
            $keepCharsFile
        ]);
        
        $process->setTimeout(180);
        $process->run();
        
        // 記錄執行結果
        Log::info("GenSenRounded-{$weight} Process Output:", [
            'output' => $process->getOutput(),
            'error' => $process->getErrorOutput(),
            'success' => $process->isSuccessful()
        ]);
        
        // 錯誤處理
        if (!$process->isSuccessful()) {
            throw new \RuntimeException(
                "GenSenRounded-{$weight} 字體生成失敗：" . $process->getErrorOutput()
            );
        }
        
        // 檢查輸出檔案是否成功生成
        if (!File::exists($outputFont)) {
            throw new \RuntimeException("GenSenRounded-{$weight} 字體檔案生成失敗");
        }
        
        // 根據 slug 建立目標目錄
        $targetDir = public_path("storage/pets/{$slug}/font");
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }
        
        // 複製輸出字體到目標位置
        $targetPath = "{$targetDir}/{$fontFileName}";
        File::copy($outputFont, $targetPath);
        
        // 回傳給前端可用的 asset() 路徑
        $assetUrl = asset("storage/pets/{$slug}/font/{$fontFileName}");
        
        Log::info("GenSenRounded-{$weight} 字體子集生成成功", [
            'slug' => $slug,
            'weight' => $weight,
            'text_length' => mb_strlen($text),
            'output_path' => $targetPath,
            'asset_url' => $assetUrl
        ]);
        
        return $assetUrl;
    }
}


<?php

namespace App\Nova\Actions;

use App\Models\PetWhisper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class GenerateBreedWhispers extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = '生成愛寵小語';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $selectedBreed = $fields->breed;
        
        $breedWhispers = [
            '狗' => [
                '你剛剛是說吃點心嗎?',
                '你終於回來了!',
                '你還在忙嗎?要散步了嗎?',
                '我出去玩了!等等回來',
                '我都有在這裡想著你喔',
                '你說的永遠都是對的!',
                '你還記得我嗎?我永遠不會忘記你喔',
                '今天有好吃的嗎?',
                '我們什麼時候要一起玩!',
                '汪汪!'
            ],
            '貓' => [
                '欸欸 我的碗空了',
                '我在睡覺啦',
                '我偶爾也會想起你',
                '要吃點心了嗎?',
                '這是我今天抓到的獵物🐟',
                '這裡沒有你的腿躺起來舒服',
                '我現在可以陪你玩一下喔',
                '找我是要拍拍嗎?',
                '呼嚕嚕~呼嚕嚕',
                '喵嗚'
            ],
            '刺蝟' => [
                '嗅嗅 我就知道是你!',
                '要吃點心了嗎?',
                '我偶爾也會想起你啦',
                '不要偷看我啦',
                '現在是睡覺時間哦',
                '我要去找蟲蟲來吃',
                '這裡沒有你的腿躺起來舒服',
                '舔舔 甚麼味道?',
                '我可以在這裡盡情跑跳哦',
                '呼嚕嚕~呼嚕嚕'
            ]
        ];

        if (!isset($breedWhispers[$selectedBreed])) {
            return ActionResponse::danger("請選擇有效的品種！");
        }

        // 先檢查所有選中的寵物是否已經有小語
        $petsWithWhispers = [];
        $petsWithoutWhispers = [];

        foreach ($models as $pet) {
            $existingWhispers = PetWhisper::where('pet_id', $pet->pet_id)->count();
            
            if ($existingWhispers > 0) {
                $petsWithWhispers[] = $pet->pet_name;
            } else {
                $petsWithoutWhispers[] = $pet;
            }
        }

        // 如果有寵物已經有小語，則不執行並返回錯誤
        if (!empty($petsWithWhispers)) {
            $petNames = implode('、', $petsWithWhispers);
            return ActionResponse::danger("以下寵物已經有小語，無法重複生成：{$petNames}");
        }

        // 如果沒有寵物可以生成小語
        if (empty($petsWithoutWhispers)) {
            return ActionResponse::message("沒有找到可以生成小語的寵物。");
        }

        $generatedCount = 0;

        // 為沒有小語的寵物生成小語
        foreach ($petsWithoutWhispers as $pet) {
            foreach ($breedWhispers[$selectedBreed] as $content) {
                PetWhisper::create([
                    'pet_id' => $pet->pet_id,
                    'content' => $content
                ]);
            }
            $generatedCount++;
        }

        return ActionResponse::message("成功為 {$generatedCount} 隻寵物生成了 {$selectedBreed} 的小語！");
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('選擇品種', 'breed')
                ->options([
                    '狗' => '狗',
                    '貓' => '貓',
                    '刺蝟' => '刺蝟'
                ])
                ->rules('required')
                ->help('生成愛寵小語')
        ];
    }
}

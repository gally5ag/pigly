<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterStep1Request;
use App\Http\Requests\RegisterStep2Request;
use App\Actions\Fortify\CreateNewUser;
use App\Models\WeightTarget;
use App\Models\WeightLog;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Step1 画面表示
    public function createStep1()
    {
        return view('auth.register.step1');
    }

    // Step1 送信：バリデOK → Fortify のアクションでユーザー作成 → そのままログイン → step2へ
    public function storeStep1(RegisterStep1Request $request, CreateNewUser $creator)
    {
        $data = $request->validated();
        $user = $creator->create($data);

        Auth::login($user);

        return redirect()->route('register.step2.create');
    }

    // Step2 画面（ダミー）
    public function createStep2()
    {
        return view('auth.register.step2');
    }
    // --- Step2 保存 ---
    public function storeStep2(RegisterStep2Request $request)
    {
        $userId = Auth::id();

        // 目標体重を保存（既にあれば更新）
        WeightTarget::updateOrCreate(
            ['user_id' => $userId],
            ['target_weight' => $request->input('target_weight')]
        );

        // 現在の体重を「本日分の体重ログ」として保存（既にあれば更新）
        $today = today()->toDateString();
        WeightLog::updateOrCreate(
            ['user_id' => $userId, 'date' => $today],
            [
                'weight'           => $request->input('current_weight'),
                
                'calories'         => 0,
                'exercise_time'    => '00:00:00',
                'exercise_content' => null,
            ]
        );

        // 体重管理トップへ遷移（= アカウント作成完了）
        return redirect()->route('weight_logs')
            ->with('status', 'アカウントを作成しました');
    }
}

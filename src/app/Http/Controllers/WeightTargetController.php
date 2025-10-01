<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalSettingRequest;
use App\Models\WeightTarget;
use Illuminate\Support\Facades\Auth;

class WeightTargetController extends Controller
{
    public function edit()
    {
        $target = WeightTarget::where('user_id', Auth::id())
            ->latest('updated_at')
            ->first();

        return view('weight_logs.goal_setting', compact('target'));
    }

    public function update(GoalSettingRequest $request)
    {
        $value = $request->validated()['target_weight'];

        WeightTarget::updateOrCreate(
            ['user_id' => Auth::id()],
            ['target_weight' => $value]
        );
        return redirect()->route('weight_logs')->with('success', '目標体重を更新しました。');
    }
}

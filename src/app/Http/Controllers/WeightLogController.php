<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeightLogStoreRequest;
use App\Http\Requests\WeightLogRequest;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeightLogController extends Controller
{
    // 一覧表示
    public function index(Request $request)
    {
        $userId = Auth::id();

        // 目標体重（最新）
        $weightTarget = WeightTarget::where('user_id', $userId)
            ->latest('updated_at')
            ->first();

        // 一覧（8件/ページ）
        $logs = WeightLog::where('user_id', $userId)
            ->orderByDesc('date')
            ->paginate(8);

        // 現在体重＝最新ログの体重（全期間の最新1件）
        $latestLog = WeightLog::where('user_id', $userId)
            ->orderByDesc('date')
            ->first();
        $currentWeight = optional($latestLog)->weight ?? null;

        // 差 = 目標 - 現在（どちらか無ければ null）
        $diff = ($weightTarget && !is_null($currentWeight))
            ? round($weightTarget->target_weight - $currentWeight, 1)
            : null;

        // 初回表示は未検索なので null を渡す
        $from_date = null;
        $to_date   = null;
        $resultLabel = null;

        return view('weight_logs.index', compact(
            'weightTarget',
            'logs',
            'currentWeight',
            'diff',
            'from_date',
            'to_date',
            'resultLabel'
        ));
    }

    // 登録処理
    public function store(WeightLogStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        // 保存
        WeightLog::create([
            'user_id'          => $data['user_id'],
            'date'             => $data['date'],
            'weight'           => $data['weight'],
            'calories'         => $data['calories'],
            'exercise_time'    => $data['exercise_time'],
            'exercise_content' => $data['exercise_content'] ?? null,
        ]);

        return redirect()->route('weight_logs')->with('flash', '登録しました');
    }
    // 検索処理
    public function search(\App\Http\Requests\WeightLogSearchRequest $request)
    {
        $userId    = \Illuminate\Support\Facades\Auth::id();
        $from_date = $request->input('from_date'); // nullable
        $to_date   = $request->input('to_date');   // nullable

        // ① from > to の場合は自動で入れ替え（古い→新しい）
        if ($from_date && $to_date && $from_date > $to_date) {
            [$from_date, $to_date] = [$to_date, $from_date];
        }

        // 検索クエリ本体
        $query = \App\Models\WeightLog::where('user_id', $userId)
            ->when($from_date, fn($q) => $q->whereDate('date', '>=', $from_date))
            ->when($to_date,   fn($q) => $q->whereDate('date', '<=', $to_date))
            ->orderByDesc('date');

        // 一覧（ページング）
        $logs = $query->paginate(8)->appends($request->only('from_date', 'to_date'));

        // サマリー用の値（検索範囲内の最新を「現在体重」とする）
        $weightTarget  = \App\Models\WeightTarget::where('user_id', $userId)->latest('updated_at')->first();
        $latestInRange = (clone $query)->first();
        $currentWeight = optional($latestInRange)->weight ?? null;

        // 差 = 目標 - 現在（「目標まで」の値に向いた定義）
        $diff = ($weightTarget && !is_null($currentWeight))
            ? round($weightTarget->target_weight - $currentWeight, 1)
            : null;

        // ② 結果ラベル（例：2025/09/01〜2025/09/29 の検索結果 12件）
        $fmt = function ($d) {
            return \Carbon\Carbon::parse($d)->format('Y/m/d');
        };
        $rangeText = ($from_date ? $fmt($from_date) : '未指定') . '〜' . ($to_date ? $fmt($to_date) : '未指定');
        $resultLabel = ($from_date || $to_date)
            ? "{$rangeText} の検索結果　{$logs->total()}件"
            : null;

        return view('weight_logs.index', compact(
            'weightTarget',
            'logs',
            'currentWeight',
            'diff',
            'from_date',
            'to_date',
            'resultLabel'
        ));
    }


    public function edit(WeightLog $weightLog)
    {
        $this->authorizeOwner($weightLog);
        return view('weight_logs.edit', compact('weightLog'));
    }

    public function update(WeightLogRequest $request, WeightLog $weightLog)
    {
        $this->authorizeOwner($weightLog);

        $data = $request->validated();
        if (!empty($data['exercise_time']) && strlen($data['exercise_time']) === 5) {
            $data['exercise_time'] = $data['exercise_time'] . ':00';
        }

        $weightLog->update($data);

        return redirect()->route('weight_logs')->with('success', '記録を更新しました。');
    }
    public function destroy(WeightLog $weightLog)
    {
        $this->authorizeOwner($weightLog);
        $weightLog->delete();
        return redirect()->route('weight_logs');
    }

    public function goal()
    {
        return view('weight_logs.goal'); // 目標体重変更画面
    }

    private function authorizeOwner(WeightLog $log): void
    {
        abort_unless($log->user_id === Auth::id(), 403);
    }

    public function show(WeightLog $weightLog)
    {
        
        abort_if($weightLog->user_id !== Auth::id(), 404);

        return view('weight_logs.show', ['log' => $weightLog]); 
    }

}
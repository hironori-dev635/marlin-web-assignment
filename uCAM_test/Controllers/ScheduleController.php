<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $month = $request->month ?? date('Y-m');

        // 月の予定を取得
        $schedules = Schedule::where('date', 'like', "$month%")
            ->orderBy('date')
            ->get();

        // カレンダー（日付の配列を作る）
        $first = new \DateTime("$month-01");
        $last = (clone $first)->modify('last day of this month');
        $days = [];
        for ($d = clone $first; $d <= $last; $d->modify('+1 day')) {
            $date = $d->format('Y-m-d');
            $days[] = [
                'date' => $date,
                'events' => $schedules->where('date', $date)->values(),
            ];
        }

        return Inertia::render('Schedule/Index', [
            'month' => $month,
            'days' => $days,
        ]);
    }


public function index2(Request $request)
{
      // month パラメータを受け取る。なければ今月
    $month = $request->input('month', Carbon::now('Asia/Tokyo')->format('Y-m'));

    // Carbon で対象月の1日を作成
    $today = Carbon::createFromFormat('Y-m', $month, 'Asia/Tokyo');

    $start = $today->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d'); // カレンダー開始
    $end   = $today->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');     // カレンダー終了

    $schedules = Schedule::whereBetween('date', [
        $start,
        $end,
    ])->get();

    return Inertia::render('Schedule/Index2', [
       'month' => $month,
        'start' => $start,
        'end' => $end,
        'schedules' => $schedules,
       
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
          return Inertia::render('Schedule/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {//dd($request);
        $validated = $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'memo' => 'nullable|string',
            'color' => 'nullable|string|max:20',
          'start_time' => 'nullable|date_format:H:i',
          'end_time'   => 'nullable|date_format:H:i|after:start_time',
        ]);

        Schedule::create($validated);

        return redirect()->back();

//         return redirect()->back()->with('flash', [
//     'status' => 'success',
//     'message' => '登録しました！',
// ]);

//   return Inertia::render('Inertia/Index', [
//         'blogs' => InertiaTest::all(), // Index に必要なデータ
//         'flash' => [
//             'success' => '登録しました。',
//         ],
//     ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        //
    }



    public function week(Request $request)
{
    // 週の開始日取得（なければ今日の週の月曜日）
    // $weekStart = $request->input('week_start')
    //     ? Carbon::parse($request->input('week_start'))
    //     : Carbon::now('Asia/Tokyo')->startOfWeek(Carbon::SATURDAY);

        // month パラメータを受け取る。なければ今日
    $week = $request->input('week_start', Carbon::now('Asia/Tokyo')->format('Y-m-d'));

    // Carbon で対象月の1日を作成
    $now = Carbon::createFromFormat('Y-m-d', $week, 'Asia/Tokyo');
    //$now = Carbon::now('Asia/Tokyo');
 $weekStart = $now->copy()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
    $weekEnd = $now->copy()->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');

    // スケジュール取得
    $schedules = Schedule::whereBetween('date', [
        $weekStart,
        $weekEnd
    ])->get();

    return Inertia::render('Schedule/Week', [
        'weekStart' => $weekStart,
        'weekEnd' => $weekEnd,
        'schedules' => $schedules,
    ]);
}
public function calendar()
{
    $schedules = Schedule::select('title','date')->get();
//dd($schedules);
    return Inertia::render('Schedule/Calendar', [
        'schedules' => $schedules,
    ]);
}


public function WeeklyCalender()
{
    $schedules = Schedule::select('title','date','start_time','end_time')->get();
//dd($schedules);
    return Inertia::render('Schedule/WeeklyCalender', [
        'schedules' => $schedules,
    ]);
}

public function FullCalender()
{
    $schedules = Schedule::select('title','date','start_time','end_time')->get();
//dd($schedules);
    return Inertia::render('Schedule/FullCalender', [
        'schedules' => $schedules,
    ]);
}
}

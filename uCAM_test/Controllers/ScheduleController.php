<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'memo' => 'nullable|string',
            'color' => 'nullable|string|max:20',
        ]);

        Schedule::create($validated);

        return redirect()->back();
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
}

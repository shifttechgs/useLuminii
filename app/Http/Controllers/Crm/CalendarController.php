<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\ScheduledJob;
use App\Models\User;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $team = User::where('is_active', true)->orderBy('name')->get();
        $unscheduled = Job::whereDoesntHave('scheduledJob')
            ->whereNotIn('job_status', ['Completed', 'Cancelled'])
            ->with('client')
            ->orderBy('created_at', 'desc')
            ->get();

        $thisWeekJobs = ScheduledJob::with(['job.client'])
            ->whereBetween('scheduled_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $todayJobs = ScheduledJob::with(['job.client'])
            ->whereDate('scheduled_date', today())
            ->count();

        return view('crm.calendar.index', compact('team', 'unscheduled', 'thisWeekJobs', 'todayJobs'));
    }

    public function events()
    {
        $jobs = ScheduledJob::with(['job.client'])->get();

        $colors = [
            'New'        => ['bg' => '#6366f1', 'border' => '#4f46e5'],
            'Scheduled'  => ['bg' => '#2e90fa', 'border' => '#1570ef'],
            'InProgress' => ['bg' => '#f79009', 'border' => '#dc6803'],
            'Completed'  => ['bg' => '#12b76a', 'border' => '#039855'],
            'Cancelled'  => ['bg' => '#f04438', 'border' => '#d92d20'],
        ];

        $events = $jobs->map(function ($sj) use ($colors) {
            $status = $sj->job->job_status ?? 'New';
            $color  = $colors[$status] ?? $colors['New'];
            return [
                'id'              => $sj->id,
                'title'           => $sj->job->job_title ?? 'Job',
                'start'           => $sj->scheduled_date,
                'end'             => $sj->scheduled_end,
                'backgroundColor' => $color['bg'],
                'borderColor'     => $color['border'],
                'textColor'       => '#ffffff',
                'extendedProps'   => [
                    'job_id'   => $sj->job->job_id ?? null,
                    'client'   => $sj->job->client->full_name ?? 'N/A',
                    'status'   => $status,
                    'location' => $sj->location,
                    'notes'    => $sj->notes ?? null,
                    'member'   => $sj->teamMember->name ?? 'Unassigned',
                ],
            ];
        });

        return response()->json($events);
    }

    public function schedule(Request $request)
    {
        $data = $request->validate([
            'job_id'             => 'required|string|exists:crm_jobs,job_id',
            'team_member_id'     => 'nullable|exists:users,id',
            'job_type'           => 'required|in:Once-off,Recurring',
            'scheduled_date'     => 'required|date',
            'scheduled_end'      => 'nullable|date',
            'location'           => 'nullable|string|max:255',
            'notes'              => 'nullable|string',
        ]);

        $job = Job::where('job_id', $data['job_id'])->firstOrFail();

        ScheduledJob::updateOrCreate(
            ['job_id' => $data['job_id']],
            [
                'team_member_id' => $data['team_member_id'] ?? null,
                'job_type'       => $data['job_type'],
                'scheduled_date' => $data['scheduled_date'],
                'scheduled_end'  => $data['scheduled_end'] ?? null,
                'location'       => $data['location'] ?? null,
                'notes'          => $data['notes'] ?? null,
                'status'         => 'Scheduled',
            ]
        );

        $job->update([
            'job_status'              => 'Scheduled',
            'scheduled_status'        => 'Scheduled',
            'job_date_time'           => $data['scheduled_date'],
            'team_member_assigned_id' => $data['team_member_id'] ?? $job->team_member_assigned_id,
            'assigned_status'         => $data['team_member_id'] ? 'Assigned' : $job->assigned_status,
        ]);

        return back()->with('success', 'Job scheduled successfully.');
    }
}


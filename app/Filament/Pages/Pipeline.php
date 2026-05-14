<?php

namespace App\Filament\Pages;

use App\Models\Lead;
use App\Models\ActivityLog;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Pipeline extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-view-columns';
    protected static ?string $navigationGroup = 'CRM';
    protected static ?string $navigationLabel = 'Pipeline';
    protected static ?string $title           = 'Lead Pipeline';
    protected static ?int    $navigationSort  = 3;
    protected static string  $view            = 'filament.pages.pipeline';

    public static function getColumns(): array
    {
        return [
            'New'           => ['label' => 'New',           'color' => '#94a3b8', 'icon' => '📥'],
            'Contacted'     => ['label' => 'Contacted',     'color' => '#2e90fa', 'icon' => '📞'],
            'Qualified'     => ['label' => 'Qualified',     'color' => '#635bff', 'icon' => '⭐'],
            'Proposal Sent' => ['label' => 'Proposal Sent', 'color' => '#f79009', 'icon' => '📄'],
            'Converted'     => ['label' => 'Converted',     'color' => '#12b76a', 'icon' => '✅'],
            'Closed'        => ['label' => 'Closed',        'color' => '#64748b', 'icon' => '🔒'],
        ];
    }

    public function getLeads(): array
    {
        return Lead::with('assignedTo')
            ->whereNotIn('status', ['Converted', 'Closed'])
            ->orWhereIn('status', ['Converted', 'Closed'])
            ->orderByRaw("FIELD(priority, 'Urgent', 'High', 'Normal', 'Low')")
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('status')
            ->toArray();
    }

    public function moveCard(string $leadId, string $newStatus): void
    {
        $lead = Lead::where('lead_id', $leadId)->firstOrFail();
        $old  = $lead->status;

        $updates = ['status' => $newStatus];
        if ($newStatus === 'Contacted' && ! $lead->contacted_at) {
            $updates['contacted_at'] = now();
        }

        $lead->update($updates);

        ActivityLog::record('updated', 'Lead', $leadId,
            "Lead '{$lead->name}' moved {$old} → {$newStatus}");

        Notification::make()
            ->title("Moved to " . self::getColumns()[$newStatus]['label'])
            ->success()
            ->send();
    }

    public function updatePriority(string $leadId, string $priority): void
    {
        Lead::where('lead_id', $leadId)->update(['priority' => $priority]);
        Notification::make()->title("Priority updated to {$priority}")->success()->send();
    }
}

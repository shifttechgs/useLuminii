<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

/**
 * Personal builder funnel for the last 7 days (vs the 7 before): visitors, and the share of
 * them who downloaded a PDF, clicked Send, and left an email. Counts are anonymous and
 * per browser per day, so rates are approximate.
 */
class PersonalFunnelWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;
    protected ?string $heading = 'Personal builder (last 7 days)';
    protected static bool $isLazy = true;

    public static function canView(): bool
    {
        $user = auth()->user();

        // Platform data (the useLuminii website), so only the platform business's admins see it
        return $user && method_exists($user, 'isAdmin') && $user->isAdmin()
            && $user->business_id === \App\Support\CurrentBusiness::platform();
    }

    protected function getStats(): array
    {
        $now = now();
        $current = $this->counts($now->copy()->subDays(7), $now);
        $previous = $this->counts($now->copy()->subDays(14), $now->copy()->subDays(7));

        $stats = [
            Stat::make('Visitors', number_format($current['visit']))
                ->description($this->change($current['visit'], $previous['visit'], 'visitors'))
                ->color('gray'),
        ];

        foreach ([
            'pdf_download' => 'Downloaded a PDF',
            'send_click'   => 'Clicked Send',
            'email_left'   => 'Left an email',
        ] as $event => $label) {
            $rate = $this->rate($current[$event], $current['visit']);
            $prevRate = $this->rate($previous[$event], $previous['visit']);

            $stats[] = Stat::make($label, $rate === null ? '—' : $rate . '%')
                ->description(number_format($current[$event]) . ' total · ' . ($prevRate === null ? 'no data the week before' : 'was ' . $prevRate . '%'))
                ->color($rate !== null && $prevRate !== null ? ($rate >= $prevRate ? 'success' : 'danger') : 'gray');
        }

        return $stats;
    }

    /** @return array<string,int> */
    private function counts($from, $to): array
    {
        $rows = DB::table('personal_events')
            ->select('event', DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $from)
            ->where('created_at', '<', $to)
            ->groupBy('event')
            ->pluck('total', 'event');

        return [
            'visit'        => (int) ($rows['visit'] ?? 0),
            'pdf_download' => (int) ($rows['pdf_download'] ?? 0),
            'send_click'   => (int) ($rows['send_click'] ?? 0),
            'email_left'   => (int) ($rows['email_left'] ?? 0),
        ];
    }

    private function rate(int $part, int $whole): ?float
    {
        return $whole > 0 ? round($part / $whole * 100, 1) : null;
    }

    private function change(int $now, int $before, string $noun): string
    {
        if ($before === 0) {
            return $now > 0 ? 'none the week before' : 'no ' . $noun . ' yet';
        }
        $pct = round(($now - $before) / $before * 100);

        return ($pct >= 0 ? '+' : '') . $pct . '% vs the week before';
    }
}

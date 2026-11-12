<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * "What should we build first?" votes from the Personal early-access sign-ups (all time),
 * read from each lead's services_interested ("Wants: <label>"). Admins only.
 */
class PersonalVotesWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 3;
    protected ?string $heading = 'Personal: what should we build first?';
    protected static bool $isLazy = true;

    /** Same labels as PersonalEarlyAccessController::WANTS */
    public const OPTIONS = [
        'Client accepts the quote online',
        'Pay button (card or mobile money)',
        'Automatic payment reminders',
        'Know when the client opens it',
    ];

    public static function canView(): bool
    {
        $user = auth()->user();

        // Platform data (the useLuminii website), so only the platform business's admins see it
        return $user && method_exists($user, 'isAdmin') && $user->isAdmin()
            && $user->business_id === \App\Support\CurrentBusiness::platform();
    }

    /** @return array<string,int> label => votes */
    public static function tally(): array
    {
        $counts = array_fill_keys(self::OPTIONS, 0);

        // Small volume: read the early-access leads and count in PHP (portable across databases)
        Lead::query()
            ->where('source', 'website')
            ->whereNotNull('services_interested')
            ->select(['id', 'services_interested'])
            ->orderBy('id')
            ->chunk(500, function ($leads) use (&$counts) {
                foreach ($leads as $lead) {
                    $services = (array) $lead->services_interested;
                    if (! in_array('Personal: quotes and invoices', $services, true)) {
                        continue;
                    }
                    foreach ($services as $service) {
                        $label = str_starts_with((string) $service, 'Wants: ') ? substr($service, 7) : null;
                        if ($label !== null && array_key_exists($label, $counts)) {
                            $counts[$label]++;
                        }
                    }
                }
            });

        arsort($counts);

        return $counts;
    }

    protected function getStats(): array
    {
        $counts = self::tally();
        $total = array_sum($counts);
        $stats = [];
        $first = true;

        foreach ($counts as $label => $votes) {
            $share = $total > 0 ? round($votes / $total * 100) : 0;
            $stats[] = Stat::make($label, number_format($votes))
                ->description($total > 0 ? $share . '% of ' . number_format($total) . ' votes' : 'No votes yet')
                ->color($first && $votes > 0 ? 'success' : 'gray');
            $first = false;
        }

        return $stats;
    }
}

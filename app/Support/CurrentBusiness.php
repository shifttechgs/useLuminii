<?php

namespace App\Support;

use Illuminate\Support\Facades\Auth;

/**
 * Which business the current request or job is working for.
 *
 *   1. An explicit business set with set()/run(): the client hub (from the quote or
 *      invoice it opened), scheduled jobs (per record) and the public website forms.
 *   2. Otherwise the signed-in user's business. A signed-in user without a business
 *      gets NONE, which matches no rows: fail closed.
 *   3. Otherwise null: no filtering (guests, console). Code running there must look
 *      records up by an unguessable key or set a business explicitly.
 *
 * Only an already-resolved user is used (hasUser), so loading the user itself is
 * never filtered and can't recurse.
 */
class CurrentBusiness
{
    /** Matches no business: used for signed-in users who have none. */
    public const NONE = '__no_business__';

    private static ?string $override = null;

    public static function id(): ?string
    {
        if (self::$override !== null) {
            return self::$override;
        }

        $guard = Auth::guard();
        if (method_exists($guard, 'hasUser') && $guard->hasUser()) {
            return $guard->user()->business_id ?: self::NONE;
        }

        return null;
    }

    /** The business new records should belong to when nothing more specific is known. */
    public static function idOrPlatform(): string
    {
        return self::id() ?? self::platform();
    }

    public static function platform(): string
    {
        return (string) config('crm.business_id', 'ST-001');
    }

    public static function isPlatform(): bool
    {
        return self::id() === self::platform();
    }

    public static function set(?string $businessId): void
    {
        self::$override = $businessId;
    }

    /**
     * Run a callback as a given business, restoring the previous one afterwards.
     *
     * @template T
     * @param  callable():T  $callback
     * @return T
     */
    public static function run(?string $businessId, callable $callback): mixed
    {
        $previous = self::$override;
        self::$override = $businessId;

        try {
            return $callback();
        } finally {
            self::$override = $previous;
        }
    }
}

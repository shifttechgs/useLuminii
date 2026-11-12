<?php

namespace App\Models\Concerns;

use App\Models\Scopes\BusinessScope;
use App\Support\CurrentBusiness;

/**
 * Per-business data separation.
 *
 * - Every query is limited to the current business (BusinessScope).
 * - New records get a business_id: the one already set, else the parent record's
 *   (see businessParents()), else the current business, else the platform business.
 *
 * Models whose records can be created where nobody is signed in (PayPal, the client
 * hub, scheduled jobs) list their parents so they never fall back to the wrong business.
 */
trait BelongsToBusiness
{
    public static function bootBelongsToBusiness(): void
    {
        static::addGlobalScope(new BusinessScope());

        static::creating(function ($model) {
            if (! empty($model->business_id)) {
                return;
            }

            foreach ($model->businessParents() as $foreignKey => [$parentClass, $parentKey]) {
                $value = $model->getAttribute($foreignKey);
                if ($value === null || $value === '') {
                    continue;
                }
                $businessId = $parentClass::withoutGlobalScope(BusinessScope::class)
                    ->where($parentKey, $value)
                    ->value('business_id');
                if ($businessId) {
                    $model->business_id = $businessId;

                    return;
                }
            }

            $model->business_id = CurrentBusiness::idOrPlatform();
        });
    }

    /**
     * Parent records to inherit business_id from: [foreign key => [ParentModel::class, parent key]].
     *
     * @return array<string, array{0: class-string, 1: string}>
     */
    public function businessParents(): array
    {
        return [];
    }

    /** All businesses: for platform-level code that must see across businesses. */
    public static function allBusinesses()
    {
        return static::withoutGlobalScope(BusinessScope::class);
    }
}

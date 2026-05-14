<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password',
        'role', 'phone', 'avatar', 'business_id', 'is_active', 'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // Roles
    public const ROLES = [
        'SuperAdmin' => 'Super Admin',
        'Admin'      => 'Admin',
        'SalesRep'   => 'Sales Rep',
        'Technician' => 'Technician',
        'Engineer'   => 'Engineer',
        'Accountant' => 'Accountant',
        'Support'    => 'Support',
    ];

    public function isSuperAdmin(): bool   { return $this->role === 'SuperAdmin'; }
    public function isAdmin(): bool        { return in_array($this->role, ['SuperAdmin', 'Admin']); }
    public function isSalesRep(): bool     { return $this->role === 'SalesRep'; }
    public function isTechnician(): bool   { return $this->role === 'Technician'; }
    public function isEngineer(): bool     { return $this->role === 'Engineer'; }

    // Filament: control who can access the panel
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active && in_array($this->role, [
            'SuperAdmin', 'Admin', 'SalesRep', 'Technician', 'Engineer', 'Accountant', 'Support',
        ]);
    }

    // Relationships
    public function assignedClients(): HasMany
    {
        return $this->hasMany(BusinessClient::class, 'user_id');
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class, 'user_id');
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'user_id');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'user_id');
    }
}

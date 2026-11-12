<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Anonymous usage counts for the Personal quote/invoice builder (visits, PDF downloads,
 * Send clicks, emails left). No cookies, IDs or personal data: one row per event, and the
 * browser sends each event at most once a day.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_events', function (Blueprint $table) {
            $table->id();
            $table->string('event', 30);
            $table->string('doc_type', 10)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['event', 'created_at']);
        });

        // Supabase exposes public tables through its REST API; keep this one closed like the rest
        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE public.personal_events ENABLE ROW LEVEL SECURITY');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_events');
    }
};

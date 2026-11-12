<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Supabase exposes the `public` schema through its REST API (PostgREST), where the
 * public "anon" key can read and write any table that has row-level security off.
 * Laravel connects as the `postgres` role, which bypasses RLS, so turning RLS on with
 * no policies closes the REST API to these tables without affecting the app.
 *
 * Tables added by later migrations need RLS too: add a migration like this one, or
 * re-run its statement (it is safe to repeat).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement(<<<'SQL'
            DO $$
            DECLARE r record;
            BEGIN
                FOR r IN SELECT tablename FROM pg_tables WHERE schemaname = 'public' LOOP
                    EXECUTE format('ALTER TABLE public.%I ENABLE ROW LEVEL SECURITY', r.tablename);
                END LOOP;
            END $$;
        SQL);
    }

    public function down(): void
    {
        // Intentionally left on: turning RLS off would re-expose every table to the REST API.
    }
};

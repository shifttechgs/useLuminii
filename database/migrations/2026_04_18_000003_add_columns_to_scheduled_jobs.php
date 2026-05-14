<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scheduled_jobs', function (Blueprint $table) {
            if (! Schema::hasColumn('scheduled_jobs', 'team_member_id')) {
                $table->unsignedBigInteger('team_member_id')->nullable()->after('job_id');
            }
            if (! Schema::hasColumn('scheduled_jobs', 'job_type')) {
                $table->string('job_type')->default('Once-off')->after('team_member_id'); // Once-off | Recurring
            }
            if (! Schema::hasColumn('scheduled_jobs', 'repeats')) {
                $table->string('repeats')->nullable()->after('job_type'); // Daily | Weekly | Monthly
            }
            if (! Schema::hasColumn('scheduled_jobs', 'repeat_duration')) {
                $table->integer('repeat_duration')->nullable()->after('repeats');
            }
            if (! Schema::hasColumn('scheduled_jobs', 'location')) {
                $table->string('location')->nullable()->after('repeat_duration');
            }
            if (! Schema::hasColumn('scheduled_jobs', 'internal_notes')) {
                $table->text('internal_notes')->nullable()->after('notes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('scheduled_jobs', function (Blueprint $table) {
            $table->dropColumn(['team_member_id','job_type','repeats','repeat_duration','location','internal_notes']);
        });
    }
};


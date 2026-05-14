<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::defaultStringLength(191);

        Schema::create('quote_comments', function (Blueprint $table) {
            $table->id();
            $table->string('quote_id', 30)->index();
            $table->enum('author_type', ['client', 'team']);
            $table->string('author_name', 150);
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_comments');
    }
};

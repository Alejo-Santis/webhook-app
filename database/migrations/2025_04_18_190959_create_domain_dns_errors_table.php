<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('domain_dns_errors', function (Blueprint $table) {
            $table->id();
            $table->string('domain', 255)->nullable();
            $table->string('uuid', 100)->nullable();
            $table->string('dns_checked_at', 255)->nullable();
            $table->string('spf_status', 50)->nullable();
            $table->text('spf_error')->nullable();
            $table->string('dkim_status', 50)->nullable();
            $table->text('dkim_error')->nullable();
            $table->string('mx_status', 50)->nullable();
            $table->text('mx_error')->nullable();
            $table->string('return_path_status', 50)->nullable();
            $table->text('return_path_error')->nullable();
            $table->string('event', 50)->nullable();
            $table->string('timestamp', 255)->nullable(); // Optional
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domain_dns_errors');
    }
};

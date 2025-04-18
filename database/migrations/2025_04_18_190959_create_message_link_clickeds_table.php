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
        Schema::create('message_link_clickeds', function (Blueprint $table) {
            $table->id();
            $table->text('url')->nullable();
            $table->string('token', 255)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->integer('message_id')->nullable();
            $table->string('message_token', 255)->nullable();
            $table->string('message_direction', 50)->nullable();
            $table->string('message_message_id', 255)->nullable();
            $table->string('message_to', 255)->nullable();
            $table->string('message_from', 255)->nullable();
            $table->text('message_subject')->nullable();
            $table->string('message_timestamp', 255)->nullable();
            $table->string('message_spam_status', 50)->nullable();
            $table->string('message_tag', 255)->nullable();
            $table->text('org_system')->nullable();
            $table->bigInteger('date_linux')->nullable();
            $table->string('event', 50)->nullable();
            $table->string('timestamp', 255)->nullable();
            $table->string('uuid', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_link_clickeds');
    }
};

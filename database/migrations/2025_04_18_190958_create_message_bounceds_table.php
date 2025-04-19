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
        Schema::create('message_bounceds', function (Blueprint $table) {
            $table->id();
            $table->integer('original_message_id')->nullable();
            $table->string('original_message_token', 255)->nullable();
            $table->string('original_message_direction', 50)->nullable();
            $table->string('original_message_message_id', 255)->nullable();
            $table->string('original_message_to', 255)->nullable();
            $table->string('original_message_from', 255)->nullable();
            $table->text('original_message_subject')->nullable();
            $table->string('original_message_timestamp', 255)->nullable();
            $table->string('original_message_spam_status', 50)->nullable();
            $table->string('original_message_tag', 255)->nullable();

            $table->integer('bounce_id')->nullable();
            $table->string('bounce_token', 255)->nullable();
            $table->string('bounce_direction', 50)->nullable();
            $table->string('bounce_message_id', 255)->nullable();
            $table->string('bounce_to', 255)->nullable();
            $table->string('bounce_from', 255)->nullable();
            $table->text('bounce_subject')->nullable();
            $table->string('bounce_timestamp', 255)->nullable();
            $table->string('bounce_spam_status', 50)->nullable();
            $table->string('bounce_tag', 255)->nullable();

            $table->text('org_system')->nullable();
            $table->bigInteger('date_linux')->nullable();
            $table->string('event', 50)->nullable();
            $table->string('timestamp', 255)->nullable(); // Optional
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
        Schema::dropIfExists('message_bounceds');
    }
};

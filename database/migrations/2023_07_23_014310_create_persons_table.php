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
        Schema::create('persons', function (Blueprint $table) {
            $table->string('persons_document', 15);
            $table->string('persons_first_name', 50);
            $table->string('persons_middle_name', 50)->nullable();
            $table->string('persons_last_name', 50);
            $table->string('persons_second_surname', 50)->nullable();
            $table->string('persons_direction', 100)->nullable();
            $table->string('persons_phone', 20)->nullable();
            $table->string('persons_mobile', 15)->nullable()->default('0');
            $table->tinyInteger('persons_state')->nullable()->default(1);
            $table->string('persons_notes', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('persons_document');
            $table->index('persons_document');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};

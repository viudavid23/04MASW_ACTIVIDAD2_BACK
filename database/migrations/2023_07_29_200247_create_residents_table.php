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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('persons_document', 15);
            $table->date('residents_date_of_birth');//format YYYY-MM-DD
            $table->timestamp('residents_registration_date');
            $table->integer('residents_sons_number', false)->nullable();
            $table->string('residents_clothing_size', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('persons_document')->references('persons_document')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};

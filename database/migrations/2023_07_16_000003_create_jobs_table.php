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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('worker_id')->nullable();
            $table->unsignedBigInteger('service_type_id');
            $table->string('title');
            $table->string('job_code');
            $table->string('payment_type');
            $table->string('description')->nullabe()->default(null);
            $table->string('status')->default('New');
            $table->float('budget')->nullable()->default(0);
            $table->integer('rating')->default(0);
            $table->string('preferred_date');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('worker_id')->references('id')->on('users');
            $table->foreign('service_type_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};

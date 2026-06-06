<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name');
            $table->string('donor_phone');
            $table->string('donor_email')->nullable();
            $table->enum('package', ['level_01', 'level_02', 'level_03', 'custom']);
            $table->decimal('custom_amount', 15, 2)->nullable();
            $table->enum('commitment_type', ['pledge', 'paid'])->default('pledge');
            $table->enum('payment_method', ['transfer', 'cash'])->default('transfer');
            $table->string('transfer_proof')->nullable();
            $table->string('admin_proof')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};

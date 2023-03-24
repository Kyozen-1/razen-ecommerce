<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('duitku_reference', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->unsigned()->index();
            $table->string('reference');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duitku_reference');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redirect_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('redirect_id');
            $table->ipAddress('ip_address');
            $table->text('referer')->nullable();
            $table->text('query_params')->nullable();
            $table->timestamps();

            $table->foreign('redirect_id')->references('id')->on('redirects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('redirect_logs', function (Blueprint $table) {
            $table->dropForeign(['redirect_id']);
        });

        Schema::dropIfExists('redirect_logs');
    }
};

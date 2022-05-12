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
        Schema::create('cdrs', function (Blueprint $table) {
            $table->id('cdr_id');
            $table->integer('message_id')->nullable();
            $table->string('client')->nullable();
            $table->string('sender_id')->nullable();
            $table->string('message_text')->nullable();
            $table->string('status')->nullable();  
            $table->string('destination')->nullable();   
            $table->string('operator')->nullable();
            $table->string('country')->nullable();
            $table->string('delivery_status')->nullable();   
            $table->integer('terminator_message_id')->nullable();
            $table->dateTime('date_recieved')->nullable();
            $table->string('date_sent')->nullable();
            $table->string('date_dlr')->nullable();
            $table->boolean('fake')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cdrs');
    }
};

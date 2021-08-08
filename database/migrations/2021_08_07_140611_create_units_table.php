<?php

use App\Models\Unit;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('content');
            $table->bigInteger('chapter_id')->unsigned()->index();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->boolean('status')->default(Unit::INACTIVE);
            $table->integer('order')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}

<?php

use App\Models\Course;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->bigInteger('category_id')->unsigned()->index();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('institution_id')->unsigned();
            $table->bigInteger('instructor_id')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->boolean('status')->default(Course::PENDING);
            $table->boolean('isOnline')->default(Course::OFFLINE);
            $table->int('expiration');
            $table->timestamp('expires_at');
            $table->softDeletes();
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
        Schema::dropIfExists('courses');
    }
}

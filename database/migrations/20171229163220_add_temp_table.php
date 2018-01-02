<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTempTable extends Migration
{
    public function up()
    {
        $this->schema->create('temp', function (Blueprint $table) {
            $table->string('ip');
            $table->timestamp('last_active');
        });
    }

    public function down()
    {
        $this->schema->drop('temp');

    }
}

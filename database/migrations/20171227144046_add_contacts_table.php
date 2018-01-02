<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddContactsTable extends Migration
{
    public function up()
    {
        $this->schema->create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->boolean('subscribed');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('contacts');
    }
}

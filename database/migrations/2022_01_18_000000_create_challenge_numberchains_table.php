<?php

use Dalyio\Challenge\Traits\Migratable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallengeNumberchainsTable extends Migration
{
    use Migratable;
    
    protected $tableName = 'challenge_numberchains';
    protected $autoincrement = 1000000000;
    
    /**
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('starting_number')->unique();
            $table->integer('ending_number')->index();
            $table->integer('numberchain_count')->index();
        });
        
        $this->autoincrement();
    }
}

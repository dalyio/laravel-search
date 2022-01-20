<?php

use Dalyio\Challenge\Traits\Migratable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallengeNumberchainLinksTable extends Migration
{
    use Migratable;
    
    protected $tableName = 'challenge_numberchain_links';
    protected $autoincrement = 1000000000;
    
    /**
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numberchain_id')->comment('challenge_numberchains')->index();
            $table->integer('link_number')->index();
            $table->smallInteger('sequence')->index();
        });
        
        $this->autoincrement();
    }
}

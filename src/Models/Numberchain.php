<?php

namespace Dalyio\Challenge\Models;

use Illuminate\Database\Eloquent\Model;

class Numberchain extends Model
{
    /**
     * @var string
     */
    protected $table = 'challenge_numberchains';
    
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * @var array
     */
    protected $fillable = [
        'starting_number', 'ending_number', 'numberchain_count'
    ];
    
    /**
     * @var boolean
     */
    public $timestamps = false;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }
    
    /**
     * @return int
     */
    public function id()
    {
        return $this->getAttribute('id');
    }

    /**
     * @return int
     */
    public function startingNumber()
    {
        return $this->getAttribute('starting_number');
    }
    
    /**
     * @return int
     */
    public function endingNumber()
    {
        return $this->getAttribute('ending_number');
    }
    
    /**
     * @return int
     */
    public function numberchainCount()
    {
        return $this->getAttribute('numberchain_count');
    }
    
    /**
     * @return \Dalyio\Challenge\Models\Numberchain\Link[]
     */
    public function numberchain()
    {
        return $this->hasMany(\Dalyio\Challenge\Models\Numberchain\Link::class, 'numberchain_id', 'id')
                ->orderBy('sequence')
                ->get();
    }
}

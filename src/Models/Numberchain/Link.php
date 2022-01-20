<?php

namespace Dalyio\Challenge\Models\Numberchain;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    /**
     * @var string
     */
    protected $table = 'challenge_numberchain_links';
    
    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'numberchain_id', 'link_number', 'sequence'
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
    public function numberchainId()
    {
        return $this->getAttribute('numberchain_id');
    }
    
    /**
     * @return \Dalyio\Challenge\Models\Numberchain
     */
    public function numberchain()
    {
        return $this->hasOne(\Dalyio\Challenge\Models\Numberchain::class, 'id', 'numberchain_id')->first();
    }

    /**
     * @return int
     */
    public function linkNumber()
    {
        return $this->getAttribute('link_number');
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
    public function sequence()
    {
        return $this->getAttribute('sequence');
    }
}

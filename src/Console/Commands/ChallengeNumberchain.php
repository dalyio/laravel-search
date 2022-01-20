<?php

namespace Dalyio\Challenge\Console\Commands;

use Illuminate\Console\Command;

class ChallengeNumberchain extends Command
{
    /**
     * @var string
     */
    protected $signature = 'challenge:numberchain {--s|start=} {--e|end=}';

    /**
     * @var string
     */
    protected $description = 'Calculate and store the `square of digits` numbers chains';
    
    /**
     * @var array
     */
    protected $config = [];
    
    /**
     * @var int
     */
    protected $start = 0;
    
    /**
     * @var int
     */
    protected $end = 2147483647;
    
    /**
     * @var Dalyio\Challenge\Services\SquareOfDigits
     */
    private $squareOfDigits;

    /**
     * @return void
     */
    public function __construct(
        \Dalyio\Challenge\Services\SquareOfDigits $squareOfDigits
    ) {
        parent::__construct();
        
        $this->squareOfDigits = $squareOfDigits;
        
        $this->start = $this->squareOfDigits->nextStartingNumber();
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('start')) $this->start = (int) $this->option('start'); 
        if ($this->option('end')) $this->end = (int) $this->option('end');
        
        for ($number = $this->start; $number <= $this->end; $number++) {
            
            $chain = $this->squareOfDigits->numberChain($number);
            $numberchain = \Dalyio\Challenge\Models\Numberchain::updateOrCreate([
                'starting_number' => $number,
            ], [
                'ending_number' => end($chain),
                'numberchain_count' => count($chain),
            ]);
            
            array_map(function($link, $key) use($numberchain) {
                $numberchainLink = \Dalyio\Challenge\Models\Numberchain\Link::updateOrCreate([
                    'numberchain_id' => $numberchain->id(),
                    'sequence' => $key,
                ], [
                    'link_number' => $link,
                ]);
            }, $chain, array_keys($chain));
            
            $this->line($number.': '.implode(' -> ', $chain));
        }
    }
}

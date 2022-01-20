<?php

namespace Dalyio\Challenge\Services;

use Illuminate\Support\Facades\App;

class NumberchainData
{   
    /**
     * @return int
     */
    public function indexedThrough()
    {
        $indexedThrough = \Dalyio\Challenge\Models\Numberchain::max('starting_number');
        
        return ($indexedThrough) ? $indexedThrough : 0;
    }
    
    /**
     * @param int|string $number
     * @return int
     */
    public function countByEndingNumber($number)
    {
        $count = \Dalyio\Challenge\Models\Numberchain::where('ending_number', $number)->count();
        
        return ($count) ? $count : 0;
    }
    
    /**
     * @return int
     */
    public function averageLinkCount()
    {
        $average = \Dalyio\Challenge\Models\Numberchain::avg('numberchain_count');
        
        return ($average) ? round($average, 2) : 0;
    }
    
    /**
     * 
     * @param int $limit
     * @return \Dalyio\Challenge\Models\Numberchain[]
     */
    public function longestNumberchains($limit = 10)
    {
        return \Dalyio\Challenge\Models\Numberchain::orderByDesc('numberchain_count', 'starting_number')
                ->take($limit)
                ->get();
    }
    
    /**
     * @param int|string $number
     * @param int $limit
     * @return \Dalyio\Challenge\Models\Numberchain[]
     */
    public function longestNumberchainsByEndingNumber($number, $limit = 10)
    {
        return \Dalyio\Challenge\Models\Numberchain::where('ending_number', $number)
                ->orderByDesc('numberchain_count', 'starting_number')
                ->take($limit)
                ->get();
    }
    
    /**
     * @param int $limit
     * @return array
     */
    public function mostFrequentChainlinks($limit = 10)
    {
        $query = \Dalyio\Challenge\Models\Numberchain\Link::groupBy('link_number')
                ->selectRaw('count(*) as count, link_number')
                ->orderByDesc('count');
        
        return ($limit) ? $query->take($limit)->get() : $query->get();
    }
    
    /**
     * @param int $limit
     * @return array
     */
    public function mostFrequentSecondChainlink($limit = 10)
    {
        return \Dalyio\Challenge\Models\Numberchain\Link::where('sequence', 1)
                ->groupBy('link_number')
                ->selectRaw('count(*) as count, link_number')
                ->orderByDesc('count')
                ->take($limit)
                ->get();
    }
    
    public function chainlinkFrequency()
    {
        return \Dalyio\Challenge\Models\Numberchain\Link::where('sequence', '>=', 1)
                ->groupBy('link_number')
                ->selectRaw('link_number as x, count(*) as y, link_number as name')
                ->orderBy('link_number')
                ->get();
    }
    
    public function chainlinkCounts()
    {
        $results = collect([]);
        foreach ([89, 1] as $endingNumber) {
            $results->push([
                'name' => __('Ending Number ').$endingNumber,
                'data' => \Dalyio\Challenge\Models\Numberchain::where('ending_number', $endingNumber)
                    ->groupBy('numberchain_count')
                    ->selectRaw('numberchain_count as x, count(*) as y, numberchain_count as name')
                    ->orderBy('numberchain_count')
                    ->get()
            ]);
        }
        
        return $results;
    }
}

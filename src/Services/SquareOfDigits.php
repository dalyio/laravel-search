<?php

namespace Dalyio\Challenge\Services;

use Illuminate\Support\Facades\App;

class SquareOfDigits
{   
    /**
     * Returns a sequence of numbers in a chain by adding the square of each digit
     * the previous number made up
     * 
     * @param int $number
     * @return int[]
     */
    public function numberChain($number)
    {
        $chain = [$number];
        $calculate = function($number) use(&$chain, &$calculate) {

            // Split into digits and get the sum of square of digits
            $newNumber = array_sum(array_map(function($digit) {
                return pow($digit, 2);
            }, str_split($number)));

            $chain[] = $newNumber;
            
            // Break if number is either 1 or 89
            if (($newNumber === 1) || ($newNumber === 89)) {
                return $chain;
            }
            
            // Calculate next number in number chain
            return $calculate($newNumber);
        };
        
        return $calculate($number);
    }

    /**
     * Returns the count of how many number chains end with the arrival number
     * 
     * @param int $limit
     * @param int $arrivalNumber
     * @return int
     */
    public function arrivesAt($limit, $arrivalNumber = 89)
    {
        $result = 0;
        for ($n = 1; $n <= $limit; $n++) {
            
            $arrivesAt = function($number) use(&$arrivesAt) {
            
                // Split into digits and get the sum of square of digits
                $newNumber = array_sum(array_map(function($digit) {
                    return pow($digit, 2);
                }, str_split($number)));

                // Break if number is either 1 or 89
                if (($newNumber === 1) || ($newNumber === 89)) {
                    return $newNumber;
                }

                // Calculate next number in number chain
                return $arrivesAt($newNumber);
            };
            
            if ($arrivesAt($n) == $arrivalNumber) $result++;
        }
        
        return $result;
    }
    
    /**
     * Get the next highest starting numberchain number that has data in the database
     * 
     * @return int
     */
    public function nextStartingNumber()
    {
        $numberchain = \Dalyio\Challenge\Models\Numberchain::max('starting_number');
        
        return ($numberchain) ? ++$numberchain : 1;
    }
}

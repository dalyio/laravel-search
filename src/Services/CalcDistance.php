<?php

namespace Dalyio\Challenge\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class CalcDistance
{   
    /**
     * array
     */
    private $earthRadius = [
        'km' => 6371
    ];
    
    /**
     * @return void
     */
    public function __construct() 
    {
        
    }
    
    /**
     * @param string|string[] $zipcode
     * @param string|null $zipcodeTo
     * @return type
     */
    public function byZipcodes($zipcode, $zipcodeTo = null)
    {
        if (is_array($zipcode)) {
            $zipcodes = collect($zipcode);
            return $zipcodes->map(function($zipcode, $key) use(&$zipcodes) {
                
                if (!$zipcodes->has($key+1)) return;
                if (!($zipcodeFrom = $this->getZipcode($zipcode))) {
                    return $this->formatError($zipcode);
                }
                if (!($zipcodeTo = $this->getZipcode($zipcodes->get($key+1)))) {
                    return $this->formatError($zipcodes->get($key+1));
                }
                
                return $this->formatSuccess($zipcodeFrom, $zipcodeTo);
                
            })->filter();
        } else if ((is_string($zipcode) || is_numeric($zipcode)) && 
                (is_string($zipcodeTo) || is_numeric($zipcodeTo))) {
            
            $zipcodeFrom = $this->getZipcode($zipcode);
            $zipcodeTo = $this->getZipcode($zipcodeTo);
            
            if (!$zipcodeFrom || !$zipcodeTo) {
                abort(400, 'Unknown element');
            }
            
            return [
                'success' => true,
                'zipcode_from' => $zipcodeFrom,
                'zipcode_to' => $zipcodeTo,
                'distance' => $this->distinceBetweenZipcodes($zipcodeFrom, $zipcodeTo, 'km'),
                'unit' => __('km'),
            ];
        }
    }
    
    private function getZipcode($zipcodeText)
    {
        return \Dalyio\Challenge\Models\Geo\Zipcode::where('zipcode', $zipcodeText)->first();
    }
    
    private function distinceBetweenZipcodes($zipcodeFrom, $zipcodeTo, $unit = 'km', $precision = 1)
    {
        $changeLatitude = deg2rad($zipcodeFrom->latitude()) - deg2rad($zipcodeTo->latitude());
        $changeLongitude = deg2rad($zipcodeFrom->longitude()) - deg2rad($zipcodeTo->longitude());
        
        $angle = (sin($changeLatitude / 2) * sin($changeLatitude / 2)) + 
            (cos(deg2rad($zipcodeFrom->latitude())) * cos(deg2rad($zipcodeTo->latitude())) * sin($changeLongitude / 2) * sin($changeLongitude / 2));
        $distance = (2 * asin(sqrt($angle)) * $this->earthRadius[$unit]);
        
        return round($distance, $precision);
    }
    
    private function formatSuccess($zipcodeFrom, $zipcodeTo)
    {
        return [
            'success' => true,
            'zipcode_from' => $zipcodeFrom,
            'zipcode_to' => $zipcodeTo,
            'distance' => $this->distinceBetweenZipcodes($zipcodeFrom, $zipcodeTo),
            'unit' => __('km'),
        ];
    }
    
    private function formatError($zipcodeText)
    {
        return [
            'success' => false,
            'zipcode_text' => $zipcodeText,
            'message' => __('Unable to find zipcode "'.$zipcodeText.'"')
        ];
    }
}

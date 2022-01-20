<?php

if (!function_exists('version_asset')) {
    
    /**
     * Generate a version specific URL for an asset using a atimestamp
     *
     * @return string
     */
    function version_asset($filepath)
    {
        return asset($filepath).'?v='.filemtime(realpath(getcwd().'/'.$filepath));
    }
}

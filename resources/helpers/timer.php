<?php

if (!function_exists('timer')) {
    
    /**
     * @param string function
     * @return string
     */
    function timer($function)
    {
        switch($function) {
            case 'start';
                $time = time();
                session(['timer' => array_replace_recursive(session('timer', []), [
                    'start' => $time
                ])]);
                return $time;
            case 'stop';
                $time = time();
                session(['timer' => array_replace_recursive(session('timer', []), [
                    'stop' => $time
                ])]);
                return $time;
            case 'result';
                if (session('timer.start')) {
                    return session('timer.stop', time()) - session('timer.start');
                }
        }
    }
}

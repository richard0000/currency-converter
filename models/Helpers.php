<?php

class Helpers {
    /**
     * Print in human readable mode a variable to the GUI
     * 
     * @var array $variable
     */
    public static function dd($variable)
    {
        if(is_array($variable)){
            echo '<pre>' . print_r($variable) . '</pre>';
        }else{
            var_dump($variable);
        }

        die();
    }
}
<?php

/**
 * Trim a variable if not array
 * 
 * @param mixed $var
 * @return mixed
 */
function trim_if_string( $var ) {
    
    $var = is_string($var) ? trim($var) : $var;
    return $var;
}
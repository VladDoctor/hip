<?php

function read_val_from_folder($path){
    $file = fopen($path, 'r');
    $read_val = fread($file);
    return $read_val;
}
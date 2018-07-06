<?php

class chart extends module {

function run(){
    $out = [];

    $out['time'] = time();

    $this->data = $out;
}

}
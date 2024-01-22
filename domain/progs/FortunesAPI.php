<?php

namespace progs;

class FortunesApi {
    
    function __construct() {
        headerCTText(true);
    }

    function fortune() {
        $fortunes = [
             'Alexander the Great was a great general.'
            ,'Great generals are forewarned.'
            ,'Forewarned is forearmed.'
            ,'Four is an even number.'
            ,'Four is certainly an odd number of arms for a man to have.'
            ,'The only number that is both even and odd is infinity.'
            ,'Everything depends.'
            ,'Nothing is always.'
            ,'Everything is sometimes.'
            ,'10.0 times 0.1 is hardly ever 1.0.'
            ,'100 buckets of bits on the bus'
            ,'100 buckets of bits'
            ,'Take one down, short it to ground'
            ,'You patch a bug, and dump it again'
            ];
        if (array_key_exists('mkErr',$_GET)) include('idontexists'); // deliberately programming error
        $colors =['aqua','coral','violet','pink','green','blue','red','orange','Crimson','brown'];
        echo json_encode([$colors[rand(0,9)],$fortunes[rand(0,13)]]);
    }
}

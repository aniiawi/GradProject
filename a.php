<?php
    $l = [
        'ab' => 'z',
        'c' => 'o'
    ];
    $l['e'] = 'sdds';
    $g = $l['e'];
    var_dump( $g);
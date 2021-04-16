<?php
    require_once "additional/basicdbfuncs.php";
    try {
        insertregcode(pdoconnect(), "asdv123", 2);
    }catch (Exception $e){
        echo $e;
    }
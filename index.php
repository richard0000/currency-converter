<?php

include_once 'models/Sumator.php';
include_once 'models/Helpers.php';

$sumator = new Sumator();

$amounts = json_decode(file_get_contents('conf/values.json'));

try {
    $result = $sumator->sum($amounts);
    echo "Results is -> $result";
} catch (\Throwable $th) {
    echo($th->getMessage());
}

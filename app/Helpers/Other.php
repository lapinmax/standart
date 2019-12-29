<?php

function minutes_time ($minutes) {
    $hours = floor($minutes / 60);
    $minutes = $minutes - ($hours * 60);

    echo $hours . ':' . ($minutes < 10 ? '0' . $minutes : $minutes);
}

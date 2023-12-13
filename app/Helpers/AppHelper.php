<?php
function custom_number($n)
{
    if ($n < 1000000000 || $n < -1000000000) {
        // Anything less than a billion
        $n_format = number_format($n / 1000000, 2) . ' M';
    } else {
        // At least a billion
        $n_format = number_format($n / 1000000000, 2) . ' B';
    }

    return $n_format;
}

<?php
function custom_number($number)
{
    $suffix = '';
    $sign = ($number < 0) ? '-' : '';

    $number = abs($number); // Convert to absolute value for calculation

    if ($number >= 1000) {
        $units = ['', 'K', 'M', 'B', 'T'];
        $suffix = $units[floor(log10($number) / 3)];
        $number = round($number / pow(1000, $suffix ? array_search($suffix, $units) : 0), 2);
    }

    return $sign . $number . $suffix;
}

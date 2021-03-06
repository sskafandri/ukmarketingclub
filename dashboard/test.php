<?php

function ip_in_range($ip, $range)
{
    if (strpos($range, '/') == false) {
    	$range .= '/32';
    }
    // $range is in IP/CIDR format eg 127.0.0.1/24
    list($range, $netmask) = explode('/', $range, 2);
    $ip_decimal = ip2long($ip);
    $range_decimal = ip2long($range);
    $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
    $netmask_decimal = ~ $wildcard_decimal;
    return (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal));
}

$ip_check = ip_in_range('172.17.0.1', '172.0.0.0/8');

print_r($ip_check);
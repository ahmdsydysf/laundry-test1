<?php

if (!function_exists('activeMainLi')) {
    function activeMainLi($route): string
    {
        return request()->routeIs($route) ? 'active open' : '';
    }
}

if (!function_exists('activeChildLi')) {
    function activeChildLi($route): string
    {
        return request()->routeIs($route) ? 'active' : '';
    }
}

<?php

/**
 * @param string | array $routes
 * @param string $output = "active"
 *
 * @return string $output
 */
function isActiveRoutes($routes, $output = "active")
{
    if (!is_array($routes)) {
        if (Route::currentRouteName() == $routes) {
            return $output;
        }
    } else {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) {
                return $output;
            }
        }
    }
    return '';
}

<?php

/**
 * @param string | array $routes
 * @param string $output = "active"
 *
 * @return string $output
 */
function areActiveRoutes($routes, $output = "active")
{
    if (!is_array($routes)) {
        return isActiveRoute($routes, $output);
    } else {
        foreach ($routes as $route) {
            return isActiveRoute($route, $output);
        }
    }
    return '';
}

/**
 * @param string $route
 * @param string $output
 *
 * @return string $output
 */
function isActiveRoute($route, $output = "active")
{
    return starts_with(Route::currentRouteName(), $route) ? $output : '';
}

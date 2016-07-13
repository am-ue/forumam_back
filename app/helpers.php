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
        isActiveRoute($routes, $output);
    } else {
        foreach ($routes as $route) {
            isActiveRoute($route, $output);
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

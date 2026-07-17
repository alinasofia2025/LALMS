<?php

/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * This file is loaded in the context of the `Application` class.
  * So you can use  `$this` to reference the application class instance
  * if required.
 */

return function (RouteBuilder $routes): void {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/', ['controller' => 'Dashboards', 'action' => 'index']);
        $builder->connect('/lecturer', ['controller' => 'LecturerDashboard', 'action' => 'index']);
        $builder->connect('/lecturer-dashboard', ['controller' => 'LecturerDashboard', 'action' => 'index']);
        $builder->connect('/pages/*', 'Pages::display');
        $builder->connect('/contact/*', ['controller' => 'Contacts', 'action' => 'add']);
        $builder->connect('/dashboard/*', ['controller' => 'Dashboards', 'action' => 'index']);
        $builder->connect('/admin', ['controller' => 'Users', 'action' => 'login']);
        $builder->fallbacks();
    });

    /* $routes->prefix('Admin', function (RouteBuilder $routes) {
        $routes->connect('/users', ['controller' => 'Users', 'action' => 'index']);
        //$routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
        $routes->connect('/settings', ['prefix' => 'admin', 'controller' => 'Settings', 'action' => 'update']);
        $routes->fallbacks(DashedRoute::class);
    }); */

    $routes->prefix('Admin', function (RouteBuilder $routes) {
        // Because you are in the admin scope,
        // you do not need to include the /admin prefix
        // or the Admin route element.
        //$routes->connect('/', ['controller' => 'Pages', 'action' => 'index']);
        $routes->connect('/users', ['controller' => 'Users', 'action' => 'index']);
        $routes->connect('/settings', ['prefix' => 'admin', 'controller' => 'Settings', 'action' => 'update']);
        $routes->fallbacks(DashedRoute::class);
    });

    $routes->prefix('Lecturer', function (RouteBuilder $routes) {
        $routes->connect('/appointments', ['controller' => 'Appointments', 'action' => 'index']);
        $routes->connect('/appointments/view/*', ['controller' => 'Appointments', 'action' => 'view']);
        $routes->fallbacks(DashedRoute::class);
    });
    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder): void {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};

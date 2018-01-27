<?php

use Controllers\ApiController;
use Controllers\HomeController;
use Controllers\PagesController;
use Middleware\AppMiddleware;
use Solovey\Routing\Router;

Router::GET('Home', '/', [HomeController::class]);
Router::GET('Users', '/users', [PagesController::class, 'usersPage']);
Router::GET('User', '/users/{id([0-9]+)}', [PagesController::class, 'userPage']);

Router::GET('with-middleware', '/mid', [PagesController::class, 'midPage'], AppMiddleware::class);


Router::GET('api-users', '/api/users', [ApiController::class, 'users']);
Router::GET('api-user', '/api/users/{id([0-9]+)}', [ApiController::class, 'user']);

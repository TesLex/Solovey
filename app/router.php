<?php
/**
 * | -----------------------------
 * | Created by expexes on 29.11.17/23:19.
 * | Site: teslex.tech
 * | ------------------------------
 * | router.php
 * | ---
 */

use Routing\Router;
use Classes\System;

require __DIR__ . '/Controllers/TestController.php';

Router::get('test', '/test', 'TestController:test');

Router::match($_SERVER['REQUEST_URI']);

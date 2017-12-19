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

System::CC('TestController');

Router::GET('home', '/', 'TestController:just');
Router::GET('test', '/{class}/{method}', 'TestController:test');

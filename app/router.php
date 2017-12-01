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


Router::GET('test', '/test/([0-9])', 'TestController:test');
Router::POST('test', '/test/([0-9])', 'TestController:test');

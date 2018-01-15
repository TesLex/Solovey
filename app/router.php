<?php

use Controllers\HomeController;
use Solovey\Routing\Router;

Router::GET('Home', '/', HomeController::class);
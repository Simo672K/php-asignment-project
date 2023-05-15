<?php
  require_once ("settings.php");
  $router = new Router();
  
  $routes= [
    ["/", 'index.html', 'home'],
    ["/login", 'login.html', 'login'],
  ];

  $router->init($routes, $base_route);
  $router->get($request_url, "");

<?php
  require_once ("settings.php");
  $router = new Router();
  
  $routes= [
    ["/", 'index.html'],
    ["/login", 'login.html']
  ];

  $router->init($routes, $base_route);
  $router->get($request_url, "");

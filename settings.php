<?php
  require_once('core/router.php');
  require_once('models/model.php');
  require_once('views/views.php');
  
  define("BASE_DIR", __DIR__);
  define("TEMPLATE_DIR", BASE_DIR.'\\'."templates");
  $request= $_SERVER['REQUEST_URI'];
  $current_file_dir= explode("\\",dirname(__FILE__));
  $base_route = "/". end($current_file_dir);
  
  $views= new Views(TEMPLATE_DIR);
  
  $routes= [
    ["/", $views->render_view('index.html')],
    ["/login", $views->render_view('login.html')]
  ];
  $router = new Router($routes, $base_route);





  // "/admin/dashboard",
  // "/admin/login",
  // "/dashboard",
  // "/posts",
  // "/posts/:postId",
  // "/static",
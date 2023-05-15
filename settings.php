<?php
  require_once('core/router.php');
  require_once('models/model.php');
  require_once('views/views.php');
  
  define("BASE_DIR", __DIR__);
  define("TEMPLATE_DIR", BASE_DIR.'\\'."templates");
  define("STATIC_DIR", BASE_DIR.'\\'."statics");
  
  $request= $_SERVER['REQUEST_URI'];
  $current_file_dir= explode("\\",dirname(__FILE__));
  
  $base_route = "/". end($current_file_dir);
  $request_url= str_replace($base_route, '', $request);
  $static_url= $base_route.'/static';
  
  define("BASE_URL", $base_route);
  define("STATIC_URL", $static_url);


  // "/admin/dashboard",
  // "/admin/login",
  // "/dashboard",
  // "/posts",
  // "/posts/:postId",
  // "/static",
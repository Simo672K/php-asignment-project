<?php 
  define("BASE_DIR", __DIR__);
  define("TEMPLATE_DIR", BASE_DIR.'\\'."templates");

  require_once('models/model.php');
  require_once('core/router.php');
  require_once('core/parser.php');

  $request= $_SERVER['REQUEST_URI'];

  $routes= [
    "/project",
    "/project/admin/dashboard",
    "/project/admin/login",
    "/project/login",
    "/project/dashboard",
    "/project/posts",
    "/project/posts/:postId",
  ];

  $test= new Model("blog", "test");
  $router = new Router($routes);
  $parser= new Parser(TEMPLATE_DIR);

  $data= $test->getAll();
  $testTemplate= $parser->getTemplate("index.html");

  echo $testTemplate;

  $router->get($request, $data, function($req, $context){
    if($context){
      foreach($context as $ctx){
        echo "{$ctx['id']} ";
        echo "{$ctx['name']} ";
        echo "{$ctx['age']} <br/>";
      }
    }else {
      echo "You have been redirected to $req";
    }
  });


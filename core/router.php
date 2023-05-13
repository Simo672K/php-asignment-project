<?php
  require_once ("settings.php");
  require_once ("views/views.php");
  class Router{
    private $route;
    private $app_route_views;
    static $app_routes= array();
    static $base_route= "";
    
    function init($routes_maps, $base){
      $this->app_route_views = $routes_maps;
      foreach ($this->app_route_views as $key => $value) {
        array_push(self::$app_routes, $value[0]);
      }
      self::$base_route= $base;
    }
    
    static function serveStatic($path) {
      // get file os path
      $url_params= explode("/",$path);
      $file_name= end($url_params);
      $file_name= explode(".",$file_name);
      $file_extension= end($file_name);

      unset($url_params[1]);
      $file_os_path= STATIC_DIR. implode('\\', $url_params);

      $content_type= "";

      switch ($file_extension){
        case "css":
          $content_type = "text/css";
          break;
        case "js":
          $content_type = "application/javascript";
          break;
        case "png":
        case "jpg":
        case "gif":
          $content_type = "image";
          break;
        default:
          $content_type = "";
          break;
      }

      
      header("content-type: $content_type");
      $content = file_get_contents($file_os_path);
      echo $content;
    }

    // Private functions
    private function checkRoute($absolute_url){
      // check if the route existe in the installed url paths
      $url= str_replace(self::$base_route, "",$absolute_url);
      return in_array($url, self::$app_routes);
    }
    
    private function getView($url){
      // Creating new view instance for rendering template; 
      $views= new Views(TEMPLATE_DIR);
      
      // Check template to render; 
      foreach($this->app_route_views as $key=> $value){
        if($value[0] == $url){
          $views->render_view($value[1]);
        }
      }
      return;
    }
    
    // Public functions
    public function get($url, $data){
      // Check base url; 
      $url_params= explode("/",$url);
      $base_url_tree= $url_params[1];

      if ($base_url_tree != "static"){
        $isLegitRoute= $this->checkRoute($url);
        $context= null; 
        
        if($data){
          $context= $data;
        }
  
        if($isLegitRoute){
          echo $this->getView($url);
        }else {
          echo "<br/><h1>404 url does not exist</h1>";
        }
      }else {
        self::serveStatic($url);
      }
    }

  }
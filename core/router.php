<?php
  class Router{
    private $route;
    private $app_route_views;
    static $app_routes= array();
    static $base_route= "";

    function __construct($routes_maps, $base, $views=null){
      $this->app_route_views = $routes_maps;
      foreach ($this->app_route_views as $key => $value) {
        array_push(self::$app_routes, $value[0]);
      }
      self::$base_route= $base;
    }

    // Private functions
    private function checkRoute($absolute_url){
      $url= str_replace(self::$base_route, "",$absolute_url);
      return in_array($url, self::$app_routes);
    }

    private function getView($url){
      foreach($this->app_route_views as $key=> $value){
        if($value[0] == $url){
          return $value[1];
        }
      }
      return;
    }

    // Public functions
    public function get($url, $data){
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
    }

  }
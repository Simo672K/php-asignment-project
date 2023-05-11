<?php
  class Router{
    private $route;
    static $appRoutes;

    function __construct($routes){
      $this->appRoutes= $routes;
    }

    // Private functions
    private function checkRoute($path){
      $modifiedPath="{$path[strlen($path)-1]}" == "/"? substr($path, 0, -1) : $path;
      return in_array($modifiedPath, $this->appRoutes);
    }

    // Publick functions
    public function get($path, $data, $callback){
      $isLegitRoute= $this->checkRoute($path);
      $context= null; 
      
      if($data){
        $context= $data;
      }

      if($isLegitRoute){
        $callback($path, $context);
      }else {
        echo "404 Path does not exist";
      }
    }

  }
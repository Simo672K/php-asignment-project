<?php
  include("tengine.php");
  class Parser{
    static $templatesPath= "";
    
    function __construct($templateDir){
      self::$templatesPath = $templateDir;
    }

    public function render($template, $context){
      return TEngine::view(self::$templatesPath."\\".$template, $context);
    }
  }
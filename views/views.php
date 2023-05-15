<?php
  require_once('core/parser.php');
  class Views{
    static $template_base_dir;

    /*
      TODO: map each url route to specific callback function;
    */ 
    function __construct($template_dir){
      self::$template_base_dir= $template_dir;
    }

    public function render_view($template, $urls, $context=array()){
      $parser = new Parser(self::$template_base_dir);
      return $parser->render($template, $urls, $context);
    }
  }
<?php
  class Parser{
    static $templatesPath;
    private $loadedHtml;
    private $proceessedHtml;

    function __construct($templateDir){
      $this->templatesPath = $templateDir;
    }

    private function parseTemplate($templateName){
      echo $this->templatesPath.'\\'.$templateName;
      $this->loadedHtml = file_get_contents($this->templatesPath.'\\'. $templateName);
    }

    private function processTemplate(){

    }

    public function getTemplate($template){
      $this->parseTemplate($template);
      return $this->loadedHtml;
    }
  }
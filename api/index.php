<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if($_SERVER['REQUEST_URI'] == '/api/docs' || $_SERVER['REQUEST_URI'] == '/api/'){
  include_once('docs.php');
  exit();
}

if(str_starts_with($_SERVER['REQUEST_URI'], '/api/scrape') ){
  include_once('scrape.php');
  exit();
}


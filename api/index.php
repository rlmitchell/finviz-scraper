<?php
header('Access-Control-Allow-Origin: *');

if($_SERVER['REQUEST_URI'] == '/api/docs' || $_SERVER['REQUEST_URI'] == '/api/'){
  header('Content-Type: text/html');
  include_once('docs.php');
  exit();
}

if(str_starts_with($_SERVER['REQUEST_URI'], '/api/scrape') ){
  header('Content-Type: application/json');
  include_once('scrape.php');
  exit();
}


<?php
require_once('includes/db.php');
$database = init_sqlite_db('db/site.sqlite', 'db/init.sql');

include_once("includes/sessions.php");
$session_messages = array();
process_session_params($database, $session_messages);

function match_routes($uri, $routes)
{
  if (is_array($routes)) {
    foreach ($routes as $route) {
      if (($uri == $route) || ($uri == $route . '/')) {
        return True;
      }
    }
    return False;
  } else {
    return ($uri == $routes) || ($uri == $routes . '/');
  }
}

// Grabs the URI and separates it from query string parameters
error_log('');
error_log('HTTP Request: ' . $_SERVER['REQUEST_URI']);
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];

if (preg_match('/^\/public\//', $request_uri) || $request_uri == '/favicon.ico') {
  // let the web server respond for static resources
  return False;
} else if (match_routes($request_uri, '/')) {
  require 'pages/catalog.php';
} else if (match_routes($request_uri, '/add')) {
  require 'pages/add-plant.php';
} else if (match_routes($request_uri, '/plant')) {
  require 'pages/plant.php';
} else if (match_routes($request_uri, '/plant/edit')) {
  require 'pages/plant-edit.php';
} else {
  error_log("  404 Not Found: " . $request_uri);
  http_response_code(404);
  require 'pages/404.php';
}

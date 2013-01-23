<?php
// Load the helper functions
require '../lib/functions.php';
require '../lib/router.php';
require '../lib/db.php';
require '../lib/spyc.php';

// Debug on or off
$debug = true;

// Connect to the database
$db = new DB('localhost', 'cravetivity', 'cravetivity', 'cravetivity', $debug);

// Route configuration
$routes = Spyc::YAMLLoad('../config/routes.yml');

// Load the front controller
$router = new Router($_SERVER["REQUEST_URI"], $routes);

//Check for a 404
if (!$route = $router->getRoute())
{ header("Status: 404 Not Found");
  $route = $routes['404'];
}
// Set the variables
$router->setVariables();
// Authenticate if needed
if (isset($password)) $user = authenticate($username, $password);
// URL is hex encoded, do hex2bin:
if (isset($url)) $url = pack("H*",$url);
// Load the file into body
ob_start();
require "../actions/$route[resource]";
$body = ob_get_contents();
ob_end_clean();
require "../templates/$route[template]";
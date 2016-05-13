<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
spl_autoload_register(function ($classname) {
    require ("../classes/" . $classname . ".php");
});

$config['displayErrorDetails'] = true;

$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "";
$config['db']['dbname'] = "naijasoups";

$app = new \Slim\App(["settings" => $config]);
/*$app->response->headers->set('Content-Type', 'application/json'); 
$app->response->header('Access-Control-Allow-Headers',> 'Content-Type');
$app->response->header('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE');
$app->response->header('Access-Control-Allow-Origin','*');
$app->options("/:name+");*/
/*if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // return only the headers and not the content
    // only allow CORS if we're doing a GET - i.e. no saving for now.
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        if($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET' || $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'POST') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: X-Requested-With, X-authentication,Content-Type, X-client');
        }
    }
    exit;
}*/
//$app->response->headers->set('Access-Control-Allow-Origin', '*');

$container = $app->getContainer();
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

//$this->logger->addInfo("App started...");

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'], $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$app->post('/placeOrder', function (Request $request, Response $response) {
    $this->logger->addInfo("Placing order...");
    $data = $request->getParsedBody();
    //print_r($data); exit;
    $data['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
    $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
    $data['phone'] = filter_var($data['phone'], FILTER_SANITIZE_NUMBER_INT);
    $data['address'] = filter_var($data['address'], FILTER_SANITIZE_STRING);
    //$data['amount'] = filter_var($data['amount'], FILTER_SANITIZE_NUMBER_FLOAT);
    $data['amount'] = '';
    $data['tId'] = filter_var($data['tId'], FILTER_SANITIZE_STRING);
    $data['date'] = filter_var($data['date'], FILTER_SANITIZE_STRING);

    $order = new OrderEntity($data);
    $placeOrder = new PlaceOrder($this->db);
    $response_data = $placeOrder->save($order);
    //print_r($response_data); exit;
    $response->getBody()->write( json_encode($response_data) );
    return $response;
});
/*
$app->get('/placeOrder', function (Request $request, Response $response) {
    $this->logger->addInfo("Placing order...");
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});*/
$app->run();
/*if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();*/

<?php
require './vendor/autoload.php';
define("PROJECTPATH", __DIR__);
define("IP", $_SERVER['SERVER_NAME']);
$dbconfig = parse_ini_file(PROJECTPATH . '/src/Database/configs.db');
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$config['db']['host'] = $dbconfig['host'];
$config['db']['username'] = $dbconfig['user'];
$config['db']['password'] = $dbconfig['password'];
$config['db']['database'] = $dbconfig['database'];
$config['db']['driver'] = 'mysql';
$config['db']['charset'] = 'utf8';
$config['db']['collation'] = 'utf8_general_ci';
$app = new \Slim\App(['settings' => $config]);
$container = $app->getContainer();
/*$c['errorHandler'] = function ($c) {
  return function ($request, $response, $exception) use ($c) {
    $data;
    $data['status'] = "error";
    $data['content'] = "Fatal Error.... Unknow Error";
    return $c['response']->withJson($data);
  };
};*/
/* $container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('./logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
}; */
$container['view'] = new \Slim\Views\PhpRenderer('./templates/');
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container->get('settings')['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
include_once(PROJECTPATH.'/src/Routes/Routes.php');
$app->run();

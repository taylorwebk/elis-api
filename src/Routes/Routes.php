<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Controllers\MainController as MC;

$app->get('/', function (Request $req, Response $res)
{
  return $res->withJson('Hello World');
});
$app->post('/instructor', function (Request $req, Response $res) {
  $resdata = MC::addInstructor($req->getParsedBody());
  return $res->withJson($resdata);
});
$app->post('/student', function (Request $req, Response $res) {
  $resdata = MC::addStudent($req->getParsedBody());
  return $res->withJson($resdata);
});
$app->get('/student', function (Request $req, Response $res) {
  $resdata = MC::getStudents();
  return $res->withJson($resdata);
});
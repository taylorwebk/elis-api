<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Controllers\MainController as MC;
use \Controllers\PdfController as PdfC;
use \Models\Estudiante;
use \Models\Modulo;
use \Models\Asistencia;

$app->get('/', function (Request $req, Response $res)
{
  return $res->withJson('Hello World');
});
$app->get('/report', function (Request $req, Response $res) {
  PdfC::generateReport();
});
$app->get('/reporte', function (Request $req, Response $res) {
  $data = MC::getStudents();
  $modules = $data['content'];
  $res = $this->view->render($res, 'All.phtml', ['modules' => $modules]);
  return $res;
});
$app->get('/reporte/{idmodule}/{idstudent}', function (Request $req, Response $res, $args) {
  $idmod = (int)$args['idmodule'];
  $mod = Modulo::find((int)$args['idmodule']);
  $est = Estudiante::with(['persona', 'modulos' => function ($query) use ($idmod){
    $query->where('id', $idmod);
  }])->find((int)$args['idstudent']);
  $res = $this->view->render($res, 'One.phtml', [
    'module' => $mod,
    'student' => $est
  ]);
  return $res;
});
$app->get('/asistencia/{idmodule}/{idstudent}', function (Request $req, Response $res, $args) {
  $idstudent = (int)$args['idstudent'];
  $idmodule = (int)$args['idmodule'];
  $resdata = MC::assistance($idstudent, $idmodule);
  return $res->withJson($resdata);
});
$app->post('/instructor', function (Request $req, Response $res) {
  $resdata = MC::addInstructor($req->getParsedBody());
  return $res->withJson($resdata);
});
$app->put('/module', function (Request $req, Response $res) {
  $resdata = MC::updateModules($req->getParsedBody());
  return $res->withJson($resdata);
});
$app->get('/module', function (Request $req, Response $res) {
  $resdata = MC::getModules();
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
$app->delete('/student/{idmodule}/{idstudent}', function (Request $req, Response $res, $args) {
  $idstudent = (int)$args['idstudent'];
  $idmodule = (int)$args['idmodule'];
  $resdata = MC::deleteStudent($idstudent, $idmodule);
  return $res->withJson($resdata);
});
$app->put('/student', function (Request $req, Response $res) {
  $resdata = MC::updateStudent($req->getParsedBody());
  return $res->withJson($resdata);
});

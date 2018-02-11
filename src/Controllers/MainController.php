<?php
namespace Controllers;

use \Endroid\QrCode\QrCode;

use \Models\Utils;
use \Models\Persona;
use \Models\Instructor;
use \Models\Response;
use \Models\Estudiante;
use \Models\Modulo;

class MainController {
  public static function addInstructor($data) {
    $fields = ['nombres', 'apellidos', 'cel', 'fb', 'ci', 'modulos'];
    if (!Utils::validateData($data, $fields)) {
      return Response::BadRequest(
        Utils::implodeFields($fields)
      );
    }
    $persona = Persona::create(
      [
        'nombres'   => $data['nombres'],
        'apellidos' => $data['apellidos'],
        'cel'       => $data['cel']
      ]
    );
    $instructor = Instructor::create(
      [
        'persona_id'  => $persona->id,
        'fb'          => $data['fb'],
        'ci'          => $data['ci']
      ]
    );
    foreach ($data['modulos'] as $value) {
      $instructor->modulos()->attach($value);
    }
    return Response::OK(
      'Todo OK',
      'Registro completo, Muchas gracias señor instructor :D',
      null
    );
  }
  public static function addStudent($data)
  {
    $fields = ['nombres', 'apellidos', 'cel', 'correo', 'edad', 'sexo', 'univ', 'modulos'];
    if (!Utils::validateData($data, $fields)) {
      return Response::BadRequest(
        Utils::implodeFields($fields)
      );
    }
    if ( (Estudiante::where('correo', $data['correo'])->first()) ) {
      return Response::Unauthorized(
        'Correo duplicado',
        'Ups... Parece que alguien ya ha usado este correo para registrarse.'
      );
    }
    $persona = Persona::create(
      [
        'nombres'   => $data['nombres'],
        'apellidos' => $data['apellidos'],
        'cel'       => $data['cel']
      ]
    );
    $estudiante = Estudiante::create([
      'persona_id'  => $persona->id,
      'correo'      => $data['correo'],
      'edad'        => $data['edad'],
      'sexo'        => $data['sexo'],
      'univ'        => $data['univ']
    ]);
    foreach ($data['modulos'] as $value) {
      $qrdata = [
        'id'      => $estudiante->id,
        'nombres' => $persona->nombres,
        'mod'     => $value
      ];
      $qrsting = json_encode($qrdata);
      $imgname = '/'.$estudiante->id.''.$value.'.png';
      $qrCode = new QrCode($qrsting);
      $qrCode->writeFile(PROJECTPATH.'/qrcodes'.$imgname);
      $estudiante->modulos()->attach($value, ['qrurl' => IP.'/elis-api/qrcodes'.$imgname]);
    }
    return Response::OK(
      'Todo OK',
      'Muchas gracias por registrarte '.$persona->nombres.', te esperamos en clases',
      null
    );
  }
  public static function getStudents() {
    $modulos = Modulo::with(['instructores.persona', 'estudiantes.persona'])->get();
    $returndata = $modulos->map(function($modulo, $key) {
      $instructores = $modulo->instructores->map(function ($instructor) {
        return [
          'id'        => $instructor->id,
          'fb'        => $instructor->fb,
          'nombres'   => $instructor->persona->nombres,
          'apellidos' => $instructor->persona->apellidos,
          'cel'       => $instructor->persona->cel
        ];
      });
      $estudiantes = $modulo->estudiantes->map(function ($estudiante) {
        return [
          'id'        => $estudiante->id,
          'correo'    => $estudiante->correo,
          'edad'      => $estudiante->edad,
          'sexo'      => $estudiante->sexo,
          'univ'      => $estudiante->univ,
          'qrurl'     => $estudiante->pivot->qrurl,
          'nombres'   => $estudiante->persona->nombres,
          'apellidos' => $estudiante->persona->apellidos,
          'cel'       => $estudiante->persona->cel
        ];
      });
      return [
        'id'            => $modulo->id,
        'nombre'        => $modulo->nombre,
        'des'           => $modulo->dsc,
        'dia'           => $modulo->dia,
        'ini'           => $modulo->ini,
        'fin'           => $modulo->fin,
        'instructores'  => $instructores,
        'estudiantes'   => $estudiantes
      ];
    });
    return $returndata;
  }
}
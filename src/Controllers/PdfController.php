<?php
namespace Controllers;

use \Mpdf\Mpdf;

class PdfController {
  public static function generateReport() {
    $config = [
      'tempDir'   => PROJECTPATH.'/temp'
    ];
    $mpdf = new Mpdf($config);
    $url = 'http://' . IP . '/elis-api/reporte';
    //echo $url;
    $string = \file_get_contents($url);
    //echo $string;
    //$mpdf->getFileContentsByCurl('https://github.com');
    $mpdf->writeHtml($string);
    $mpdf->Output('EstudiantesFullStack.pdf', 'D');
  }
}
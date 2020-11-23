<?php

namespace App\Http\Controllers;

use App\Models\Zoho;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function __invoke()
   {
      $api = new Zoho;
      $pag = 1;
      $total = 0;
      $emisiones = 0;
      $vencimientos = 0;
      $aseguradoras = array();
      $criterio = "Account_Name:equals:" . session("empresaid");

      do {
         if ($lista = $api->searchRecordsByCriteria("Quotes", $criterio, $pag, 200)) {
            $pag++;
            foreach ($lista as $cotizacion) {
               $total++;
               if (
                  $cotizacion->getFieldValue("Deal_Name") != null
                  and
                  date("Y-m", strtotime($cotizacion->getCreatedTime())) == date('Y-m')
               ) {
                  $emisiones++;
                  $poliza = $api->getRecord("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());
                  $aseguradoras[] = $poliza->getFieldValue('Aseguradora')->getLookupLabel();

                  //if (date("Y-m", strtotime($poliza->getFieldValue("Closing_Date"))) == date('Y-m')) {
                  //$vencimientos++;
                  //}
               }
            }
         } else {
            $pag = 0;
         }
      } while ($pag > 0);

      $aseguradoras = array_count_values($aseguradoras);

      return view("index", [
         "total" => $total,
         "emisiones" => $emisiones,
         "vencimientos" => $vencimientos,
         "aseguradoras" => $aseguradoras
      ]);
   }
}

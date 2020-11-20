<?php

namespace App\Http\Controllers;

use App\Models\Zoho;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function __invoke()
   {
      $api=new Zoho;
      $pag = 1;
      $total = 0;
      $emisiones = 0;
      $vencimientos = 0;
      $criterio = "Account_Name:equals:" . session("empresaid");

      do {
         if ($lista = $api->searchRecordsByCriteria("Quotes", $criterio, $pag, 200)) {
            $pag++;
            foreach ($lista as $cotizacion) {
               $total++;
               if ($cotizacion->getFieldValue("Deal_Name") != null) {
                  //if (date("Y-m", strtotime($cotizacion->getCreatedTime())) == date('Y-m')) {
                  //$result["emisiones"]++;
                  //$poliza = $this->model->getRecord("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());
                  //$aseguradoras[] = $poliza->getFieldValue('Aseguradora')->getLookupLabel();
                  //}
               }
            }
         } else {
            $pag = 0;
         }
      } while ($pag > 0);

      return view("index", [
         "total" => $total,
         "emisiones" => $emisiones,
         "vencimientos" => $vencimientos,
      ]);
   }
}

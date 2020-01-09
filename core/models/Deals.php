<?php

class Deals extends API
{
    public $Lead_Source = "Portal GNB";
    public $Deal_Name = "Trato realizado desde el portal";
    public $Contact_Name;
    public $Direcci_n_del_asegurado;
    public $A_o_de_Fabricacion;
    public $Chasis;
    public $Color;
    public $Email_del_asegurado;
    public $Marca;
    public $Modelo;
    public $Nombre_del_asegurado;
    public $Placa;
    public $Plan;
    public $Type;
    public $RNC_Cedula_del_asegurado;
    public $Telefono_del_asegurado;
    public $Tipo_de_poliza;
    public $Tipo_de_vehiculo;
    public $Valor_Asegurado;
    public $Es_nuevo;
    public $Stage;
    public $Aseguradora;
    public $Closing_Date;
    public $Amount;


    public function crear()
    {
        $resultado_id = $this->createRecord("Deals", $this);
        return $resultado_id;
    }

    public function buscar_por_contacto($contacto_id)
    {
        $criterio = "Contact_Name:equals:" . $contacto_id;
        $resultado = $this->searchRecordsByCriteria("Deals", $this, $criterio);
        return $resultado;
    }

    public function detalles($oferta_id)
    {
        $resultado = $this->getRecord("Deals", $this, $oferta_id);
        return $resultado;
    }

    public function actualizar($oferta_id)
    {
        $this->updateRecord("Deals", $this, $oferta_id);
    }
}

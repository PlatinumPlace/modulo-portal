<?php

class Coberturas extends API
{

    public $Aseguradora;
    public $Asistencia_vial;
    public $Colisi_n_y_vuelco;
    public $Da_os_Propiedad_ajena;
    public $Fianza_judicial;
    public $Incendio_y_robo;
    public $Lesiones_Muerte_1_pasajero;
    public $Lesiones_Muerte_1_Pers;
    public $Lesiones_Muerte_m_s_de_1_pasajero;
    public $Lesiones_Muerte_m_s_de_1_Pers;
    public $Renta_Veh_culo;
    public $Casa_del_Conductor;
    public $Riesgos_comprensivos;
    public $Riesgos_comprensivos_Deducible;
    public $Riesgos_conductor;
    public $Rotura_de_Cristales_Deducible;

    public function buscar_por_aseguradora($aseguradora_id)
    {
        $criterio = "Aseguradora:equals:" . $aseguradora_id;
        $resultado = $this->searchRecordsByCriteria("Coberturas", $this, $criterio);
        return $resultado;
    }
}

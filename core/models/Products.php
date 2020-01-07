<?php

class Products extends API
{

    public $Vendor_Name;
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
    public $Reporte_de_accidente;
    public $Riesgos_comprensivos;
    public $Riesgos_comprensivos_Deducible;
    public $Riesgos_conductor;
    public $Rotura_de_Cristales_Deducible;


    public function detalles($producto_id)
    {
        $resultado = $this->getRecord("Products", $this, $producto_id, $Vendor_Name = true);
        return $resultado;
    }
}

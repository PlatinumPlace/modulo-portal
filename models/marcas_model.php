<?php

class marcas_model extends api_model
{

    public function obtener_marcas()
    {
        $marcas = $this->getRecords("Marcas");
        $reultado = array();
        $posicion = 0;
        foreach ($marcas as $marca) {
            $resultado[$posicion]['id'] = $marca->getEntityId();
            $resultado[$posicion]['nombre'] = $marca->getFieldValue('Name');
            $posicion++;
        }
        return $resultado;
    }
}

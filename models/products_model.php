<?php

class products_model extends api_model
{
    public function generar_imagen_aseguradora($plan_id)
    {
        $plan_detalles = $this->getRecord("Products", $plan_id);
        if ($plan_detalles->getFieldValue('Vendor_Name') != null) {
            return $this->downloadRecordPhoto(
                "Vendors",
                $plan_detalles->getFieldValue('Vendor_Name')->getEntityId(),
                "img/Aseguradoras/"
            );
        } else {
            return null;
        }
    }

    public function coberturas($plan_id, $cuenta_id)
    {
        $plan_detalles = $this->getRecord("Products", $plan_id);
        if ($plan_detalles->getFieldValue('Vendor_Name') != null) {
            $criterio = "((Aseguradora:equals:" . $plan_detalles->getFieldValue('Vendor_Name')->getEntityId() . ") and (Socio_IT:equals:" . $cuenta_id . "))";
            return $this->searchRecordsByCriteria("Coberturas", $criterio);
        } else {
            return null;
        }
    }

    public function detalles_aseguradora($plan_id)
    {
        $plan_detalles = $this->getRecord("Products", $plan_id);
        $resultado['nombre'] = $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel();
        $resultado['id'] = $plan_detalles->getFieldValue('Vendor_Name')->getEntityId();
        return $resultado;
    }
}

<?php

class productos extends api
{
    public function generar_imagen_aseguradora($plan_id)
    {
        $plan_detalles = $this->getRecord("Products", $plan_id);
        if ($plan_detalles->getFieldValue('Vendor_Name') != null) {
            return $this->downloadRecordPhoto(
                "Vendors",
                $plan_detalles->getFieldValue('Vendor_Name')->getEntityId(),
                "public/img/Aseguradoras/"
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

}

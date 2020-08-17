<?php

class aseguradoras extends api {

    function lista() {
        $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
        $contratos = $this->searchRecordsByCriteria("Contratos", $criterio);
        foreach ($contratos as $contrato) {
            $plan = $this->getRecord("Products", $contrato->getFieldValue('Plan')->getEntityId());
            $aseguradoras[] = $plan->getFieldValue('Vendor_Name')->getLookupLabel();
        }
        $aseguradoras = array_unique($aseguradoras);
        foreach ($aseguradoras as $indice => $valor) {
            echo '<option value="' . $valor . '">' . $valor . '</option>';
        }
    }

}

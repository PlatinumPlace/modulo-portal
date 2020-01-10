<?php
class Products extends API
{
    public $Vendor_Name;

    public function detalles($producto_id)
    {
        $resultado = $this->getRecord("Products", $this, $producto_id, $Vendor_Name = true);
        return $resultado;
    }
}
<?php

class quotes_model extends api_model
{
    public function detalles($id)
    {
        return $this->getRecord("Quotes", $id);
    }
}
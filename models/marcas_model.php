<?php

class marcas_model extends api_model
{
    public function lista()
    {
        return $this->getRecords("Marcas");
    }
}

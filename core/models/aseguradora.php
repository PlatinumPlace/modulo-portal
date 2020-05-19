<?php

class aseguradora extends api
{

    function __construct()
    {
        parent::__construct();
    }

    public function foto($id)
    {
        if (!is_dir("public/img")) {
            mkdir("public/img", 0755, true);
        }

        return $this->downloadPhoto("Vendors", $id, "public/img/");
    }
}

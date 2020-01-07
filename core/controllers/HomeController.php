<?php

class HomeController
{
    public $oferta;
    public $cotizacion;

    function __construct()
    {
        $this->ofertas = new Deals;
        $this->cotizaciones = new Quotes;
    }

    public function pagina_principal()
    {
        $oferta = $this->ofertas->buscar_por_contacto("3222373000000751142");
        $tratos_totales = 0;
        $tratos_emitidos = 0;
        $tratos_vencen = 0;
        $tratos_pendientes = 0;

        if (!empty($oferta)) {
            foreach ($oferta as $trato) {

                $tratos_totales += 1;

                if ($trato["Stage"] == "En trámite" || $trato["Stage"] == "Emitido" && date("m", strtotime($trato["Closing_Date"] . "- 1 month")) == date('m')) {
                    $tratos_emitidos += 1;
                }
                if ($trato["Stage"] == "En trámite" && date("m", strtotime($trato["Closing_Date"] . "- 1 month")) == date('m')) {
                    $tratos_vencen += 1;
                }
                if ($trato["Stage"] == "Cotizando") {
                    $tratos_pendientes += 1;
                }
            }
        }

        require("core/views/template/header.php");
        require("core/views/home/index.php");
        require("core/views/template/footer.php");
    }

    public function crear_cotizacion()
    {
        if ($_POST) {

            $this->oferta->Contact_Name = "3222373000000751142";
            $this->oferta->Direcci_n_del_asegurado = $_POST['Direcci_n_del_asegurado'];
            $this->oferta->A_o_de_Fabricacion = $_POST['A_o_de_Fabricacion'];
            $this->oferta->Chasis = $_POST['Chasis'];
            $this->oferta->Color = $_POST['Color'];
            $this->oferta->Email_del_asegurado = $_POST['Email_del_asegurado'];
            $this->oferta->Marca = $_POST['Marca'];
            $this->oferta->Modelo = $_POST['Modelo'];
            $this->oferta->Nombre_del_asegurado = $_POST['Nombre_del_asegurado'];
            $this->oferta->Placa = $_POST['Placa'];
            $this->oferta->Plan = $_POST['Plan'];
            $this->oferta->Type = "Vehículo";
            $this->oferta->RNC_Cedula_del_asegurado = $_POST['RNC_Cedula_del_asegurado'];
            $this->oferta->Telefono_del_asegurado = $_POST['Telefono_del_asegurado'];
            $this->oferta->Tipo_de_poliza = $_POST['Tipo_de_poliza'];
            $this->oferta->Tipo_de_vehiculo = $_POST['Tipo_de_vehiculo'];
            $this->oferta->Valor_Asegurado = $_POST['Valor_Asegurado'];
            $this->oferta->Stage = "Prospección";
            $this->oferta->Es_nuevo = ($_POST['Es_nuevo'] == 0) ? true : false;

            $oferta_id = $this->ofertas->crear();
            $pagina_de_destino = "details";

            header('Location: ?page=loading&destiny=' . $pagina_de_destino . '&id=' . $oferta_id);
        }
        require("core/views/template/header.php");
        require("core/views/home/create.php");
        require("core/views/template/footer.php");
    }

    public function pantalla_de_carga()
    {
        require("core/views/template/header.php");
        require("core/views/home/load_page.php");
        require("core/views/template/footer.php");
    }

    public function detalles_cotizacion()
    {
        $oferta_id = $_GET['id'];
        $oferta = $this->ofertas->detalles($oferta_id);
        $cotizacion = $this->cotizaciones->buscar_por_trato($oferta_id);
        $productos = new Products;
        require("core/views/template/header.php");
        require("core/views/home/details.php");
        require("core/views/template/footer.php");
    }
}

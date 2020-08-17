<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

        <title><?= $titulo ?></title>
        <link rel="icon" type="image/png" href="<?= constant("url") ?>public/icons/logo.png">
    </head>

    <body>
        <div class="container">

            <div class="row">
                <div class="col-4">
                    <img src="<?= constant("url") ?>public/icons/logo.png" height="200" width="150">
                </div>

                <div class="col-8">
                    <div class="row">
                        <div class="col-6">
                            <h4><?= $_SESSION["usuario"]['empresa_nombre'] ?></h4>
                            <br>
                            <h4><?= $titulo ?></h4>
                            <br> <b>Desde:</b> <br> <b>Hasta:</b> <br> <b>Vendedor:</b>
                        </div>
                        <div class="col-6">
                            <h4>&nbsp;</h4>
                            <br>
                            <h4>&nbsp;</h4>
                            <br>
                            <?= $_POST["desde"] ?> <br>
                            <?= $_POST["hasta"] ?> <br>
                            <?= $_SESSION["usuario"]['nombre'] ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">&nbsp;</div>

            <div class="col-12">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <?php if ($_POST["tipo_cotizacion"] == "Auto") : ?>
                                <th scope="col">Emision</th>
                                <th scope="col">Deudor</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Año</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Prima</th>
                                <?php if ($_POST["estado_cotizacion"] == "pendientes") : ?>
                                    <th scope="col">Aseguradora</th>
                                <?php elseif ($_POST["estado_cotizacion"] == "emitidas") : ?>
                                    <th scope="col">Comisión</th>
                                    <th scope="col">Aseguradora</th>
                                <?php endif ?>
                            <?php endif ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $result = $cotizaciones->exportar_pdf() ?>
                    </tbody>
                </table>

                <div class="col-12">&nbsp;</div>

                <div class="row col-6">
                    <div class="col">
                        <?php
                        echo "<b>Total Primas:</b> <br> <b>Total Valores:</b>";
                        if ($_POST["estado_cotizacion"] == "emitidas") {
                            echo "<br> <b>Total Comisiones:</b>";
                        }
                        ?>
                    </div>

                    <div class="col">
                        <?php
                        echo "RD$" . number_format($result["prima_sumatoria"], 2);
                        echo "<br>";
                        echo "RD$" . number_format($result["valor_sumatoria"], 2);
                        if ($_POST["estado_cotizacion"] == "emitidas") {
                            echo "<br>";
                            echo "RD$" . number_format($result["comision_sumatoria"], 2);
                        }
                        ?>
                    </div>
                </div>

            </div>

        </div>

        <script>
            var time = 500;
            var url = "<?= constant("url") ?>";
            setTimeout(function () {
                window.print();
                window.location = url + "reportes";
            }, time);
        </script>
    </body>

</html>
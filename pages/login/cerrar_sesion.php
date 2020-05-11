<?php

$cambios["Sesi_n_activa"] = false;
$api->modificar_registro("Contacts", $cambios, $_SESSION['usuario_id']);

session_unset();
session_destroy();
setcookie("usuario_id", '', 1);

header("Location:" . constant("url"));
exit();
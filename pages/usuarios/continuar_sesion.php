<?php

$usuario = json_decode($_COOKIE["usuario"], true);

setcookie("usuario", '', time() - 1, "/");
setcookie("usuario", json_encode($usuario), time() + 3600, "/");
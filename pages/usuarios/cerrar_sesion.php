<?php

setcookie("usuario", '', time() - 1, "/");

header("Location:" . constant("url"));
exit;
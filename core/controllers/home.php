<?php

class home {

    function error() {
        require_once 'core/views/home/error.php';
    }

    function inicio() {
        require_once 'core/views/layout/header.php';
        require_once 'core/views/home/index.php';
        require_once 'core/views/layout/footer.php';
    }

}

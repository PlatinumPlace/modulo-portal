## Recursos

- https://github.com/zoho/zcrm-php-sdk (ZOHO SDK PHP)
- https://github.com/BlackrockDigital/startbootstrap-blog-post (template)
- https://ionicons.com/ (iconos)

## Referencias

- https://www.zoho.com/crm/developer/docs/php-sdk/sample-codes.html
- https://www.zoho.com/es-xl/crm/developer/docs/server-side-sdks/php.html

## Acerca de la WebApp

Es un sistema de cotización y emisión de seguros. Esta pensado para ser una extensión del CRM donde tener acceso limitado a algunos módulos. El proceso principal consta de: creación de una cotización,selección de aseguradora y emisión de la póliza. En el caso de uso,intervienen las siguiente entidades:

- **Vendedor**: son los usuarios finales,utilizan cuentas creadas a partir de registros del modulo "Contacto".
- **Intermediario**: quienes tiene control del CRM,determinan la información que se refleja de los módulos.
- **Aseguradora**: junto al vendedor, determina los valores y planes que se pueden vender.

# Documentación
## Como instalar la api

Completando el formulario en install.php.

## install.php

Es un formulario que genera un **token de acceso** usando usando un  **token de concesión**. Se recomiendo usar el **ámbito** de ejemplo porque da acceso a todo los módulos del CRM. El retorno del post es la generación del token en api/zcrm_oauthtokens.txt.

> Referencia : https://www.zoho.com/es-xl/crm/developer/docs/server-side-sdks/php.html#Initialization

## app.php

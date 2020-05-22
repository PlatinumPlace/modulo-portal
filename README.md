## Recursos

- https://github.com/zoho/zcrm-php-sdk (ZOHO SDK PHP)
- https://github.com/BlackrockDigital/startbootstrap-blog-post (template)
- https://ionicons.com/ (iconos)

## Referencias

- https://www.zoho.com/crm/developer/docs/php-sdk/sample-codes.html
- https://www.zoho.com/es-xl/crm/developer/docs/server-side-sdks/php.html

## Acerca de la WebApp

Es un sistema de cotización y emisión de seguros. Esta pensado para ser una extensión del CRM donde tener acceso limitado a algunos módulos. **El proceso principal consta de**: creación de una cotización,selección de aseguradora y emisión de la póliza. En el caso de uso,intervienen las siguiente entidades:

- **Vendedor**: son los usuarios finales,utilizan cuentas creadas a partir de registros del modulo "Contacto".
- **Intermediario**: quienes tiene control del CRM,determinan la información que se refleja de los módulos.
- **Aseguradora**: junto al vendedor, determina los valores y planes que se pueden vender.

Los módulos del CRM que intervienen en la WebApp son:

- **Cuentas**: son las entidades que venden los planes de seguros.
- **Contactos**: son los usuarios de las cuentas y los clientes de las emisiones.
- **Proveedores**: en este caso,los registros son las aseguradoras.
- **Productos**: en este caso,los registros son planes de seguros de las aseguradoras.
- **Contratos**: son registros que contiene los datos del contrato entre el vendedor,el intermediario y las aseguradoras,como las coberturas,los limites,las comisiones,etc.
- **Tasas**: son registros derivados de los contratos,contienen valores por cada año de cobertura del seguro y el tipo del vehículo.
- **Vehículos Restringidos**: son marcas y modelos bloqueados por las aseguradoras.
- **Ofertas**: son registros principales,parte de los demás módulos re relacionan con el.
- **Cotizaciones**: son registros secundarios, parte de los demás módulos re relacionan con el.
- **Pólizas**: son entidades aseguradas en las emisiones.
- **Bienes**: son entidades relacionadas con las pólizas que extienden las coberturas especificadas en los contratos.
- **Marcas**: es una base de datos con marcas de vehículos.
- **Modelos**: es una base de datos con modelos de vehículos.

# Documentación
## Como instalar la api

Completando el formulario en install.php.

## install.php

Es un formulario que genera un **token de acceso** usando usando un  **token de concesión**. Se recomiendo usar el **ámbito** de ejemplo porque da acceso a todo los módulos del CRM. El retorno del post es la generación del token en api/zcrm_oauthtokens.txt.

> Referencia : https://www.zoho.com/es-xl/crm/developer/docs/server-side-sdks/php.html#Initialization

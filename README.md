# Prueba de Software - Gestión de Inventario y Ventas

Este es un proyecto de software que permite gestionar el inventario de productos y realizar ventas. A continuación, se presentan las consideraciones para la instalación y puesta en marcha de la prueba.

## Requisitos previos

- Servidor web (por ejemplo, Apache) con soporte para PHP y MySQL.
- MySQL Server instalado y configurado.
- Conexión a Internet para descargar bibliotecas y recursos adicionales.

## Instalación

1. Clone o descargue este repositorio en el directorio raíz de su servidor web.

2. Cree una base de datos MySQL para el proyecto. Puede utilizar el siguiente comando en la línea de comandos de MySQL:

CREATE DATABASE konecta_cafeteria;

3. Importe el archivo `konecta_cafeteria.sql` en la base de datos recién creada. Puede utilizar el siguiente comando en la línea de comandos de MySQL:


4. Configure las credenciales de conexión a la base de datos. Abra el archivo `config.php` y actualice los valores de `DB_HOST`, `DB_USER`, `DB_PASSWORD` y `DB_NAME` con la información correspondiente.

## Puesta en marcha

1. Acceda al proyecto a través de su servidor web. Por ejemplo, si está utilizando Apache localmente, puede acceder a través de `http://localhost/sitio-web-konecta`.

2. Asegúrese de que el servidor web tenga los permisos adecuados para leer, escribir y ejecutar los archivos y carpetas del proyecto.

3. Ahora podrá crear, editar, eliminar y listar productos desde la interfaz web. Además, podrá realizar ventas y actualizar el stock de productos.

## Consideraciones adicionales

- Asegúrese de que la extensión `mysqli` de PHP esté habilitada en su servidor web.
- Puede personalizar la apariencia del proyecto modificando los estilos en bootstrap.

## Contribución

Si desea contribuir a este proyecto, no dude en enviar pull requests o abrir issues en el repositorio correspondiente.

## Licencia

Este proyecto está bajo la Licencia MIT. Consulte el archivo `LICENSE` para obtener más información.

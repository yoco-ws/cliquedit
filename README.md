# cliquedit
## The CMS for Everyone

###What is cliquedit?
Is a Headless Content Management System,  from okskñvcñlkxzcvñlkxzcvlknxlñkn xkj xlkjh xkljh klxjh kxjh kxljh x

Es un CMS Headless desarrollado con el fin de lograr la gestión de contenidos de sitios web diseñados y programados a medida, sin frameworks

Licencias y cómo adquirirlo

Ventajas

Dependencias (jQuery)

Requerimientos base (Servidor Apache con PHP y módulos de CURL para el webservice)

Instalación (Descarga manual)


1. Descargar el zip, descomprimirlo y guardarlo en el servidor.

2. Editar archivo de configuración (api_key, home, install_dir, mediaDir

3. En cada página o en un archivo global del sitio, importar la librería cliquedit, en la primera línea HMTL 
<?php require(‘cliquedit/cliquedit.php’); ?>

4. Obtener una instancia de cliquedit.
<?php $cliqued = \CE\CliquedIt::getInstance(); ?>

5. Obtener las páginas o categorías a cargar. Si no existen, en este paso son creadas.
<?php	//Requests pages or categories to load
	$cliqued->page()->load([
		'page' => $config['home'],
		'category' => 'test,test-2'
	]);
?>

6. Especificar a cliquedit cuál es el inicio de la página.
<?php $cliqued->page()->start() ?>

Cómo funciona (Aquitectura, diseño, etc. No lo veo tan necesario para una documentación de implementación pero es un plus)

Preparación (Como preparar la página para que se pueda empezar a llamar las funciones de CE)

Uso básico (Como volver editables Textos, Imagenes, Anclas, Audios, Videos, Códigos Embebidos )

Uso avanzado ( Parametros adicionales para cada método como el richtext, implementaciones avanzadas como comportamientos diferentes cuando la sesión esta iniciada )


Plataformas soportadas (Todos los navegadores, excepto en la plataforma iOS )


Uso avanzado ( Colecciones y artículos )

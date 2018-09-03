# cliquedit
## The CMS for Everyone

### What is cliquedit?
Is a Headless Content Management System,  developed to create and edit content to be delivered to any media output.

Current ALPHA version is only for HTML/CSS websites and the first API is developed in PHP language.

cliquedit is being tested in several websites and is aimed to work seamlessly in any framework enviroment. It's been proved to work fine with other APIs like Shopify, PayPal, Conekta and custom PHP systems.

Current version is recommended to be used only on freshly developed, unframed, websites.

### Licences / How to buy
cliquedit is free to test in any non-commercial website. To ask for a Developers API Key, just write to hello@cliqued.it

For commercial websites you should go to our website cliqued.it and purchase a Single Website Licence or a Multi Website Licence (recommended for web development, marketing or advertising agencies) in our webstore.


### Benefits
cliquedit reduces CMS integration time to almost zero.
cliquedit can be integrated to any HMTL/CSS website whitout any specific design practice.
cliquedit is highly friendly and intuitive for the final user.



### Dependencies 

(jQuery)



### Base requirements

(Servidor Apache con PHP y módulos de CURL para el webservice)


### Installation 

(Descarga manual)


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

# cliquedit
## The CMS for Everyone

### What is cliquedit?
Is a Headless Content Management System,  developed to create and edit content to be delivered to any media output.

Current ALPHA version is only for HTML/CSS websites and the first API is developed in PHP language.

cliquedit is being tested in several websites and is aimed to work seamlessly in any framework enviroment. It's been proved to work fine with other APIs like Shopify, PayPal, Conekta and custom PHP systems.

Current version is recommended to be used only on freshly developed, unframed, websites.

### Licences / How to buy
cliquedit is free to test in any non-commercial website with Developers API Key. To ask for a Developers API Key, just write to hello@cliqued.it

For commercial websites you should go to our website cliqued.it and purchase a Single Website Licence or a Multi Website Licence (recommended for web development, marketing or advertising agencies) in our webstore.

### Benefits
cliquedit reduces CMS integration time to almost zero.
cliquedit can be adapted to any HMTL/CSS website, regardless of its structure.
cliquedit is highly friendly and intuitive for the final user.

### How it works

Each page has an unique numeric ID...
(Aquitectura, diseño, etc. No lo veo tan necesario para una documentación de implementación pero es un plus)

### Dependencies 

jQuery ___

### Base requirements

PHP Server with CURL Modules enabled.

### Installation 

Manually download or clone cliqu**edit** repository to any directory within your project. We recommend you to place cliqu**edit** directory in your project root.

### Get started

1. Edit config file `config.ini`:

`api_key` - The secret key provided by cliqu**edit**

`home`- This is your website home, where the user is redirected after login.

`install_dir` - The absolute path where cliqu**edit** directory is installed.

`media_dir` - The absolute path where your uploaded media files should be saved.

**All parameters are required**

2. Import cliqu**edit** library into any file that will require it, before HTML markup:

`<?php require(‘cliquedit/cliquedit.php’); ?>`

### How to use

1. Get the instance of cliqu**edit** object:

`<?php $cliqued = \CE\CliquedIt::getInstance(); ?>`

2. Request cliqu**edit** to load the page content based on its ID. Additionally you can request any number of collection content to be used in the page.

If the page hasn't been created yet, this function will create it with the given ID.

```php
<?php	//Requests pages or collections to load
	$cliqued->page()->load([
		'page' => $config['home'], //required
		'collection' => 'test,test-2' //optional. One or more comma-separated collections
	]);
?>
```

3. Especificar a cliqu**edit** cuál es el inicio de la página.

`<html <?php $cliqued->page()->start() ?> lang="en">`


### Preparación 

(Como preparar la página para que se pueda empezar a llamar las funciones de CE)


### Basic use

(Como volver editables Textos, Imagenes, Anclas, Audios, Videos, Códigos Embebidos )

### Advanced use

( Parametros adicionales para cada método como el richtext, implementaciones avanzadas como comportamientos diferentes cuando la sesión esta iniciada )

( Colecciones y artículos )


### Plataformas soportadas 

(Todos los navegadores, excepto en la plataforma iOS )



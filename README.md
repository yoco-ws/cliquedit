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
Cliquedit takes the default values if the connection is lost...
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

```php
require(‘cliquedit/cliquedit.php’); 
```

### How to use

1. Get the instance of cliqu**edit** object:

```php
$cliqued = \CE\CliquedIt::getInstance(); 
```

2. Request cliqu**edit** to load the page content based on its ID. Additionally you can request any number of collection content to be used in the page.

If the page hasn't been created yet, this function will create it with the given ID.

```php
//Requests pages or collections to load
$cliqued->page()->load([
	'page' => $config['home'], //required
	'collection' => 'test,test-2' //optional. One or more comma-separated collections
]);
```

3. Specify the page start. It should be the `<html>` tag:

```php
<html <?php $cliqued->page()->start() ?> lang="en">
```

4. Call the `loadEditor()` function before the end of `<body>` to activate the content edition tools when a cliqu**edit** session is open. Make sure this function call is after the jQuery script.
	
```php
$cliqued->loadEditor()
```

### Basic use

#### Text

A text could be a title, a paragraph, or the text within an anchor. It's basically the content of a text html tag such as a `<p>`, `<h1>`, `<strong>` and so on.
In order to convert a static text into an editable text you use the function `render()` of the text object.

```php
//The text render function
$cliqued->text()->render('name', [
	'text' => 'Default content',
	'richtext' => true
]);
```

Where `name` is a custom string name given to this particular element. It's a good practice to name your elements based on what they are, so the name of a banner title could be `title-banner`.

Optional Parameters:

`text` - A string used to give a default text to this element. This text will be displayed if the element hasn't been edited before, if not provided it will display a generic text line.

`richtext` - A boolean parameter to enable or disable rich text edition for this element. Defaults to false.

##### Example
```php
<!-- Static title -->
<h1 class="h1"> Welcome to my website! </h1>

<!-- Editable title -->
<h1 class="h1">
	
	<?php $cliqued->text()->render('title-banner', [
		'text' => 'Welcome to my website!'
	]); ?>
	
</h1>

```

#### Image

An image is an element represented by the `<img>` tag. As of now, the Alpha version of cliqu**edit** only supports the edition of `<img>` tags.

In order to convert a static image into an editable image you use the function `render()` of the image object.

```php
//The image render function
$cliqued->image()->render('name', [
	'src' => '/path/to/image',
	'alt' => 'Default description'
]);
```

Where `name` is a custom string name given to this particular element.

Optional Parameters:

`src` - The path to the default image file. This image will be displayed if the element hasn't been edited before, if not provided it will display a generic image.

`alt` - The default content of the `alt` attribute which will appear unless the element is edited. Defaults to an empty description.

##### Example
```php
<!-- Static image -->
<img class="img-fluid" src="img/resources/banner.png" />

<!-- Editable image -->
<img class="img-fluid" <?php $cliqued->image()->render('banner', ['src' => 'img/resources/banner.png']) ?> />

```

#### Link

An image is an element represented by the `<img>` tag. As of now, the Alpha version of cliqu**edit** only supports the edition of `<img>` tags.

In order to convert a static image into an editable image you use the function `render()` of the image object.

```php
//The image render function
$cliqued->image()->render('name', [
	'src' => '/path/to/image',
	'alt' => 'Default description'
]);
```

Where `name` is a custom string name given to this particular element.

Optional Parameters:

`src` - The path to the default image file. This image will be displayed if the element hasn't been edited before, if not provided it will display a generic image.

`alt` - The default content of the `alt` attribute which will appear unless the element is edited. Defaults to an empty description.

##### Example
```php
<!-- Static image -->
<img class="img-fluid" src="img/resources/banner.png" />

<!-- Editable image -->
<img class="img-fluid" <?php $cliqued->image()->render('banner', ['src' => 'img/resources/banner.png']) ?> />

```

#### Audio


#### Video


#### Embedded code



### Advanced use

( Parametros adicionales para cada método como el richtext, implementaciones avanzadas como comportamientos diferentes cuando la sesión esta iniciada )

( Colecciones y artículos )


### Plataformas soportadas 

(Todos los navegadores, excepto en la plataforma iOS )



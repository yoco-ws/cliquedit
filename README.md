# cliquedit
## The CMS for Everyone

### Index

#### 1. What is cliquedit?

1.1. [Licences](#11-licences)
 
1.2. [Benefits](#12-benefits)

1.3. [How it works](#13-how-it-works)

1.4. [Dependencies](#14-dependencies)

1.5. [Base requirements](#15-base-requirements)

#### 2. Getting started

2.1. [Installation](#21-installation)

2.2. [Get started](#22-get-started)

2.3. [How to use](#23-how-to-use)

#### 3. Basic use

3.1. [Text](#31-text)

3.2. [Image](#32-image)

3.3. [Link](#33-link)

3.4. [Audio](#34-audio)

3.5. [Video](#35-video)

3.6. [Embedded code](#36-embedded-code)


#### 4. Advanced use

4.1. [Composed elements](#41-composed-elements)

4.2. [Collections and items](#42-collections-and-items)

4.3. [Items as full pages](#43-items-as-full-pages)

[Supported platforms](#supported-platforms)






### 1. What is cliquedit?
Is a Headless Content Management System,  developed to create and edit content to be delivered to any media output.

Current ALPHA version is only for HTML/CSS websites and the first API is developed in PHP language.

cliquedit is being tested in several websites and is aimed to work seamlessly in any framework enviroment. It's been proved to work fine with other APIs like Shopify, PayPal, Conekta and custom PHP systems.

Current version is recommended to be used only on freshly developed, unframed, websites.

#### 1.1. Licences
cliquedit is free to test in any non-commercial website with Developers API Key. To ask for a Developers API Key, just write to hello@cliqued.it

For commercial websites you should go to our website cliqued.it and purchase a Single Website Licence or a Multi Website Licence (recommended for web development, marketing or advertising agencies) in our webstore.

#### 1.2. Benefits
cliquedit reduces CMS integration time to almost zero.
cliquedit can be adapted to any HMTL/CSS website, regardless of its structure.
cliquedit is highly friendly and intuitive for the final user.

#### 1.3. How it works

The process of cliqu**edit** is divided in 2 phases. In the first phase, the programmer needs to define which elements should be editable and which shouldn't, then they will use the proper cliquedit functions of each singleton Object corresponding to each type of element to **render** a specific structure that cliquedit can understand in the editing phase.
When coding, most of these functions will replace existing HTML attributes. For example, in an `img` tag that is usually written as `<img src="somefile.png" alt="My file!" />`, since the `src` and `alt` attributes are what we want to make "editable", we replace them with the proper function of the `Image` object, which will render editable src and alt attributes.

Each of these editable elements will require a name that must be unique among the elements of the same type and in the same page or item in a collection. This means that you can only define an element named 'title' when you use a Text element on a particular page, but you can use the same name on a different kind of element in the same page. cliqu**edit** works under the premise that every page that uses cliqu**edit** in your website has an unique ID, defined as an integer value.

cliqu**edit** identifies these elements with the given name, the type of element, and page/collection-item id. For example, a text and embedded code elements, both named 'header', can be used in a page 1, 2, or in the first item of some collection and their values will be different in each case.

cliqu**edit** will request the required content when the user loads the page. The requested content is obtained based on the page ID or the specified collections, if needed. Then, it will insert the values of each unique cliqu**edit** element to their proper DOM elements. If no content is found of a particular element, cliquedit will display either a generic default value or a custom-defined default value, if it was specified when rendering the element.

The second phase consist of the interaction of the final user with the cliqu**edit** editor, in which the application will detect the user events and handle them properly, recieving data and sending AJAX requests to the cliqu**edit** servers so that it can store the new values of the modified elements. 

#### 1.4. Dependencies 

jQuery 3.2.1 or higher.

#### 1.5. Base requirements

PHP Server (5.6 or higher) with CURL Modules enabled.

### 2. Getting started

#### 2.1. Installation 

Manually download or clone cliqu**edit** repository to any directory within your project. We recommend you to place cliqu**edit** directory in your project root.

#### 2.2. Get started

1. Edit config file `config.ini` inside the Cliquedit directory:

`api_key` - The secret key provided by cliqu**edit**

`home`- This is your website home, where the user is redirected after login.

`install_dir` - The absolute path where cliqu**edit** directory is installed.

`media_dir` - The absolute path where your uploaded media files should be saved.

**All parameters are required**

2. Import cliqu**edit** library into any file that will require it, before HTML markup:

```php
require(‘cliquedit/cliquedit.php’); 
```

#### 2.3. How to use

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

Required parameters

`page` - An integer used to identify the page to be loaded.

Optional parameters

`collections` - A comma-separated string specifying which collections you will be using in the page. Optionally, you can use a pipe to indicate the number of items to request for each collection. This is the structure:

`[collection-name(|n)?,]+` 

where `collection-name` is the name of the collection and `n` is the number of items to request.

```php
//This will load the first 10 items of the collection named 'carousel', the whole 'list' collection and 20 items of the 'gallery' collection; as well as the content of page number 6.
$cliqued->page()->load([
	'page' => 6,
	'collections' => 'carousel|10,list,gallery|20'
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

### 3. Basic use

#### 3.1. Text

A text could be a title, a paragraph, or the text within an anchor. It's basically the content of a text html tag such as a `<p>`, `<h1>`, `<strong>` and so on.
In order to convert a non editable text into an editable text you use the function `render()` of the text object.

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
```html+php
<!-- Non editable title -->
<h1 class="h1"> Welcome to my website! </h1>

<!-- Editable title -->
<h1 class="h1">
	
	<?php $cliqued->text()->render('title-banner', [
		'text' => 'Welcome to my website!'
	]); ?>
	
</h1>

```

#### 3.2. Image

An image is an element represented by the `<img>` tag. As of now, the Alpha version of cliqu**edit** only supports the edition of `<img>` tags.

In order to convert a non editable image into an editable image you use the function `render()` of the image object.

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
<!-- Non editable image -->
<img class="img-fluid" src="img/resources/banner.png" />

<!-- Editable image -->
<img class="img-fluid" <?php $cliqued->image()->render('banner', ['src' => 'img/resources/banner.png']) ?> />

```

#### 3.3. Link

A link or anchor is an element represented by the `<a>` tag.

In order to convert a non editable link into an editable link you use the function `render()` of the link object.

```php
//The link render function
$cliqued->link()->render('name', [
	'href' => 'https://cliqued.it',
]);
```

Where `name` is a custom string name given to this particular element.

Optional Parameters:

`href` - The default `href` attribute of this `<a>` tag. This value will be used if the element hasn't been edited before, if not provided it will use a `#`.

##### Example
```php
<!-- Static link -->
<a href="https://cliqued.it" target="_blank"> Cliqued.it </a>

<!-- Editable link -->
<a <?php $cliqued->link()->render('banner-link', ['href' => 'https://cliqued.it']) ?> target="_blank"> Cliqued.it </a>
```

#### 3.4. Audio

An audio is an element represented by the `<audio>` tag. cliquedit supports only audios with a single file, using the `src` attribute of the audio tag. It doesn't support the `<source>` tags within the audio structure. 

In order to convert a non editable audio into an editable audio you use the function `render()` of the audio object.

```php
//The audio render function
$cliqued->audio()->render('name', [
	'src' => '/path/to/sound/file',
]);
```

Where `name` is a custom string name given to this particular element.

Optional Parameters:

`src` - The default `src` attribute of this `<audio>` tag. This value will be used if the element hasn't been edited before. Defaults to an empty audio.

##### Example
```php
<!-- Non editable audio -->
<audio src=""> </audio>

<!-- Editable audio -->
<audio <?php $cliqued->audio()->render('banner-music', ['src' => 'media/audio/cliquedit.mp3']) ?>> </audio>

```


#### 3.5. Video

A video is an element represented by the `<video>` tag. cliqu**edit** supports only videos with a single file, using the `src` attribute of the video tag. It doesn't support the `<source>` tags within the video structure. 

In order to convert a non editable video into an editable video you use the function `render()` of the video object.

```php
//The video render function
$cliqued->video()->render('name', [
	'src' => '/path/to/video/file',
]);
```

Where `name` is a custom string name given to this particular element.

Optional Parameters:

`src` - The default `src` attribute of this `<video>` tag. This value will be used if the element hasn't been edited before. Defaults to a generic video.

##### Example
```php
<!-- Non editable video -->
<video src=""> </video>

<!-- Editable video -->
<video <?php $cliqued->video()->render('banner-video', ['src' => 'media/video/cliquedit.mp4']) ?>> </video>

```

#### 3.6. Embedded code

cliquedit allows to include embedded code such as Google Maps or YouTube Videos within a page by using the function `render()` of the embed object.

```php
//The embed render function
$cliqued->embed()->render('name', [
	'code' => '<iframe>This is some content</iframe>',
]);
```

Where `name` is a custom string name given to this particular element.

Optional Parameters:

`code` - The default content. This value will be used if the element hasn't been edited before. Defaults to a generic text.

##### Example
```php
<!-- Non editable embedded code -->
<div class="container"> 
	<iframe src="https://player.vimeo.com/video/287722915" allowfullscreen></iframe>
</div>

<!-- Editable embedded code -->

<div class="container">
	<?php $cliqued->embed()->render('banner-embed', [
		'code' => '<iframe src="https://player.vimeo.com/video/287722915" allowfullscreen></iframe>'
	]) ?>
</div>
```



### 4. Advanced use

#### 4.1. Composed Elements

The composed element enables cliqu**edit** to create dynamic elements that can transform into other type of elements. For example, this allows the final user to convert a text element into a video or an embedded code. It also enables the option to hide these elements.

The composed element uses a basic markup for the elements it generates. This prevents you to use your own markup for these elements.

In order to create a composed element you use the function `render()` of the composed object.

```php
//The composed render function
$cliqued->composed()->render( 'name', types );
```

Where `name` is a custom string name given to this particular element.

Required Parameters:
`types` - An array that contains the list of elements types that this composed element can transform into. The supported elements are `text`,`image`, `audio`, `video`, `embed`, `none`. Requires at least one type of element. Passing the `none` type will allow you to hide this element.

##### Example
```php
<!-- Composed element that can be either a text or an image -->
<div>
	<?php $cliqued->composed()->render('dynamic-content', ['text', 'image']) ?>
</div>

<!-- Composed element that can be either a image, video, and can be hidden -->
<div>
	<?php $cliqued->composed()->render('other-dynamic-content', ['image', 'video', 'none']) ?>
</div>

```

#### 4.2. Collections and Items
By using the cliquedit `collection` and `item` objects you can define your own editable components and use them accross different sections of your website, regardless of the containing page. The information stored within the items of a collection is preserved through all your project, meaning that you can use these items and their stored information in any page.

cliquedit Items can also be multiplied, this enables you to define a component such as a carousel, where the collection would be `carousel` and each of it's items would be a `slide`.

In order to use cliquedit collections you must first define where in your code the collection starts with the `collection()->start()` method. The beggining could be the opening tag of a `<div>` for example. This div element will contain one or more `items`. In the following example we will use the `render()` method of the Collection object to create a carousel with multiplicable slides.

The render() method of the Collection will require a `view` in which you will define the structure of your items.

```html+php
<div <?php $cliqued->collection()->start('name') ?> >
			
	<?php $cliqued->collection->render([
		'view' => 'path/to/file',
		'allowAddition' => true,
		'count' => n
	]) ?>

</div>
```

Required parameters for the `render()` method of the `Collection` object.

`view` - The path to the file where you define the structure of the items used by this collection.

Optional parameters.

`allowAddition` - Whether or not to allow the final user to create new items of the collection. Useful when you need to disable this function in a particular section of you website. Defaults to true.

`count` - An integer used to determine how many items will be "printed" with the render method. cliquedit gets the items and stores them as a stack, and everytime the render method displays an item, it will pop it out of the stack. This means that if you have 10 items and pass a parameter of `count => 7`, there will be 3 more items left in the stack. This is useful because you can pass print the first 7 elements with a particular view, and the next 3 with a different view, somewhere else in the same page. If not specified, this method prints every item in the stack.


#####Example

```html+php
<!-- This div will be our collection, so we mark it's beggining with the collection()->start() method -->
<div class="carousel" <?php $cliqued->collection()->start('carousel') ?> >
			
	<?php $cliqued->collection->render([
		'view' => 'views/componentes/carousel-slide.php', //This is where we define the structure of a slide
		'allowAddition' => true
	]) ?>

</div>
```

**views/componentes/carousel-slide.php**
```html+php
<!-- We mark the beggining of this item -->
<div class="slide" data-carousel <?php $cliqued->collection()->item() ?> >
	<img <?php $cliqued->image()->render('banner', ['src' => 'img/resources/banner.png']) ?> >
</div>
```
This will create a Collection named `carousel` with multiplicable items, where the HTML of each item is defined in a carousel-slide.php file. You can call this collection and it's items anywhere, and you can even pass a different view if you needed.

It's important to note that when using collections you must specify `cliquedit` which collections you will be using, so that it can load the requested information when making the API call.

```php
//This will load the first 10 items of the collection named 'carousel', as well as the content of page number 6
$cliqued->page()->load([
	'page' => 6,
	'collections' => 'carousel|10'
]);
```


#### 4.2.1. Items as full pages
You may want to show a more detailed view of each item in a Collection, in addition to the basic view previously shown. This is the case for blog articles, image galleries and landing pages.

The `render()` method of the Collection object allows you to define the path to this full page view, which would normally be the path to a php file. This will enable you to insert a link in the "printed" items, and this link will take you to the full page view with the proper GET parameters. These parameters are the name of the collection and the id of the corresponding item. This is the same logic used in most implementations of a blog.

Therefore, we will first need to render the collection with the proper links and we do this by using the `render()` method of the Collection object with the `fullPagePath` parameter:

```html+php
$cliqued->collection->render([
	'view' => 'path/to/file',
	'allowAddition' => true,
	'count' => n,
	'fullPagePath' => 'path/to/full/view'
]) ?>
```

Where `fullPagePath` is a string that defines the path to a file that will be used when rendering the links of each item. Each item will have a unique link with it's proper id and collection as GET parameters. For example, if you pass the value "post.php" to this parameter, the rendered links would look like this `post.php?collection=collection_name&id=n` where `n` is the id of the automatically generated item.

You can even customize the name of these GET parameters by passing the `itemAlias` and `collectionAlias` in the `render()` method, so if you call the method like this:

```html+php
$cliqued->collection->render([
	'view' => 'views/modules/document_preview.php',
	'allowAddition' => true,
	'count' => 10,
	'fullPagePath' => 'document.php',
	'itemAlias' => 'folio',
	'collectionAlias' => 'city'
]) ?>
```
Assuming that this render methods corresponds to a collection named "New_York", when rendering the links it will result in `document.php?city=New_York&folio=120`.

Lastly, you also need to specify where in your items you want to render these links using the `fullPagePath()` method of the Collection object. For this example, we do this in the `views/modules/document_preview.php` since thats the file used to define the structure of each item.

**views/modules/document_preview.php**
```html+php
<div class="document-preview" <?php $cliqued->collection()->item() ?> >
	<img <?php $cliqued->image()->render('document-thumbnail', ['src' => 'img/resources/document-thumb.png']) ?> >
	<a <?php $cliqued->collection()->fullPagePath() ?> > Read more </a> //This will print the proper url previously discussed
</div>
```

With this you would have created a multipliable collection of items, each with an automatically generated, working url.

Next you will need to handle these GET parameters in your `fullPagePath` file. The first thing you need to do is to ask `cliquedit` to request the given item and it's collection as a `Single Item`. A single article contains additional information such as the meta tags of this item and it's previous and next items.

We do this by passing the `|single` option for this collection in the load() method of the Page object.

```php
$cliqued->page()->load([
	'page' => 7,
	'collections' => $_GET['city'].'|single',
	'itemId' => $_GET['folio']
]);
```

Assuming the GET parameters of city = New_York and folio = 100, this method will request the full information of the item with id 100 of the New_York collection.

Now you need to identify the beggining of the collection and the item in the `fullPagePath` file. This could be either the entire page, or just a smaller section of it.

We do this by passing the `itemAsPage` parameter on the `collection()->start()` method. This tells cliqued that there will be a single article of the given collection inside this element, and this item will have access to the more detailed options such as the meta tags when editing.

```php
$cliqued->collection()->start( name, 'itemAsPage' )
```

As specified before, a collection by itself means nothing if there isn't an item inside of it. We need to define where in the page the item will start. We do this by using the `item()` method of the Collection object and manually passing the collection name and item id as parameters. 

```php
$cliqued->collection()->item( collectionName, itemId ] )
```


In this example we assume that the entire page is an item, allowing us to replicate this "page" as different pages. In reality we are simply changing the information of the item and not of the page itself, and this information is obtained based on the GET parameters.

```html+php
<!-- Mark the beggining of this page, and in this case, of the collection -->
<html <?php $cliqued->page()->start(); $cliqued->collection()->start( $_GET['city'], 'itemAsPage' ); ?> >

	<head>
	</head>
	
	<!-- Mark the beggining of this item-->
	<body <?php $cliqued->collection()->item( [ $_GET['city'], $_GET['folio'] ] ) ?> >
		...
	</body>

</html>
```

With this you can proceed to use cliqu**edit** as usual. Editable elements inside of the 'item' will belong to the current item (identified by the GET parameters), and editable items outside of this item will belong to the current page.



### Supported platforms 

(Todos los navegadores, excepto en la plataforma iOS )



# cliquedit
## The CMS for Everyone

### Index

#### 1. What is cliquedit?

1.1. [Licences](#licences)
 
1.2. [Benefits](#benefits)

1.3. [How it works](#how-it-works)

1.4. [Dependencies](#dependencies)

1.5. [Base requirements](#base-requirements)

#### 2. Getting started

2.1. [Installation](#installation)

2.2. [Get started](#get-started)

2.3. [How to use](#how-to-use)

#### 3. Basic use

3.1. [Text](#text)

3.2. [Image](#image)

3.3. [Link](#link)

3.4. [Audio](#audio)

3.5. [Video](#video)

3.6. [Embedded code](#embedded-code)


#### 4. Advanced use

4.1. [Composed elements](#composed-elements)

4.2. [Collections and items](#collections-and-items)

4.3. [Single, full view items](#single-full-view-items)

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

cliquedit replaces the attribute within the html tag being modified...
Each page has an unique numeric ID...
Cliquedit takes the default values if the connection is lost...
Each element has a unique name...
(Aquitectura, diseño, etc. No lo veo tan necesario para una documentación de implementación pero es un plus)

Up until now every element that has been used needed an unique `name`. These elements are unique per page, meaning that by repeating them you only replicate the content within 

#### 1.4. Dependencies 

jQuery ___

#### 1.5. Base requirements

PHP Server with CURL Modules enabled.

### 2. Getting started

#### 2.1. Installation 

Manually download or clone cliqu**edit** repository to any directory within your project. We recommend you to place cliqu**edit** directory in your project root.

#### 2.2. Get started

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


#### 4.2.1. Single, Full View Items
You may want to show a more detailed view of each item in a Collection, in addition to the basic view previously shown. This is the case for blog articles, image galleries and landing pages.

The `render()` method of the Collection object allows you to define the path to this detailed view, which would normally be the path to a php file. This will enable you to insert a link in the "printed" items, and this link will take you to the detailed view with the proper GET parameters. These parameters are the name of the collection and the id of the corresponding item. This is the same logic used in most implementations of a blog.

Therefore, we will first need to render the collection with the proper links and we do this by using the `render()` method of the Collection object with the `detailView` parameter:

```html+php
$cliqued->collection->render([
	'view' => 'path/to/file',
	'allowAddition' => true,
	'count' => n,
	'detailView' => 'path/to/detailed/view'
]) ?>
```

Where `detailView` is a string that defines the path to a file that will be used when rendering the links of each item. Each item will have a unique link with it's proper id and collection as GET parameters. For example, if you pass the value "post.php" to this parameter, the rendered links would look like this `post.php?category=collection_name&id=n` where  

In order to display an item in a full page view, use the `render()` method of the Collection with the optional parameter `detailedView`, in which you will specify the path to the full view template file.



```html+php
<div <?php $cliqued->collection()->start('name') ?> >
			
	<?php $cliqued->collection->render([
		'view' => 'path/to/file',
		'allowAddition' => true,
		'count' => true
	]) ?>

</div>
```



### Supported platforms 

(Todos los navegadores, excepto en la plataforma iOS )



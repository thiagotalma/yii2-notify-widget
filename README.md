yii2-notify
===========
Widget for Yii Framework 2.0 to use [Bootstrap Notify](https://github.com/goodybag/bootstrap-notify)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist thiagotalma/yii2-notify "*"
```

or add

```
"thiagotalma/yii2-notify": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by :

```php
<?= \talma\widget\Notify::widget(); ?>;
```
# Image resize crop  and watermark Class

> work with jpg jpeg png images


**Methods of wb3Image class:*

- setInput(file) - input file patch
- fillBox (width,height) - detect coner colors and fill space
- scale(width,height) -  set only one patam: width or height/ another set is 'null' 
- cropScale(width,height) - crop image by set size
- wmText(text,font) - text watermark  and font .ttf full path
- output() - reurn file jpg header
- outputFile(file) - output file pacth  




## Example (php)

```
<?php
require "wb3image.php";
$img = new wb3Image();
$img->setInput('test.jpg');
$img->fillBox(500, 500);
$img->scale(null, 300);
$img->cropScale(300, 300);
$img->wmText('watermark', './OpenSans-Regular.ttf');
$img->output();

```
***Original***

[![INSERT YOUR GRAPHIC HERE](http://ialexeev.cloud/wbmods/wb3image/test.jpg)]()

***Output***

[![INSERT YOUR GRAPHIC HERE](http://ialexeev.cloud/wbmods/wb3image/index.php)]()


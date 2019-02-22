How to use:

include "wb3image.php";
$img = new wb3Image();
$img->setInput('test.jpg');

$img->fillBox($width, height);
$img->scale($width,$height);
$img->cropScale($width,$height);
$img->wmText($text,$font)

$img->output();

$img->outputFile($filename);

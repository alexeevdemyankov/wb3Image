<?php

class wb3Image
{
    private $inputImg = null;
    private $inputWidth = null;
    private $inputHeight = null;
    private $extensions = array('jpeg' => 'jpeg', 'jpg' => 'jpeg', 'png' => 'png');


    public function setInput($imgFile)
    {
        $infoArray = pathinfo($imgFile);
        if ($this->extensions[strtolower($infoArray['extension'])]) {
            $ext = $this->extensions[strtolower($infoArray['extension'])];
            $imgData = getimagesize($imgFile);
            $this->inputWidth = $imgData[0];
            $this->inputHeight = $imgData[1];
            $func = 'imagecreatefrom' . $ext;
            $this->inputImg = $func($imgFile);
        } else {
            echo 'Error no File or wrong extension. Succcesed : ' . implode(',', $this->extensions);
            return null;
        }
    }


    public function outputFile($filename)
    {
        ImageJpeg($this->inputImg, $filename, -1);
        ImageDestroy($this->inputImg);
    }

    public function output()
    {
        Header("Content-type: image/jpeg");
        ImageJpeg($this->inputImg, null, -1);
        ImageDestroy($this->inputImg);
    }


    public function wmText($text, $font)
    {
        $textcolor = imagecolorallocatealpha($this->inputImg, 255, 255, 255, 80);
        $inputWidth = imagesx($this->inputImg);
        $inputHeight = imagesy($this->inputImg);
        $textWidth = $inputWidth - ($inputWidth * 0.2);
        $oneLetter = $textWidth / strlen($text);
        $fontSize = $oneLetter * 20 / 15;
        $y = $inputHeight / 2;
        $x = ($inputWidth - $textWidth) / 2;
        imagefttext($this->inputImg, $fontSize, 0, $x, $y, $textcolor, $font, $text);
    }

    public function fillBox($outWidth, $outHeight)
    {

        if ($this->inputWidth > $this->inputHeight) {
            $paddingH = ($this->inputWidth - $this->inputHeight) / 2;
            $paddingW = 0;
            $newH = $this->inputWidth;
            $newW = $this->inputWidth;
        } else {
            $paddingW = ($this->inputHeight - $this->inputWidth) / 2;
            $paddingH = 0;
            $newH = $this->inputHeight;
            $newW = $this->inputHeight;
        }


        $color[] = imagecolorat($this->inputImg, 1, 1);
        $color[] = imagecolorat($this->inputImg, $this->inputWidth - 1, 1);
        $color[] = imagecolorat($this->inputImg, 1, $this->inputHeight - 1);
        $color[] = imagecolorat($this->inputImg, $this->inputWidth - 1, $this->inputHeight - 1);
        $color[] = imagecolorat($this->inputImg, ($this->inputWidth - 1) / 2, 1);
        $color[] = imagecolorat($this->inputImg, 1, $this->inputHeight / 2);
        $color[] = imagecolorat($this->inputImg, ($this->inputWidth - 1) / 2, $this->inputHeight - 1);
        $color = array_count_values($color);
        arsort($color);
        $color = key($color);

        $outputImg = imagecreatetruecolor($newW, $newH);
        imagefilledrectangle($outputImg, 0, 0, $newW, $newH, $color);
        imagecopyresampled($outputImg, $this->inputImg, $paddingW, $paddingH, 0, 0, $this->inputWidth, $this->inputHeight, $this->inputWidth, $this->inputHeight);
        $this->inputWidth = $newW;
        $this->inputHeight = $newH;
        $this->inputImg = $outputImg;


    }


    public function scale($outWidth, $outHeight)
    {
        if ($outWidth) {
            $scalingFactor = $outWidth / $this->inputWidth;
            $outHeight = $this->inputHeight * $scalingFactor;
        } else {
            $scalingFactor = $outHeight / $this->inputHeight;
            $outWidth = $this->inputWidth * $scalingFactor;
        }
        $outputImg = imagecreatetruecolor($outWidth, $outHeight);
        imagecopyresampled($outputImg, $this->inputImg, 0, 0, 0, 0, $outWidth, $outHeight, $this->inputWidth, $this->inputHeight);

        $this->inputWidth = $outWidth;
        $this->inputHeight = $outHeight;
        $this->inputImg = $outputImg;

    }

    public function cropScale($outWidth, $outHeight)
    {
        $outputImg = imagecreatetruecolor($outWidth, $outHeight);
        $cropX = 0;
        $cropY = 0;

        if ($outWidth / $outHeight > $this->inputWidth / $this->inputHeight) {
            $cropWidth = floor($this->inputWidth);
            $cropHeight = floor($this->inputWidth * $outHeight / $outWidth);
            $cropY = floor(($this->inputHeight - $cropHeight) / 2);
        } else {
            $cropWidth = floor($this->inputHeight * $outWidth / $outHeight);
            $cropHeight = floor($this->inputHeight);
            $cropX = floor(($this->inputWidth - $cropWidth) / 2);
        }

        imagecopyresampled($outputImg, $this->inputImg, 0, 0, $cropX, $cropY, $outWidth, $outHeight, $cropWidth, $cropHeight);

        $this->inputWidth = $outWidth;
        $this->inputHeight = $outHeight;
        $this->inputImg = $outputImg;

    }

}

<?php
/**
* Class and Function List:
* Function list:
* - CreateBlankPNG()
* Classes list:
*/
/*
 * https://www.transparenttextures.com/
 * https://stackoverflow.com/questions/4060437/how-to-load-and-repeat-x-an-image-with-php-gd
 * https://www.php.net/manual/en/function.imagecopy.php
*/
$srcfile = 'arches.png';
$outfile = 'background.png';
list($src_w, $src_h, $src_type) = getimagesize($srcfile);

$out_w = 500;
$out_h = 739;

$src = imagecreatefrompng($srcfile);
$out = CreateBlankPNG($out_w, $out_h);

$curr_x = 0;
while ($curr_x < $out_w)
{
    $curr_y = 0;
    while ($curr_y < $out_h)
    {
        imagecopy($out, $src, $curr_x, $curr_y, 0, 0, $src_w, $src_h);
        $curr_y += $src_h;
    }
    $curr_x += $src_w;
}

imagepng($out, $outfile);
imagedestroy($src);
imagedestroy($out);

function CreateBlankPNG($w, $h)
{
    $im = imagecreatetruecolor($w, $h);
    imagesavealpha($im, true);
    $transparent = imagecolorallocatealpha($im, 0, 0, 0, 127);
    imagefill($im, 0, 0, $transparent);
    return $im;
}


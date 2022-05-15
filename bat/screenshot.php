<?php


$im = imagegrabscreen();
imagepng($im, "..\parses\parse1png\\".$argv[1].".png");
imagedestroy($im);
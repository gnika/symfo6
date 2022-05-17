<?php


$im = imagegrabscreen();
imagepng($im, "..\parses\parse2png\\".$argv[1].".png");
imagedestroy($im);
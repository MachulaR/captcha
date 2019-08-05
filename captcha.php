<?php

// captcha size
$captcha_width = 200;
$captcha_height = 50;
$captcha_size = [$captcha_width, $captcha_height];

//captcha background
$number_colors_background = 5;
$background_color = [rand(125, 175), rand(125, 175), rand(125, 175)];

// captcha text
$permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
$fonts = [dirname(__FILE__).'\fonts\Arial.ttf'];
$captcha_length = mt_rand(4,6);
$font_size = 20;

$hex000000 = [0, 0, 0]; // black
$hex808080 = [128, 128, 128]; // gray
$hexCCCCCC = [204, 204, 204]; // gray
$hexFFFFFF = [255, 255, 255]; // white
$text_colors = [$hex000000, $hex808080, $hexCCCCCC, $hexFFFFFF];

session_start();

$captcha = create_background($captcha_size, $number_colors_background, $background_color);
add_string_to_captcha($captcha, $captcha_width, $text_colors, $permitted_chars, $captcha_length, $fonts, $font_size);

header('Content-type: '.$captcha);
imagepng($captcha);
imagedestroy($captcha);

function add_string_to_captcha($image, $captcha_width, $text_colors, $permitted_chars, $captcha_length, $fonts, $font_size){
    $textColors = [];
    foreach ($text_colors as $col){
        $textColors[] = imagecolorallocate($image, $col[0], $col[1], $col[2]);
    }

    $captcha_string = generate_string($permitted_chars, $captcha_length);

    for($i = 0; $i < $captcha_length; $i++) {
        $letter_space = ($captcha_width-30)/$captcha_length;
        $initial = 15;

        imagettftext($image, $font_size, rand(-15, 15), $initial + $i*$letter_space, rand(20, 40), $textColors[rand(0, sizeof($text_colors)-1)], $fonts[array_rand($fonts)], $captcha_string[$i]);
    }
    $_SESSION['captcha_text'] = sha1($captcha_string);
}

function create_background($captcha_size, $number_colors_background, $background_color){
    $image = imagecreatetruecolor($captcha_size[0], $captcha_size[1]);

    imageantialias($image, true);

    $colors = [];

    for($i = 0; $i < $number_colors_background; $i++) {
        $colors[] = imagecolorallocate($image, $background_color[0] - 20*$i, $background_color[1] - 20*$i, $background_color[2] - 20*$i);
    }

    imagefill($image, 0, 0, $colors[0]);

    for($i = 0; $i < 10; $i++) {
        imagesetthickness($image, rand(2, 10));
        $rect_color = $colors[rand(1, $number_colors_background-1)];
        imagerectangle($image, rand(-10, 190), rand(-10, 10), rand(-10, 190), rand(40, 60), $rect_color);
    }

    return $image;
}

function generate_string($permitted_chars, $length) {

    $input_length = strlen($permitted_chars);
    $random_string = '';

    for($i = 0; $i < $length; $i++) {
        $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

?>

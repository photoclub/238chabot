<?php
$image = file_get_contents('https://dog.ceo/api/breed/retriever/golden/images/random');
$image = json_decode($image, true); // second parameter will make $breeds an array rather than an object

$image = $image['message']; // this is now a string containing the image URL

echo '<img src="'.$image.'" />';



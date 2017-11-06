<?php
$breeds = file_get_contents('https://dog.ceo/api/breeds/list/all');
$breeds = json_decode($breeds, true); // second parameter will make $breeds an array rather than an object

$breeds = $breeds['message']; // when you visit https://dog.ceo/api/breeds/list/all, you will see that there are two keys, "status" and "message". The first one indicates the status of this request which should simply be "success" while the second one is "message" which is a collection of the dog breeds.

$output = array();
foreach ($breeds as $breed => $array) {
	// sometimes, $array may contain variations of the dog breed.
	// if $array is not empty, it means there are other variations so let's just put a value into
	// the $array variable and loop through it below.
	if (count($array) == 0) $array[] = $breed;

	foreach ($array as $each) {
		if ($breed != $each) $each .= ' ' . $breed;
		// let's be fancy and capitalize words
		// instead of using echo right away, let's put it in an array
		// then echo the data later
		$output[] = ucwords($each);
	}
}

sort($output);
echo '<ol><li>'. implode('</li><li>',$output) . '</li></ol>';

<?php


$input_file = "input.txt";

if ($argc > 1) $input_file = "input-" . $argv[1] . ".txt";


$total = 0;


function generatePossibleValues($arr) {
	if (count($arr) > 1) {
		$right = array_pop($arr);
		foreach (generatePossibleValues($arr) as $recValue) {
			yield $recValue * $right;
			yield $recValue + $right;
			yield (int) ($recValue . $right);
		}
	} else {
		yield $arr[0];
	}
}

foreach (file($input_file) as $line) {
	$arr = explode(" ", trim($line));
	$value = (int) array_shift($arr);
	foreach (generatePossibleValues($arr) as $newVal) {
		if ($value == $newVal) {
			$total += $value;
			break;
		}
	}
}
var_dump($total);

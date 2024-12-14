<?php
$rules = [];
$pagePredecesors = [];

$suffix = "";

if ($argc > 1) $suffix = "-" . $argv[1];


foreach (file("rules" . ($suffix) . ".txt") as $line) {
	list($first, $second) = explode("|", trim($line));
	$rules[] = [$first, $second];
	if (!isset($pagePredecesors[$second])) $pagePredecesors[$second] = [];
	$pagePredecesors[$second][] = $first; 
}

$sum = 0;
$sumCorrected = 0;

function getMiddlePage($pages) {
	global $rules;
	foreach ($rules as $rule) {
		$firstIdx  = array_search($rule[0], $pages);
		$secondIdx = array_search($rule[1], $pages);
		if ($firstIdx === false || $secondIdx === false) continue;
		if ($firstIdx > $secondIdx) return 0;
	}
	return $pages[(count($pages) - 1) / 2];
}
function getCorrectedOrder($first, $second) {
	global $pagePredecesors;
	if (isset($pagePredecesors[$first])) {
		if (array_search($second, $pagePredecesors[$first]) !== false) {
			return 1;
		}
	}
	else if (isset($pagePredecesors[$second])) {
		if (array_search($first, $pagePredecesors[$second]) !== false) {
			return -1;
		}
	}
	return -1;
}


foreach (file("updates" . $suffix . ".txt") as $line) {
	$pages = explode(",", trim($line));
	$value = getMiddlePage($pages);
	if ($value > 0) {
		$sum += $value;
	} else {
		usort($pages, "getCorrectedOrder");
		$sumCorrected += $pages[(count($pages) - 1) / 2];
	}
}

echo "$sum\n$sumCorrected\n";

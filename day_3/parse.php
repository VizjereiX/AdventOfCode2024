<?php
$pattern = "/(mul\(((?R)|[0-9]{1,3}),((?R)|[0-9]{1,3})\))/m";


$sum = 0;
foreach (file("instructions.txt") as $line) {
	preg_match_all($pattern, $line, $matches, PREG_SET_ORDER );
	foreach ($matches as $match) {
		$sum += $match[2] * $match[3];
	}

}
echo "$sum\n";




$pattern = "/(do(n't)?\(\))|(mul\([0-9]{1,3},[0-9]{1,3}\))/";
$sum = 0;
$doSum = TRUE;
foreach (file("instructions.txt") as $line) {
	preg_match_all($pattern, $line, $matches, PREG_SET_ORDER );
	foreach ($matches as $match) {
		$numOfGroups = count($match);
		if ($numOfGroups == 2) {
			$doSum = true;
			continue;
		}		
		if ($numOfGroups == 3) {
			$doSum = false;
			continue;
		}
		if ($doSum) {
			list($a, $b) = explode(",", substr($match[0], 4, -1)); 
			$sum += $a * $b;
		}
	}

}
echo "$sum\n";







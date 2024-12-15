<?php


$input_file = "input.txt";

if ($argc > 1) $input_file = "input-" . $argv[1] . ".txt";


$fp = fopen($input_file, 'r');
if (!$fp) {
	    echo 'Could not open file somefile.txt';
}

$segments = [];

$diskMap = [];

$i = 0;
$sectorIsOccupied = true;

while (false !== ($char = fgetc($fp))) {
	if ($sectorIsOccupied) {
		$diskMap += array_fill(count($diskMap), (int) $char, $i); //str_repeat($i, (int) $char);
		$i++;
		$segments[] = (int) $char;
	} else {
		$diskMap +=  array_fill(count($diskMap), (int) $char, ".");
	}
	$sectorIsOccupied =  !$sectorIsOccupied;
}

$pos = count($diskMap) - 1;

// echo implode("_", $diskMap), "\n";

while ($pos>= 0) {
	if ($diskMap[$pos] != ".") {
		$segNum = (int) $diskMap[$pos];
		$len = $segments[$segNum];
		$freePos = array_search(".", $diskMap);
	
		if ($freePos === false || $freePos > $pos)  break;
	
		$diskMap[$freePos] = $segNum;
		$diskMap[$pos] = ".";
		// echo implode("_", $diskMap), "\n";
	}
	$pos--;
}

$checksum = 0;

for ($i = 0; $i< count($diskMap); $i++) {
	if ($diskMap[$i] == ".") break;
	$checksum += $i * (int) $diskMap[$i];
}

echo "Chekcsum:\t$checksum\n";

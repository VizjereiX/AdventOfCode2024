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
$pos = 0;

while (false !== ($char = fgetc($fp))) {
	if ($sectorIsOccupied) {
		$diskMap += array_fill(count($diskMap), (int) $char, $i); //str_repeat($i, (int) $char);
		$i++;
		$segments[] = [(int) $char, $pos];
	} else {
		$diskMap +=  array_fill(count($diskMap), (int) $char, ".");
	}
	$sectorIsOccupied =  !$sectorIsOccupied;
	$pos += (int) $char;
}


$curSegNum = count($segments) - 1;


for ($curSegNum = count($segments) - 1;  $curSegNum >= 0; $curSegNum--) {
	list($segLen, $segPos) = $segments[$curSegNum];
	$diskStr = implode("_", $diskMap);
	$freePosInStr = strpos($diskStr, implode("_", array_fill(0, $segLen, ".")));
	if ($freePosInStr === false) continue;
	$freePos = substr_count(substr($diskStr, 0, $freePosInStr), "_");
	if ($freePos === false || $freePos >= $segPos) continue;

	for ($i = 0; $i < $segLen; $i++) {
		$diskMap[$freePos + $i] = $curSegNum;
		$diskMap[$segPos +  $i] = ".";
	}		
}

$checksum = 0;

for ($i = 0; $i< count($diskMap); $i++) {
	if ($diskMap[$i] == ".") continue;
	$checksum += $i * (int) $diskMap[$i];
}

echo "Chekcsum:\t$checksum\n";

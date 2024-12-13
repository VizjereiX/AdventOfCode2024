<?php


$data = [];
$count = 0;

foreach (file("input.txt") as $num => $line) {
	$data[] = str_split(trim($line), 1);
}

$rows = count($data);
$cols = count($data[0]);

$word = ["X", "M", "A", "S"];



function isInBound($row, $col) {
	global $cols;
	global $rows;
	return $row >= 0 && $row < $rows && $col >= 0 && $col < $cols;
}

function matchTemplate($row, $col, $dtRow, $dtCol) {
	global $data;
	global $word;

	for ($i = 0; $i < count($word); $i++) {
		$r = $row + $dtRow * $i;
		$c = $col + $dtCol * $i;
		if (!isInBound($r, $c)) return false;	
		if ($data[$r][$c] != $word[$i]) return false;	
	}
	return true;
}

for ($row = 0; $row < $rows; $row++) {
	for ($col = 0; $col < $cols; $col++) {
		if ($data[$row][$col] != "X")	continue;
		for ($dtRow = -1; $dtRow <= 1; $dtRow++) {
			for ($dtCol = -1; $dtCol <= 1; $dtCol++) {
				if ($dtRow == 0 && $dtCol == 0 ) continue;
				if (matchTemplate($row, $col, $dtRow, $dtCol)) $count++;
			}
		}
	}
}

echo "$count\n";

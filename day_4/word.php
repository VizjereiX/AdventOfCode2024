<?php


$data = [];
$count = 0;

foreach (file("input.txt") as $num => $line) {
	$data[] = str_split(trim($line), 1);
}

$rows = count($data);
$cols = count($data[0]);

$templates = [
	[
		["M", -1, -1],
		["M", +1, -1],
		["S", -1, +1],
		["S", +1, +1]
	],
	[
		["M", -1, -1],
		["M", -1, +1],
		["S", +1, -1],
		["S", +1, +1]
	],
	[
		["M", +1, -1],
		["M", +1, +1],
		["S", -1, -1],
		["S", -1, +1]
	],
	[
		["M", -1, +1],
		["M", +1, +1],
		["S", -1, -1],
		["S", +1, -1]
	]
];


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

for ($row = 1; $row < $rows-1; $row++) {
	for ($col = 1; $col < $cols-1; $col++) {
		if ($data[$row][$col] != "A")	continue;
		foreach ($templates as $template) {
			$cnt = 1;
			// echo $data[$row-1][$col-1], "." , $data[$row-1][$col+1]
			foreach ($template as $t) {
				list($letter, $dtRow, $dtCol)  = $t;
				$r = $row + $dtRow;
				$c = $col + $dtCol;
				if ($data[$r][$c] != $letter) {
					$cnt = 0;
					break;
				}
			}
			$count += $cnt;
		}
	}
}

echo "$count\n";

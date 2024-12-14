<?php


$input_file = "map.txt";

if ($argc > 1) $input_file = "map-" . $argv[1] . ".txt";


$map = [];
$guard = [
	"row" => null,
	"col" => null,
	"dir" => null,
];

$directions = [
	"^" => [
		"dtRow" => -1,
		"dtCol" => 0,
		"next" => ">"
	],
	">" => [
		"dtRow" => 0,
		"dtCol" => 1,
		"next" => "v",
	],
	"v" => [
		"dtRow" => 1,
		"dtCol" => 0,
		"next" => "<",
	],
	"<" => [
		"dtRow" => 0,
		"dtCol" => -1,
		"next" => "^",
	]
];

$obstacles = 0;
$starting = [];

foreach (file($input_file) as $i => $line) {
	$row = str_split(trim($line));
	$map[] = $row;
	if (is_null($guard["row"])) {
		foreach ($directions as $d => $_) {
			$pos = strpos($line, $d);
			if ($pos !== false) {
				$starting["row"] = $i;
				$starting["col"] = $pos;
				$starting['dir'] = $d;
				break;
			}
		}
	}
}

$rows = count($map);
$cols = count($map[0]);

for ($i = 0; $i < $rows; $i++) {
	for ($j = 0; $j < $cols; $j++) {
		if ($map[$i][$j] != ".") {
			continue;
		}
		$map[$i][$j] = "#";
		$guard = $starting;
		$debug =  ($i == 6 && $j == 3) && false;

		$steps = $rows *$cols * 10;
		$loop = true;
		while($steps-- > 0 && $loop) {
			$row = $guard["row"] + $directions[$guard["dir"]]["dtRow"];
			$col = $guard["col"] + $directions[$guard["dir"]]["dtCol"];

			if ($debug) echo "\t$row\t$col\t";

			if ($row < 0 || $row >= $rows || $col < 0 || $col >= $cols) {
				$loop = false;
				continue;	
			}

			if ($map[$row][$col] == "#") {
				$guard["dir"] = $directions[$guard["dir"]]["next"];
				continue;
			}

			$guard["row"] = $row;
			$guard["col"] = $col;

		}
		if ($loop) $obstacles++;
		$map[$i][$j] = ".";
	}
}
var_dump($obstacles);


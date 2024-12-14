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

$visited = 0;

foreach (file($input_file) as $i => $line) {
	$row = str_split(trim($line));
	$map[] = $row;
	if (is_null($guard["row"])) {
		foreach ($directions as $d => $_) {
			$pos = strpos($line, $d);
			if ($pos !== false) {
				$guard["row"] = $i;
				$guard["col"] = $pos;
				$guard["dir"] = $d;
				break;
			}
		}
	}
}

$rows = count($map);
$cols = count($map[0]);


while(true) {
	$row = $guard["row"] + $directions[$guard["dir"]]["dtRow"];
	$col = $guard["col"] + $directions[$guard["dir"]]["dtCol"];

	if ($row < 0 || $row >= $rows || $col < 0 || $col >= $cols) {
		if ($map[$guard["row"]][$guard["col"]] != "X") {
			$map[$guard["row"]][$guard["col"]] = "X";
			$visited++;
		}
		break;	
	}

	if ($map[$row][$col] == "#") {
		$guard["dir"] = $directions[$guard["dir"]]["next"];
		continue;
	}

	if ($map[$guard["row"]][$guard["col"]] != "X") {
		$map[$guard["row"]][$guard["col"]] = "X";
		$visited++;
	}
	$guard["row"] = $row;
	$guard["col"] = $col;

}
echo "$visited\n" . count($possibleObstacles) . "\n";


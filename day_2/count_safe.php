<?php
function isChangeMonotonicAndSmall($levels) {
	if ($levels[0] > $levels[1]) {
		$grade = -1;
	} else if ($levels[0] < $levels[1]) {
		$grade =  1;
	} else {
		return false;
	}
	for ($i = 0; $i < count($levels) - 1; $i++) {
		$change = ($levels[$i + 1] - $levels[$i]) * $grade;
		if ($change < 1 or $change > 3) {
			return false;
		}	
	}
	return true;
}

function isChangeMonotonicAndSmallWithDumpener($levels) {
	// echo implode(" ", $levels), "\n";
	$list = array_slice($levels, 1);
	// echo "_ ", implode(" ", $list), "\n";
	if (isChangeMonotonicAndSmall($list)) return true;
	for ($i = 1; $i < count($levels); $i++) {
		$list = array_merge(
			array_slice($levels, 0, $i),
		//	["_"],
			array_slice($levels, $i + 1)
		);
		// echo implode(" ", $list), "\n";
		if (isChangeMonotonicAndSmall($list)) return true;
	}
	return false;
}

$cnt = 0;
foreach (file("reports.txt") as $line) {
	$levels = explode(" ", trim($line));
	if (isChangeMonotonicAndSmallWithDumpener($levels)) {
		$cnt++;
	}
}
echo $cnt, "\n";

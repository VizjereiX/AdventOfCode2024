<?php
$first = [];
$second = [];
$map = [];

foreach (file("locations.txt") as $line) {
	list($a, $b) = explode("   ", trim($line));
	$first[] = $a;
	$second[] = $b;
	if (!isset($map[$b])) $map[$b] = 0;
	$map[$b]++;
}
sort($first);
sort($second);

$total = 0;
$similarity = 0;

for ($i = 0; $i < count($first); $i++) {
	$total += abs($first[$i] - $second[$i]);
	if (isset( $map[$first[$i]]))
		$similarity += $first[$i] * $map[$first[$i]];
}

echo "Total distance: $total\n";
echo "Similarity: $similarity\n";

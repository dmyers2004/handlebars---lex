#!/usr/bin/env php
<?php
$repeat = 5000;

require __DIR__.'/vendor/autoload.php';

$data = include 'data.php';

$template = file_get_contents(__DIR__.'/templates/template.lex');

$durations = array();

for ($i=0; $i < $repeat; $i++) {
	$start_time = microtime(TRUE);

	$parser = new Lex\Parser();
	$parser->parse($template, $data, 'my_callback');

	$end_time = microtime(TRUE);

	$durations[] = $end_time - $start_time;
}

$opavg = (array_sum($durations) / $repeat);
$opavgtotal = 0;
$ops = 0;
$break = FALSE;

while (!$break) {
	$opavgtotal += $opavg;
	if ($opavgtotal >= 1) {
		$break = TRUE;
	} else {
		$ops++;
	}
}

echo __FILE__.PHP_EOL;
echo "Average Time: ".number_format(array_sum($durations) / $repeat, 6).'s'.PHP_EOL;
echo "Operations Per Second: ".$ops.PHP_EOL;

function my_callback($name, $attributes, $content) {
	switch($name) {
		case 'lex.lower':
			return strtolower($result);
		break;
	}
}
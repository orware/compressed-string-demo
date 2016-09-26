<?php
require dirname(__DIR__).'/vendor/autoload.php';
set_time_limit(0);
function timing($log)
{
	static $first = null;
	static $firstMessage = '';


	if (is_null($first))
	{
		$first = microtime(true);
		$firstMessage = $log;
	}
	else
	{
		$last = microtime(true);
		echo 'Elapsed time for (' . $firstMessage . ' to ' . $log . '): ' . ($last - $first) . ' seconds<br/>';
		$fh = fopen(dirname(__DIR__)."/logs/timing.log", "a");
		fwrite($fh, basename($_SERVER["SCRIPT_FILENAME"], '.php') . "\t" . ($last - $first) . "\n");
		fclose($fh);
		$first = null;
		$firstMessage = '';
	}
}

function memory_usage($log)
{
	$peak = memory_get_peak_usage(true);
	$current = memory_get_usage();
	echo $log . ': ' . formatBytes($peak) .' (peak)<br/>';
	echo $log . ': ' . formatBytes($current) .' (current)<br/>';

	$fh = fopen(dirname(__DIR__)."/logs/peak_memory.log", "a");
	fwrite($fh, basename($_SERVER["SCRIPT_FILENAME"], '.php') . "\t" . $peak . "\n");
	fclose($fh);

	$fh = fopen(dirname(__DIR__)."/logs/actual_memory.log", "a");
	fwrite($fh, basename($_SERVER["SCRIPT_FILENAME"], '.php') . "\t" . $current . "\n");
	fclose($fh);
}

function formatBytes($size, $precision = 4)
{
	$base = log($size, 1024);
	$suffixes = array('', 'K', 'M', 'G', 'T');

	return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}

$shakespeare_query = 'SELECT * FROM shakespeare';
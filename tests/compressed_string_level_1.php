<?php
require __DIR__.'/includes.php';
//memory_usage("Start");
timing('Start');

$db = new PDO("sqlite:".dirname(__DIR__)."/shakespeare.db");
//memory_usage("After create SQLite Connection");

$statement = $db->prepare($shakespeare_query);
$statement->execute();
//memory_usage("After prepare/execute SQL Query");

$json = new \Orware\Compressed\CompressedString(false, 1);

$json->write('[');

$rowNumber = 0;
while($row = $statement->fetchObject()) {
	if ($rowNumber > 0)
	{
		$json->write(',');
	}

	$json->write($row);
}
$json->write(']');
memory_usage("After fetch all data into JSON Gzip String");
timing('Finish');
//print_r($data);

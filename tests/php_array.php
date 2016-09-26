<?php
require __DIR__.'/includes.php';
//memory_usage("Start");
timing('Start');

$db = new PDO("sqlite:".dirname(__DIR__)."/shakespeare.db");
//memory_usage("After create SQLite Connection");

$statement = $db->prepare($shakespeare_query);
$statement->execute();
//memory_usage("After prepare/execute SQL Query");

$data = $statement->fetchAll();
memory_usage("After fetch all data into PHP Array");
timing('Finish');
//print_r($data);

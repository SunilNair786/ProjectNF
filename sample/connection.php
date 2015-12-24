<?php

//include("../lib/mongoClient.class.php");

// connect
$m = new MongoClient("mongodb://localhost:27017");

// select a database
$db = $m->comedy;

// select a collection (analogous to a relational database's table)
$collection = $db->cartoons;

//echo "dsjhg"; exit;

// add a record
// $document = array( "title" => "Calvin and Hobbes", "author" => "Bill Watterson" );
// $collection->insert($document);

// add another record, with a different "shape"
// $document = array( "title" => "qewrtyedsfa", "online" => true );
// $collection->insert($document);

//$collection->update(array("title"=>"firstName"), array('$set'=>array("_id"=>'5671b3cc66a195040900002c')));

// find everything in the collection
$cursor = $collection->find();

// iterate through the results
foreach ($cursor as $document) {
    echo @$document["title"] . "\n";
}

?>
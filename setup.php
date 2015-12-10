<?php

require 'vendor/autoload.php';

use Aws\Rds\RdsClient;
$client = RdsClient::factory(array(
'version' => 'latest',
'region'  => 'us-east-1'
));


$result = $client->describeDBInstances(array(
    'DBInstanceIdentifier' => 'ctian-db',
));


$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
print "=====================\n". $endpoint . "============\n"; 

$endpoint= "";
foreach ($result["DBInstances"] as $dbinstances){
$dbinstanceidentifier = $ $dbinstances["DBInstanceIdentifier"];
if ($dbinstanceidentifier == "ctian-db"){
$endpoint = $dbinstances["Endpoint"]["Address"];
}
}



echo "begin database";
$link = mysqli_connect($endpoint,"controller","letmein88") or die("Error " . mysqli_error($link));
$db = "CREATE SCHEMA `ctiandb`;";
$link->query($db);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$delete_table = 'DELETE TABLE items';
$del_tbl = $link->query($delete_table);

$create_table = 'CREATE TABLE items  
(
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(200) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    s3rawurl VARCHAR(255) NOT NULL,
    filename VARCHAR(255) NOT NULL,
    s3finishedurl VARCHAR(255) NOT NULL,
    status INT NOT NULL,
    issubscribed INT
)';



$create_tbl = $link->query($create_table);
if ($create_table) {
	echo "Table is created or No error returned.";
}
else {
        echo "error!!";  
}
$link->close();
?>

<h1>File Upload</h1>
<form action="index.php">
<input type="submit" value="Submit">
</form>

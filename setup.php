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



echo "begin database";
$link = mysqli_connect($endpoint,"controller","letmein88","ctiandb") or die("Error " . mysqli_error($link));


if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$create_table = 'CREATE TABLE IF NOT EXISTS items  
(
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(200) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    s3rawurl VARCHAR(255) NOT NULL,
    filename VARCHAR(255) NOT NULL,
    s3finishedurl VARCHAR(255) NOT NULL,
    status INT NOT NULL,
    issubscribed INT,
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
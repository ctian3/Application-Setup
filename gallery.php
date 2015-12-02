<html>

<head><title>Gallery</title>

</head>

<body>


<?php
session_start();
$email = $_POST["email"];
echo $email;
require 'vendor/autoload.php';
use Aws\Rds\RdsClient;
$client = RdsClient::factory(array(
'version' =>'latest',
'region'  => 'us-east-1'
));


$result = $client->describeDBInstances(array(
    'DBInstanceIdentifier' => 'ctian-db',
));
$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
print "============\n". $endpoint . "================\n";


echo "begin database";

$link = mysqli_connect($endpoint,"controller","letmein88","ctiandb") or die("Error " . mysqli_error($link));

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//below line is unsafe - $email is not checked for SQL injection -- don't do this in real life or use an ORM instead
$link->real_query("SELECT * FROM items WHERE email = '$email'");


$res = $link->use_result();
echo "Result set order...\n";

while ($row = $res->fetch_assoc()) {

    echo "<img src =\" " . $row['s3rawurl'] . "\" /><img src =\"" .$row['s3finishedurl'] . "\"/>";
echo $row['id'] . "Email: " . $row['email'];
}
$link->close();
?>

</body>

</html>
<?php
//start the session
session_start();
//echo $_FILES;
echo $_POST['useremail'];
echo $_POST['phone'];
$uploaddir='/tmp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
echo '<pre>';
if(move_uploaded_file($_FILES['userfile']['tmp_name'],$uploadfile)){
        echo "File is calid, and was successfully uploaded.\n";
}else{
        echo "Possible file upload attack!\n";
}
echo 'Here is some more debugging info:';
print_r($_FILES);
print "</pre>";
require 'vendor/autoload.php';
use Aws\S3\S3Client;
$client = S3Client::factory(array(
'version' =>'latest',
'region'  => 'us-east-1'
));
$bucket = uniqid("php-ctian-",false);
$result = $client->createBucket(array(
        'Bucket'=> $bucket
));
$client->waitUntil('BucketExists', array('Bucket' => $bucket));
//$client->waitUntilBucketExists(array('Bucket' => $bucket));
$key = $uploadfile;
$result = $client->putObject(array(
        'ACL'=>'public-read',
        'Bucket'=>$bucket,
        'Key' =>$key,
        'SourceFile'=>$uploadfile
));
$url = $result['ObjectURL'];
echo $url;
use Aws\Rds\RdsClient;
$client = RdsClient::factory(array(
'version' =>'latest',
'region' => 'us-east-1'
));
//$result = $client->describeDBInstances(array(
//      'DBInstanceIdentifier'=>'itmo544-ght-db',
//));
//$endpoint = "";
//foreach ($result->getPath('DBInstances/*/Endpoint/Address')as $ep){
        //do something with the meessage
//      echo "==========". $ep ."========";
//      $endpoint = $ep;
//}
        //echo "begin database";
//$link = mysqli_connect($endpoint,"guhaotian","909690ght","guhaotiandb") or die("Error " . mysqli_error($link));
$link = mysqli_connect("ctian-db.cpgbrg85ofge.us-east-1.rds.amazonaws.com","controller","letmein88","ctiandb") or die("Error " . mysqli_error($link));
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
//check connection
//if (mysqli_connect_error()){
//      printf("Connect failed: %s\n",mysqli_connect_error());
//      exit();0
//}
//prepared statement, stage1:prepare
if (!($stmt = $link->prepare("INSERT INTO items (id, email,phone,filename,s3rawurl,s3finishedurl,status,issubscribed) VALUES (NULL,?,?,?,?,?,?,?)"))) {
    echo "Prepare failed: (" . $link->errno . ") " . $link->error;
}
$email = $_POST['useremail'];
$phone = $_POST['phone'];
$s3rawurl = $result['ObjectURL'];//;from above
$filename = basename($_FILES['userfile']['name']);
$s3finishedurl = "none";
$status=0;
$issubscribed=0;
$stmt->bind_param("sssssii",$email,$phone,$filename,$s3rawurl,$s3finishedurl,$status,$issubscribed);
if(!$stmt->execute()){
        echo "Execute failed:(" . $stmt->errno . ")" . $stmt->error;
}
printf("%d Row inserted.\n", $stmt->affected_rows);
$stmt->close();
$link->real_query("SELECT * FROM items");
$res = $link->use_result();
echo "Result set order...\n";
while ($row = $res->fetch_assoc()){
        echo $row['id'] . " " .$row['email']. " " .$row['phone'];
}
$link->close();
?>




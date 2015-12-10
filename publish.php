<?php

session_start();

require 'vendor/autoload.php';
use Aws\Sns\SnsClient;

$client = SnsClient::factory(array(
        'version' =>'latest',
        'region'  => 'us-east-1'
            ));

$result = $client->publish([
    'Message' => 'Image Uploaded',
    'TopicArn' => 'arn:aws:sns:us-east-1:343582342076:mp2'
]);

echo 'success';
?>

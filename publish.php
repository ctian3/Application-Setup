<?php session_start(); ?>

require 'vendor/autoload.php';

$result = $client->publish([
    'Message' => '<Upload Success>', // REQUIRED
    'MessageAttributes' => [
        '<String>' => [
            //'BinaryValue' => <Psr\Http\Message\StreamableInterface>,
            'DataType' => '<string>', // REQUIRED
            //'StringValue' => '<string>',
        ],
        // ...
    ],
    //'MessageStructure' => '<string>',
    //'Subject' => '<string>',
    //'TargetArn' => '<string>',
    'TopicArn' => '<arn:aws:sns:us-east-1:343582342076:mp2>',

]);

echo "Success";
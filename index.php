<?php
include 'creds.php';

// The data to send to the API
$postData = array(
    'kind' => 'blogger#post',
    'blog' => array('id' => $blogID),
    'title' => 'A new post',
    'content' => 'With <b>exciting</b> content...'
);

// Setup cURL
$ch = curl_init('https://jumla.cic.co.ke/api/Auth/Login');
curl_setopt_array($ch, array(
    CURLOPT_POST => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
    CURLOPT_POSTFIELDS => json_encode($credsData)
));

// Send the request
$response = curl_exec($ch);

// Check for errors
if($response === FALSE){
    die(curl_error($ch));
}

// Decode the response
$responseData = json_decode($response, TRUE);

// Close the cURL handler
curl_close($ch);

// Print the date from the response
echo $responseData['published'];

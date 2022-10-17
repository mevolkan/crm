<?php
// Your ID and token
$blogID = '8070105920543249955';
$authToken = 'OAuth 2.0 token here';

// The data to send to the API
$postData = array(
    'kind' => 'blogger#post',
    'blog' => array('id' => $blogID),
    'title' => 'A new post',
    'content' => 'With <b>exciting</b> content...'
);

// Setup cURL
$ch = curl_init('https://www.googleapis.com/blogger/v3/blogs/'.$blogID.'/posts/');
curl_setopt_array($ch, array(
    CURLOPT_POST => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HTTPHEADER => array(
        'Authorization: '.$authToken,
        'Content-Type: application/json'
    ),
    CURLOPT_POSTFIELDS => json_encode($postData)
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

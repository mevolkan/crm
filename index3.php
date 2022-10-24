<?php
include 'creds.php';

// The data to send to the API
$postData = array(
    'ClientType' => '1',
    'CaseOrigin' => '3',
    'CaseType' => '1',
    'ComplaintType' => '1',
    'FirstName' => 'John',
    'Surname' => 'Doe',
    'PhoneNumber' => '254712365478',
    'EmailAddress' => 'john.doe@example.co.ke',
    'Description' => 'Customer complaint sent from the website',
    'RecommendedActions' => 'do better',
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

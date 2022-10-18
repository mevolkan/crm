<?php
include 'creds.php';

    // The data to send to the API
;

// Create the context for the request
$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => json_encode($credsData)
    )
));

// Send the request
$response = file_get_contents('https://jumla.cic.co.ke/api/Auth/Login', FALSE, $context);

// Check for errors
if ($response === FALSE) {
    die('Error');
}

// Decode the response
$responseData = json_decode($response, TRUE);

// Print the date from the response
echo $responseData['status'];
echo $responseData['message'];
echo $responseData['value']['accesstoken'];
$accesstoken = $responseData['value']['accesstoken'];

//get complaint types

function getComplaintTypes($accesstoken)
{
    // Create the context for the request
    $context = stream_context_create(array(
        'http' => array(
            'method' => 'GET',
            'header' => "access-token: {$accesstoken}\r\n"
        )
    ));

    // Send the request
    $response = file_get_contents('https://jumla.cic.co.ke/api/complaintTypes/GetComplaintTypes', FALSE, $context);

    // Check for errors
    if ($response === FALSE) {
        die('Error');
    }

    // Decode the response
    $responseData = json_decode($response, TRUE);
    echo $responseData['statusCode'];
    echo $responseData['statusReason'];
}


function createCase($accesstoken)
{
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

    $context = stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => "access-token: {$accesstoken}\r\n" .
                "Content-Type: application/json\r\n".
                "Accept: application/json\r\n",
            'content' => json_encode($postData)
        )
    ));

    // Send the request
    $response = file_get_contents('https://jumla.cic.co.ke/api/cases/CreateCase', FALSE, $context);

    // Check for errors
    if ($response === FALSE) {
        die('Error');
    }

    // Decode the response
    $responseData = json_decode($response, TRUE);
    echo $responseData['statusCode'];
    echo $responseData['statusReason'];
    var_dump($responseData);
}

getComplaintTypes($accesstoken);
createCase($accesstoken);

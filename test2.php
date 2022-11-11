<?php
include 'creds.php';

$url = "https://jumla.cic.co.ke/api/Auth/Login";
$ch = curl_init();
$certificate_location = "/certificate/cacert.pem";
curl_setopt ($ch, CURLOPT_URL, $url);

curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, $certificate_location);
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, $certificate_location);
// curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, TRUE);

curl_setopt ($ch, CURLOPT_POST, 1);                //0 for a get request
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt ($ch, CURLOPT_POSTFIELDS, $credsData );
curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
$contents = curl_exec($ch);
if (curl_errno($ch)) {
  echo curl_error($ch);
  echo "\n<br />";
  $contents = '';
} else {
  curl_close($ch);
}

if (!is_string($contents) || !strlen($contents)) {
echo "Failed to get contents.";
$contents = '';
}

echo $contents;

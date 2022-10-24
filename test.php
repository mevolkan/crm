<!DOCTYPE html>
<html>
<?php
// define variables and set to empty values
$surNameErr = $firstNameErr = $emailErr = $phoneErr = $complaintTypeErr = $recommendationErr = "";
$complaintType = $firstName = $surName = $phone = $email =  $description = $recommendation = "";
include 'creds.php';

?>

<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Case Type :
        <input type="radio" name="complaintType" <?php if (isset($complaintType) && $complaintType == "1") echo "checked"; ?> value="1">Service Related
        <input type="radio" name="complaintType" <?php if (isset($complaintType) && $complaintType == "2") echo "checked"; ?> value="2">Product Related
        <input type="radio" name="complaintType" <?php if (isset($complaintType) && $complaintType == "3") echo "checked"; ?> value="3">Advise
        <span class="error">* <?php echo $complaintTypeErr; ?></span>
        <br><br>
        First Name: <input type="text" name="firstName" value="<?php echo $firstName; ?>">
        <span class="error">* <?php echo $firstNameErr; ?></span>
        <br>
        Surname: <input type="text" name="surName" value="<?php echo $surName; ?>">

        <span class="error">* <?php echo $surNameErr; ?></span>
        <br><br>
        Phone: <input type="tel" name="phone" value="<?php echo $phone; ?>">
        <span class="error">* <?php echo $phoneErr; ?></span>
        <br><br>
        E-mail: <input type="text" name="email" value="<?php echo $email; ?>">
        <span class="error">* <?php echo $emailErr; ?></span>
        <br><br>
        Recommendation: <input type="text" name="recommendation" value="<?php echo $recommendation; ?>">
        <span class="error"><?php echo $recommendationErr; ?></span>
        <br><br>
        Description: <textarea name="description" rows="5" cols="40"><?php echo $description; ?></textarea>
        <br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["firstName"])) {
            $nameErr = "First Name is required";
        } else {
            $firstName = test_input($_POST["firstName"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $firstName)) {
                $nameErr = "Only letters and white space allowed";
            }
        }

        if (empty($_POST["surName"])) {
            $surNameErr = "Surname is required";
        } else {
            $surName = test_input($_POST["surName"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $surName)) {
                $surNameErr = "Only letters and white space allowed";
            }
        }

        if (empty($_POST["phone"])) {
            $phoneErr = "Phone is required";
        } else {
            $phone = test_input($_POST["phone"]);
            // check if e-mail address is well-formed
            if (!filter_var($phone, FILTER_SANITIZE_NUMBER_INT)) {
                $phoneErr = "Invalid phone format";
            }
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        if (empty($_POST["recommendation"])) {
            $recommendation = "";
        } else {
            $recommendation = test_input($_POST["recommendation"]);
        }

        if (empty($_POST["description"])) {
            $description = "Description is required";
        } else {
            $description = test_input($_POST["description"]);
        }

        if (empty($_POST["complaintType"])) {
            $complaintTypeErr = "complaintType is required";
        } else {
            $complaintType = test_input($_POST["complaintType"]);
        }
    }

    function test_input($accesstoken, $data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        echo $data;
        return $data;
        login();
        createCase($accesstoken, $data);
    }

    //login to api
    function login()
    {
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
        // echo $responseData['status'];
        // echo $responseData['message'];
        // echo $responseData['value']['accesstoken'];
        $accesstoken = $responseData['value']['accesstoken'];
        return $accesstoken;
    }

    //create case 
    function createCase($accesstoken, $data)
    {

        $postData = array(
            'ClientType' => '1',
            'CaseOrigin' => '3',
            'CaseType' => '1',
            'ComplaintType' => $data[0],
            'FirstName' => $data[1],
            'Surname' => $data[2],
            'PhoneNumber' => $data[3],
            'EmailAddress' => $data[4],
            'Description' => $data[5],
            'RecommendedActions' => $data[6],
        );

        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "access-token: {$accesstoken}\r\n" .
                    "Content-Type: application/json\r\n" .
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
        return $responseData['statusReason'];
    }
    ?>

</body>

</html>
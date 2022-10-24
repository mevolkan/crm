
  <?php
  // define variables and set to empty values
  $surNameErr = $firstNameErr = $emailErr = $phoneErr = $caseTypeErr = $recommendationErr = "";
  $firstName = $surName = $phone = $email = $caseType = $description = $recommendation = "";

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

    if (empty($_POST["caseType"])) {
      $caseTypeErr = "caseType is required";
    } else {
      $caseType = test_input($_POST["caseType"]);
    }
  }

  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  Case Type :
    <input type="radio" name="caseType" <?php if (isset($caseType) && $caseType == "1") echo "checked"; ?> value="1">Service Related
    <input type="radio" name="caseType" <?php if (isset($caseType) && $caseType == "2") echo "checked"; ?> value="2">Product Related
    <input type="radio" name="caseType" <?php if (isset($caseType) && $caseType == "3") echo "checked"; ?> value="3">Advise
    <span class="error">* <?php echo $caseTypeErr; ?></span>
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

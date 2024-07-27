<?php 
// define variables and set to empty values
$array = array("username" => "", "email" => "", "phone" => "", "subject" => "", "car" => "", "content" => "", "usernameErr" => "", "emailErr" => "", "phoneErr" => "", "subjectErr" => "", "carErr" => "", "contentErr" => "", "isSuccess" => false);

$to = "valpedro59@gmail.com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $array["isSuccess"]= true;
    if (empty($_POST["username"])) {
      $array["username"] = "Name is required";
      $array["isSuccess"]= false;
    }
    else {
      $array["username"] = test_input($_POST["username"]);
         // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$array["username"])) {
      $array["usenameErr"] = "Only letters and white space allowed";
      $array["isSuccess"]= false;
      }
    }
    if (empty($_POST["email"])) {
      $array["emailErr"] = "Email is required";
      $array["isSuccess"]= false;
    }
    else {
      $array["email"] = test_input($_POST["email"]);
        // check if e-mail address is well-formed
    if (!filter_var($array["email"], FILTER_VALIDATE_EMAIL)) {
      $array["emailErr"] = "Invalid email format";
      $array["isSuccess"]= false;
      }
    }
    if (empty($_POST["phone"])) {
      $array["phoneErr"] = "Phone is required";
      $array["isSuccess"]= false;
    }
    else {
      $array["phone"] = test_input($_POST["phone"]);
        // check if phone address is well-formed
    if (!preg_match("/[0-9]{9}/",$array["phone"])) {
      $array["phoneErr"] = "Invalid phone format";
      $array["isSuccess"]= false;
      }
    }
    if (empty($_POST["subject"])) {
      $array["subjectErr"] = "Subject is required";
      $array["isSuccess"]= false;
    }
    else {
      $array["subject"] = test_input($_POST["subject"]);
    }
    if (empty($_POST["car"])) {
      $array["carErr"] = "Car is required";
      $array["isSuccess"]= false;
    }
    else {
      $array["car"] = test_input($_POST["car"]);
    }
    if (empty($_POST["content"])) {
      $array["contentErr"] = "Message is required";
      $array["isSuccess"]= false;
    }
    else {
      $array["content"] = test_input($_POST["content"]);
    }
    $emailText = "
    Name: {$array["username"]}\n
    Email: {$array["email"]}\n
    Phone: {$array["phone"]}\n
    Content: {$array["content"]}\n";
    $isSuccess= true;
    if ($isSuccess) {
      // envoie mail
      $headers = "From: {$array["username"]} <{$array["email"]}>\r\nReply-To: {$array["email"]}";
      mail($to, $subject, $emailText, $headers);
    }

    echo json_encode($array);
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>


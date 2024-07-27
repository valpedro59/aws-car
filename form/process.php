<?php 
// define variables and set to empty values
$array = array("username" => "", "email" => "", "phone" => "", "subject" => "", "car" => "", "content" => "", "usernameError" => "", "emailError" => "", "phoneError" => "", "subjectError" => "", "carError" => "", "contentError" => "", "isSuccess" => false);
$emailTo = "valpedro59@gmail.com";
// $username = $email = $phone = $subject = $car = $content = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailText = "";
    $array["isSuccess"] = true; 
    if (empty($_POST["username"])) {
        $array["usernameError"] = "Name is required";
        $array["isSuccess"] = false;
    }
    else {
        $array["username"] = test_input($_POST["username"]);
         // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$array["username"])) {
        $array["usernameError"] = "Only letters and white space allowed";
        $array["isSuccess"] = false;
      }
      $emailText .= "Username: {$array['username']}\n";
    }
    if (empty($_POST["email"])) {
        $array["emailError"] = "Email is required";
        $array["isSuccess"] = false;
    }
    else {
        $array["email"] = test_input($_POST["email"]);
        // check if e-mail address is well-formed
    if (!filter_var($array["email"], FILTER_VALIDATE_EMAIL)) {
        $array["emailError"] = "Invalid email format";
        $array["isSuccess"] = false;
      }
      $emailText .= "Email: {$array['email']}\n";
    }
    if (empty($_POST["phone"])) {
        $array["phoneError"] = "Phone is required";
        $array["isSuccess"] = false;
    }
    else {
        $array["phone"] = test_input($_POST["phone"]);
        // check if phone address is well-formed
    if (!preg_match("/^[0-9 ]*$/",$array["phone"])) {
        $array["phoneError"] = "Invalid phone format";
        $array["isSuccess"] = false;
      }
      $emailText .= "Phone: {$array['phone']}\n";
    }
    if (empty($_POST["subject"])) {
        $array["subjectError"] = "Subject is required";
        $array["isSuccess"] = false;
    }
    else {
        $array["subject"] = test_input($_POST["subject"]);
        $emailText .= "Subject: {$array['subject']}\n";
    }
    if (empty($_POST["car"])) {
        $array["carError"] = "Car is required";
        $array["isSuccess"] = false;
    }
    else {
        $array["car"] = test_input($_POST["car"]);
        $emailText .= "Car: {$array['car']}\n";
    }
    if (empty($_POST["content"])) {
        $array["contentError"] = "Message is required";
        $array["isSuccess"] = false;
    }
    else {
        $array["content"] = test_input($_POST["content"]);
        $emailText .= "Content: {$array['content']}\n";
    }

    if($array["isSuccess"]) 
        {
            $headers = "From: {$array['username']} <{$array['email']}>\r\nReply-To: {$array['email']}";
            mail($emailTo, "Un message de votre site", $emailText, $headers);
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
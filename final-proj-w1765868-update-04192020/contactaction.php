<?php
$title = $heading = "Thanks for contacting us!";
include('header.php');

//basic validation
if(isset($_POST['contactemail']))
{
    $error = array();

    if($_POST['contactfname'] != "")
    {
        $contactfname = $_POST['contactfname'];
        $data['contactfname'] = $contactfname;
    }
    else
    {
        $error[] = "You must enter a first name";
    }

    if($_POST['contactlname'] != "")
    {
        $contactlname = $_POST['contactlname'];
        $data['contactlname'] = $contactlname;
    }
    else
    {
        $error[] = "You must enter a last name";
    }

    if($_POST['contactemail'] != "")
    {
        $contactemail = $_POST['contactemail'];
        $email_regex = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

        if(!preg_match($email_regex,$contactemail)) {
            $error[] = 'You must enter a VALID email address.';
            $contactemail = "";  // reset invalid email addy
        }
    }
    else
    {
        $error[] = "You must enter an email address.";
    }

    if($_POST['contactphone'] != "")
    {
        $contactphone = $_POST['contactphone'];
        $data['contactphone'] = $contactphone;
    }
    else
    {
        $error[] = "You must enter a contact #.";
    }

    if($_POST['contactsubject'] != "")
    {
        $contactsubject = $_POST['contactsubject'];
        $data['contactsubject'] = $contactsubject;
    }
    else
    {
        $error[] = "Please enter a message to discuss.";
    }
}

if(empty($error))
{
    require_once "Mail.php";
    $from = $contactemail;
    $to = 'w1765868@apps.losrios.edu';
    $host = "ssl://smtp.gmail.com";
    $port = "465";
    $username = 'testdshort@gmail.com';
    $password = 'Cisc01234!';
    $subject = "Concert Series Inquiry";

    $body = "====================== message =======================\r\n\r\n" .
            $contactsubject . "\r\n\r\n" . 
            "======================= contact =========================\r\n\r\n" .
            "Name: " . $contactfname . " " . $contactlname . "\r\n" .
            "Email: " . $contactemail . "\r\n" . 
            "Contact #: " . $contactphone . "\r\n";

    $headers = array ('From' => $from, 'To' => $to,'Subject' => $subject);
    $smtp = Mail::factory('smtp',
    array ('host' => $host,
            'port' => $port,
            'auth' => true,
            'username' => $username,
            'password' => $password));
    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
        echo($mail->getMessage());
    } else {
        echo "<div class=\"container\">\n";
        echo "<div class=\"heading\">\n";
        echo "<p>Message Sent Successfully</p>\n";
        echo "<p>( Please allow 24-72 hours for a response. Thank you! )</p>";
        echo "</div>\n";
        echo "</div>\n";
    }
}
elseif(isset($data) && isset($error))
{
    $get_string = "";
    foreach ($data as $k => $v)
    {
        if($data[$k] != "")
        {
          $get_string .= $k . '=' . urlencode($v). '&';
        }
    }
    
    echo "<div class=\"container\">\n";
    echo "<div class=\"centeredcontainer\">\n";
    echo "<div class=\"leftaligned\">\n";
    echo "<ul type=\"disc\">\n";
    foreach($error as $e)
    {
        echo '<li class="err">' . $e . '</li>' . "\n";
    }
    echo "</ul>\n";
    echo "</div>\n";
    echo "<button type=\"button\" class=\"returntocontact\" onclick=\"location.href='contact.php?";
    echo $get_string . "'\">Return To Contact Form</button>\n";
    echo "</div>\n";
    echo "</div>\n";

}
elseif(isset($error))
{
    echo "<div class=\"container\">\n";
    echo "<div class=\"centeredcontainer\">\n";
    echo "<div class=\"errorslist\">\n";
    echo "<ul>\n";
    foreach($error as $e)
    {
        echo '<li class="errwhite">' . $e . '</li>' . "\n";
    }
    echo "</ul>\n";
    echo "</div>\n"; // errorslist div
    echo "<button type=\"button\" class=\"returntocontact\" onclick=\"location.href='contact.php'\">Return To Contact Form</button>\n";
    echo "</div>\n";
    echo "</div>\n";
}

include("footer.php");
?>
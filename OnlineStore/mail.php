<?php
if(isset($_POST["send_message_btn"])){
 $name=$_POST["nume"];
 $email=$_POST["email"];
 $message=$_POST["message"];

 $email_from = $email;
 $email_subject = "Client message";
 $email_body = "User Name:"  .$name.",".
 				"User Email:". $email.",".
 				"User Message:". $message.".";

 $to= "andrei_razy16@yahoo.com";
 $headers = "From: $email_from \r\n";
 $headers .= "Reply to: $email \r\n";
 mail($to,$email_subject, $email_body, $headers);
 header("Location: contact.php");
}
else{
	echo "Oops. Something went wrong! Please try again later..";
}
?>
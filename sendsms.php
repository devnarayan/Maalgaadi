
<!doctype html>
<html lang="en">
<head>
  
</head>
<body>

 <?php
// Authorisation details
$uname = "kumud.vishwakarma@ebabu.co";
$pword = "7879314920@Ku";

// Configuration variables
$info = "1";
$test = "0";

// Data for text message
$from = "Jims Autos";
$selectednums = "07828280789";
$message = "Test with an ampersand (&) and a £5 note";
$message = urlencode($message);

// Prepare data for POST request
$data = "uname=".$uname."&pword=".$pword."&message=".$message."&from=". $from."&selectednums=".$selectednums."&info=".$info."&test=".$test; 

// Send the POST request with cURL
$ch = curl_init('http://www.txtlocal.com/sendsmspost.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
echo $result = curl_exec($ch); //This is the result from Textlocal
curl_close($ch);
?>

</body>
</html>
<?php //newTest/newTestLi/includes

function sendsms($mobileno,$message,$senderid,$unicode=0) {
    //Your authentication key
    $authKey = "85262ARwrcvP1i7555eec59";

//Multiple mobiles numbers separated by comma
    $mobileNumber = $mobileno;

//Sender ID,While using route4 sender id should be 6 characters long.
    $senderId = 'MLGADI';

//Your message to send, Add URL encoding here.
    $message = urlencode($message);

//Define route 
    $route = "4";
//Prepare you post parameters
    $postData = array(
        'authkey' => $authKey,
        'mobiles' => $mobileNumber,
        'message' => $message,
        'sender' => $senderId,
        'route' => $route,
        'unicode'=>$unicode
    );

//API URL
    $url = "http://vtermination.com/sendhttp.php";

// init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
    ));


//Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//get response
    $output = curl_exec($ch);

//Print error if any
    if (curl_errno($ch)) {
        echo 'error:' . curl_error($ch);
    }

    curl_close($ch);

   
}
function login($table, $username, $password) {
    session_start();
    global $objConnect;
    $query = "select * from `$table` where `username` like '$username'";
    $result = $objConnect->execute($query);
    $num = $objConnect->total_rows();
    if ($num) {
        $row = $objConnect->fetch_assoc();
        if ($password == $row['password']) {
            if ("adminusers" == $table) {

                $_SESSION['admin_username'] = $row['username'];
                $_SESSION['admin_user_id'] = $row['id'];
                $_SESSION['admin_user_name'] = $row['name'];
                $_SESSION['admin_start'] = date("y-m-d H:i:s");
                $_SESSION['admin_email'] = $row['email'];
            }
            echo "success";
        } else {
            echo "Username and Password do not match";
        }
    } else {
        echo "User not registered";
    }
}

function strip_slashes_value($value) {
    $value = stripslashes(str_replace("''", "'", trim($value)));
    return $value;
}

function logout($type) {
    if ($type == "admin") {
       
        unset($_SESSION['executive_name']);
        unset($_SESSION['executive_id']);
        unset($_SESSION['executive_email']);
        
       RedirectURL(BASE_PATH . "login.php");
    }
}

function verifyLogin() {

    
        if ((!isset($_SESSION['executive_position'])) || (empty($_SESSION['executive_position'])) ||(!isset($_SESSION['executive_name'])) || (empty($_SESSION['executive_name'])) || (!isset($_SESSION['executive_email'])) || (empty($_SESSION['executive_email'])) || (!isset($_SESSION['executive_id'])) || (!isset($_SESSION['executive_id']))) {
            logout("admin");
        }
    
}

function RedirectURL($url) {
    //header("location:".$url);
    ?>

    <script>window.location = "<?= $url ?>";</script>

    <?php
    exit;
}

function changeFormat($from, $to, $date) {
    if (!empty($date)) {
       
         $mediate = date_create_from_format($from, $date);
        return date_format($mediate, $to);
    }
}
function fill_combo($id,$qry,$attr,$plsval="")

{

	echo "<select id='$id' class='form-control'  name='$id' $attr>";

	

	if($plsval!=""){

		echo "<option value=''>".$plsval."</option>";

	}

	

	$result=mysql_query($qry) or die("Error ".$qry);

	while($datarow=mysql_fetch_array($result))

	{

	echo "<option value='".$datarow[0]."'>".$datarow[1]."</option>";

	}

	echo "</select>";

}
function fill_multiple_combo($id,$name,$qry,$attr,$plsval="")

{

	echo "<select id='$id' class='formSelect form-control'  name='$name' $attr>";

	

	if($plsval!=""){

		echo "<option value=''>".$plsval."</option>";

	}

	

	$result=mysql_query($qry) or die("Error ".$qry);

	while($datarow=mysql_fetch_array($result))

	{

	echo "<option value='".$datarow[0]."'>".$datarow[1]."</option>";

	}

	echo "</select>";

}
function uploadFile($name,$variable){
  
$target_dir = "../uploads/";
$target_file = $target_dir . basename($variable[$name]["name"]);
$file_name=$variable[$name]["name"];
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if((isset($variable[$name]))) {
    $check = getimagesize($variable[$name]["tmp_name"]);
    if($check !== false) {
       
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $file_name=chr(rand(65, 90)).chr(rand(65, 90)).chr(rand(65, 90)).time().chr(rand(97, 122)).chr(rand(97, 122)).".".$imageFileType;
    $target_file=$target_dir.$file_name;
}
// Check file size
if ($variable[$name]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    return FALSE;
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($variable[$name]["tmp_name"], $target_file)) {
       return $file_name;
    } else {
        return false;
    }
}

}
 function getAddress($lat, $lon){
     $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=". $lat.",".$lon."&sensor=false";
     $json = @file_get_contents($url); 
     $data = json_decode($json); 
     $status = $data->status; 
     $address = ''; 
     if($status == "OK"){
         $address = $data->results[0]->formatted_address; 
         
     } return $address; 
     
     }
?>
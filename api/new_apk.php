<?php
include '../includes/define.php';
include_once './GCM.php';


$res=mysql_query("SELECT * FROM `vehicle` WHERE `id`='98'");
$result=mysql_fetch_assoc($res);


		echo$registatoin_ids=$result['device_token'];

	//$result1 = $gcm->send_notification($registatoin_ids,$message);	

		//$deviceToken=$fpres['device_token'];
							  	
							  		//define( 'API_ACCESS_KEY', 'AIzaSyD3cnhflaOsxUOoD669sJxza469XksubnI' );
										 
							  	define( 'API_ACCESS_KEY', 'AIzaSyBuvGtfMHvojG92WTc77m73KY50hHf6lzQ' );

										// $deviceToken='APA91bGRMUh6fE_8oHHzcmzG_qu5BLymKDwYXWV4_opmS-1Y4epXV763yGdmSPj-WvNippLhPQXHK9C-5k3zRMlgyqTmFMMIIBkNotlPwfuALktdo3jqhcAWc2pZ687wVJH1zZhxIU3VBuvVhaA7bvbNpFXhHNVzJw';
										 
										$registrationIds = array($registatoin_ids);
										/*$message='Alert notification';
										 $message = array("title" => $title,"details"=>$details, "city" =>$city, "address" =>$address,"lat" =>$lat,"long" =>$long);
										*/
										//$message = array("update" =>'update_available');
										$fields = array
										(
											'registration_ids' => $registrationIds,
											'data' => array( "update" => 'update_available' ),
											
										);
										 
										$headers = array
										(
											'Authorization: key=' . API_ACCESS_KEY,
											'Content-Type: application/json'
										);
										 
										$ch = curl_init();
										curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
										curl_setopt( $ch,CURLOPT_POST, true );
										curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
										curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
										curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
										curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
										echo$result = curl_exec($ch);
										curl_close( $ch );
	



?>


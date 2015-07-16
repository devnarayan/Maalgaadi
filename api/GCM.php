<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GCM
 *
 * @author Ravi Tamada
 */
class GCM {

    //put your code here
    // constructor
    function __construct() {

       // define( 'ACCESS_API_KEY', 'AIzaSyD3cnhflaOsxUOoD669sJxza469XksubnI' );
    }
    //define( 'ACCESS_API_KEY', 'AIzaSyD3cnhflaOsxUOoD669sJxza469XksubnI' );
    /**
     * Sending Push Notification
     */
   public function send_notification($registatoin_ids, $message) {
	   
    //$deviceToken = 'APA91bHCcDWYgx-1T_4gEX1d8dQ3RTIrszGz1GFiRRw8mMoQeXIvAeZzsOiDTUBns4jwfbO0Fs3RLUa9V4DvXbugGiVQNpo5AzHH7-dgd5xjM331SGyrio9Ffy8dx6-s_G8ISYPDZZYL6-P2R5YFF_YlB1gSHSQloA';
    //$registatoin_ids  = array($deviceToken);
  
    //$message  = array('Status'=>'Success');
        include_once 'config.php';

        // Set POST variables
        //$url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );

        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
       
        // Open connection
        $ch = curl_init();
       
        curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch); 

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
       return $result;
    }

}

?>

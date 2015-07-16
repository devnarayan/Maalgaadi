<?php
include '../includes/define.php';
            $booking_id=4;
            $id = $booking_id;
            $result = $objConnect->selectWhere("booking", "id=$id");
            $row = $objConnect->fetch_assoc();
            $result1 = $objConnect->selectWhere("booking_short", "booking_id=$id");
            $row1 = $objConnect->fetch_assoc();
            $result2 = $objConnect->selectWhere("booking_logs", "booking_id=$id and status like 'reached to customer'");
            $row2 = $objConnect->fetch_assoc();
            $pickup_date = date("d/m/Y H:i:s", strtotime($row2['datetime']));
            $result3 = $objConnect->selectWhere("booking_logs", "booking_id=$id and status like 'stop trip'");
            $row3 = $objConnect->fetch_assoc();
            $drop_date = date("d/m/Y H:i:s", strtotime($row3['datetime']));
            
            
            $message='<table style="width: 100%;">
                            <tr>
                                <td colspan="4" style="border-right: none; padding-top: 22px; line-height: 20px">
                                    <strong>Invoice No: Mg'.sprintf("%03d", $row['id']).'</strong><br/>
                                    <strong>Date:'.$row3['datetime'].'</strong>
                                </td>
                                <td colspan="2" style="text-align: right; ">
                                    <img src="<?php echo BASE_URL; ?>/images/maalgaadi.png">
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="6" style="text-align: center;border: 1px solid black; background: #0a2b6e;border-bottom: 5px solid #fec60f; color: #fff; padding: 7px 0">
                                    <h2 style="font-size: 23px">';
                                        
                                        if (($row['customer_organization'] != "NA") && (!empty($row['customer_organization']))) {
                                            $message.=$row['customer_organization'];
                                            ?><?php
                                        } else {
                                            $message.=$row['firstname'];
                                        }
                                        
                                        $message.='</h2></td>
                               
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <table style="width:96%; margin: 20px auto 0">
                                        <tr>
                                <td style=" width: 70%;text-align: center;border: 1px solid #ccc; border-right: none; color: #000">
                                    <div style="  padding-top: 20px; margin-top: -1px">';
                                    
                                    $loading = 0.0;
                                    $unloading = 0.0;
                                    if ($row['loading']) {
                                        $loading = $row['loading_charge'];
                                    }
                                    if ($row['unloading']) {
                                        $unloading = $row['loading_charge'];
                                    }
                                    $loading = sprintf("%.02f", $loading);
                                    $unloading = sprintf("%.02f", $unloading);
                                    $Freight=$row1['total_payment_amount']-$loading-$unloading;
                                        $message.='<h3 style="font-size: 23px;">Total Amount: <br /><span style="font-size:50px; line-height: 60px">'.$row1['total_payment_amount'].'</span></h3>
                                    <h3 style="line-height:35px; font-size: 18px">Total Freight:'.$Freight.'</h3>

                                    <h3 style="line-height:35px; font-size: 18px">Charges for Loading:'.$loading.'</h3>
                                    <h3 style="line-height:35px; font-size: 18px; margin-bottom: 10px">Charges for Unloading: '.$unloading.'</h3>
                                    </div>
                                    
                                    <table style="width: 100%; font-size: 10px">
                                        <tr><th> MONEY DEDUCTED (For prepaid cust)</th><th>DISCOUNT</th><th>PAYABLE AMOUNT</th></tr>
                                        <tr><td style="text-align: center">0.0</td><td style="text-align: center">0.0</td><td style="text-align: center">'.$row1['total_payment_amount'].'</td></tr>
                                    </table>
                              </td>
                              <td style="width: 30%; border: 1px solid #ccc; border-left: none;">
                                  <div id="map-canvas" style="width:100%; height:280px; margin-top: -1px"></div></td>
                                    </tr>
                             </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <table style="width:96%; margin: 20px auto 0">                                        
                                        <tr class="thead">
                                            <th style=" background: #0a2b6e; color: #fff; padding: 10px 0">FARE BREAKUP </th>
                                            <th style=" background: #0a2b6e; color: #fff; padding: 10px 0">BOOKING DETAILS</th>
                                        </tr>
                                        
                                        <tr>
                                                <td style="padding:10px 5px 20px">
                                                    <table style="width:100%; color: #333">
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Minimum Fare:</strong></td>
                                                            <td><span style="font-size:15px">'.$row['model_minfare'].'</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Fare for First 10 Km. :</strong></td>
                                                            <td><span style="font-size:15px">'.$row['firstten'].'</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Fare for Post 10 Km. :</strong></td>
                                                            <td><span style="font-size:15px">'.$row['rate'].'</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Fare per hour :</strong></td>
                                                            <td><span style="font-size:15px">'.$row['wait_time_charge'].'</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Fare for Loading/Unloading:</strong></td>
                                                            <td><span style="font-size:15px">'.$row['loading_charge'].'/'.$row['loading_charge'].'</span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="padding:10px 5px 20px; font-size:15px">
                                                    <table style="width:100%; color: #333">
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Booking Id:</strong></td>
                                                            <td><span style="font-size:15px">'.sprintf("%7d", $row['id']).'</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Service Type :</strong></td>
                                                            <td><span style="font-size:15px">'.$row['vehicle'].'</span></td>
                                                        </tr>
                                                        <tr>';
                                                        $trip_distance=$row1['trip_distance']/ 1000;
                                                            $message.='<td><strong style="font-size:15px; line-height: 25px">Total Distance  :</strong></td>
                                                            <td><span style="font-size:15px">'.$trip_distance.' Km</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Total Time :</strong></td>
                                                            <td><span style="font-size:15px">'.$row1['wait_time'].' min</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Pickup Date and Time :</strong></td>
                                                            <td><span style="font-size:15px">'.$pickup_date.'</span></td>
                                                         </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Drop Date and Time :</strong></td>
                                                            <td><span style="font-size:15px">'.$drop_date.'</span></td>
                                                         </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Person Contact Number :</strong></td>
                                                            <td><span style="font-size:15px">'.$row['phone'].'</span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        
                                        <tr>
                                            <td colspan="2" style=" padding: 20px 0; border-top: 1px solid #ccc">
                                                **Higher of the Hourly or Distance rate will be charged.<br>
                                                ** All charges other than freight & loading/unloading like toll tax etc will be charged from the customer on actual basis.<br>

                                                For further queries, please write to mail@maalgaadi.net<br>
                                                Note: This is an electronically generated invoice and does not require signature.<br>

                                            </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <td colspan="2" style="text-align: center; background: black; color: #fff; padding: 10px 0">
                                                301, Laxmi Tower, M.G. Road, Indore M. P. -  452018   <br>          
                                                Tel : +91 731 4256866         <br>    
                                                AVPS Transort           <br>  

                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                        </table>';

                        echo$row['email'];
                        echo$message;

                $emailList="akshay@ebabu.co";        
                       // $to=$row['email']; //change to ur mail address
                $to="kaushal@ebabu.co";
                $strSubject="MaalGaadi | Invoice";
                //$message =  file_get_contents('templete.php');              
                $headers = 'MIME-Version: 1.0'."\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                $headers .= "From:No Reply <no-reply@engineerbabu.com>"; 
                $headers .= "Bcc:akshay@ebabu.co";
                
                $mail_sent=mail($to, $strSubject, $message, $headers);  
    ?>

<?php
include '../includes/define.php';
verifyLogin();
?>
<html>
    <head>
        <?php include '../includes/head.php'; ?>
        <style>
            #footer{
                bottom:0 !important;  
            }
        </style>
    </head>
    <body data-base="<?php echo BASE_URL; ?>">
        <?php include '../includes/header.php'; ?>

        <div class="crumbs">
            <ul id="breadcrumbs" class="breadcrumb">
                <li>
                    <a href=<?php echo BASE_URL; ?>admin/dashboard title=<?php echo BASE_URL; ?>admin/dashboard>Home</a>		                </li>
                <li class="active"><a title="">Booking List</a></li>
            </ul>
        </div>

        <div class="content_middle mt15"> 
            <?php 
            $id=$_GET['booking'];
            $sql="select booking.*, booking_short.distance_to_customer as to_customer,customer.customer_name,customer.customer_organization, booking_short.trip_time,booking_short.trip_distance,booking_short.payment_type,booking_short.payment,booking_short.total_payment_amount,booking_short.balance,booking_short.booking_type from booking inner join customer on customer.id=booking.customer_id left join booking_short on booking.id=booking_short.booking_id where booking.status=7  and booking.id=$id";
            $result=$objConnect->execute($sql);
            $row=$objConnect->fetch_assoc();
            ?>
            <form method="post" action="makepayment.php" id="payment">
            <table border="0" cellpadding="5" cellspacing="0" width="100%">
                <tr>
                    <td colspan="2" class="style_1">Booking Report</td>
                </tr>   
                <tr>
                    <td colspan="2" height="10"></td>
                </tr>  
                <tr>
                    <td valign="top" width="20%" class="mtb"><label>Booking Id</label><span class="star">*</span></td>        
                    <td class="mtb">
                        <div class="new_input_field">
                            <div class="new_input_field">
                                <input type="text" name="booking_id" id="booking_id" value="<?php echo sprintf("%07d",$row['id']);?>" readonly/>
                            </div>
                        </div>
                    </td>
                    
                </tr>
                <tr>
                    <td valign="top" width="20%" class="mtb"><label>Trip Time</label><span class="star">*</span></td>        
                    <td class="mtb">
                        <div class="new_input_field">
                            <input type="text" title="Trip Time" id="trip_time" name="trip_time" value="<?php echo $row['trip_time'];?>" readonly />
                        </div>
                    </td>
                    
                    
               
                </tr>
                <tr>
                     <td valign="top" width="20%" class="mtb"><label>Trip Distance</label><span class="star">*</span></td>        
                    <td class="mtb">
                        <div class="new_input_field">
                            <input type="text" title="trip_distance" id="trip_distance" name="trip_distance" value="<?php echo $row['trip_distance'];?>" readonly />
                            <input type="hidden" title="rate" id="rate" name="rate" value="<?php echo $row['rate'];?>"/>
                        </div>
                    </td>
                    
                </tr>
                <tr>
                     <td valign="top" width="20%" class="mtb"><label>Total Payment</label><span class="star">*</span></td>        
                    <td class="mtb">
                        <div class="new_input_field">
                            <i class="fa fa-rupee"></i> <?php echo $row['total_payment_amount'];?>
                        </div>
                    </td>
                    
                </tr>
                <tr>
                     <td valign="top" width="20%" class="mtb"><label> Payment</label><span class="star">*</span></td>        
                    <td class="mtb">
                        <div class="new_input_field">
                            <i class="fa fa-rupee"></i> <?php echo $row['payment'];?>
                        </div>
                    </td>
                    
                </tr>
                <tr>
                     <td valign="top" width="20%" class="mtb"><label>Balance</label><span class="star">*</span></td>        
                    <td class="mtb">
                        <div class="new_input_field">
                            <i class="fa fa-rupee"></i> <?php echo $row['balance'];?>
                        </div>
                    </td>
                    
                </tr>
                <tr>
                     <td valign="top" width="20%" class="mtb"><label>Amount</label><span class="star">*</span></td>        
                    <td class="mtb">
                        <div class="new_input_field">
                            <input type="number" placeholder="enter payment amount" name="payment" required>
                        </div>
                    </td>
                    
                </tr>
                    <tr>
                <td>&nbsp;</td>
                                        <td colspan="2">
                                            
                                            <input type="hidden" name="mode" value="payment">
                                            <div class="button greenB">  <input type="button" class="my_btn" value="Search" title="submit" onclick="formSubmit('payment','searchResult','payment_update.php')" /></div>
                                            <div class="clr">&nbsp;</div>
                                            <div class="" id="searchResult"></div>
                                        </td>
                </tr>
                
            </table>
        </form>
            
            <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
        </div>

    <style>
        tfoot {
            display: table-header-group;

        }
    </style>

<?php include '../includes/footer.php'; ?>
</body>
</html>
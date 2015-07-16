<?php include '../includes/define.php'; ?>
<html><head>
        <?php include '../includes/head.php'; ?>
    </head>
    <body data-base="<?php echo BASE_URL; ?>">
        <?php include '../includes/header.php'; ?>
        <div class="crumbs">
            <ul id="breadcrumbs" class="breadcrumb">
                <li>
                    <a href="<?php echo BASE_URL; ?>" title="<?php echo BASE_URL; ?>">Home</a>		                
                </li>
                <li>
                    <a href="<?php echo BASE_URL; ?>/employee/employee_list.php" title="<?php echo BASE_URL; ?>">Vehicle</a>		                
                </li>
                <li class="active"><a title="">Employees</a></li>
            </ul>

        </div>
        <?php
       
            $id=$_REQUEST['id'];
            $sql = "select vehicle.*,min(date) as start_date,max(date) as end_date, sum(amount_payable) as remaining from vehicle left join settlement on settlement.vehicle_id=vehicle.id  where vehicle.id = $id and settlement.status=0";
            $result=  mysql_query($sql) or die(mysql_error());
            $row=  mysql_fetch_assoc($result);
            extract($row);
            $end_date=changeFormat("Y-m-d","d/m/Y",$end_date);
            $start_date=changeFormat("Y-m-d","d/m/Y",$start_date);
       
?>
        <!-- General form elements -->
        <div class="widget ">
            <div class="navbar">
                <div class="navbar-inner">
                    <h6><i class="icon-align-justify"></i>Pay to Vehicle </h6>
                </div>
            </div>
           
                        <div class="content_middle">
                            <form name="addtaxi_form" id="addtaxi_form" class="form" action="" method="post" enctype="multipart/form-data">
                                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                                    <tr>
                                        <td colspan="2" class="style_1"> Information</td>

                                    </tr>   
                                    <tr>
                                        <td colspan="2" height="10"></td>
                                    </tr>       
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Vehicle Name</label><span class="star">*</span></td>        
                                        <td class="mtb">

                                            <div class="new_input_field">
                                                <?php echo $name;?>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Registration no</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                               <?php echo $registration_no;?>
                                            </div>
                                        </td>   	
                                    </tr> 
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Amount Payable</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <div class="formRight">
                                                    <input type="number" name="payable" id="payable" readonly value="<?php echo $remaining;?>">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>From</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <div class="formRight">
                                                    <input type="text" name="payment_from" readonly="true" id="payment_from" value="<?php echo $start_date;?>" required >
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>To</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <div class="formRight">
                                                    <input type="text" name="payment_to" readonly="true" id="payment_to" value="<?php echo $end_date;?>" required >
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Payment Amount</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <div class="formRight">
                                                    <input type="number" name="payment" id="payment" class="required" value="<?php echo $remaining; ?>"  required>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                               
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="" class="star">*Required Fields</td>
                                    </tr>                         
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2">
                                            <br />
                                          
                                            <input type="hidden" name="mode" value="payment"/>
                                            <input type="hidden" value="<?php echo $_REQUEST['id'];?>" name="vehicle_id">
                                            
                                            <div class="button dredB">   <input type="reset" value="Reset" title="Reset" style="line-height:13px; background:#dadada; color:#303030;" /></div>
                                            <div class="button greenB">  <input type="button" class="my_btn" value="submit" onClick="formSubmit('addtaxi_form', 'form_result', 'payment_update.php')" title="submit" /></div>
                                            <div class="clr">&nbsp;</div>
                                            <div class="form_result" id="form_result"></div>
                                        </td>
                                    </tr> 
                                </table>
                            </form>
                        
                        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
                    </div>
                </div> 

           
        <script>
            $(document).ready(function () {
                $("#dob").datepicker({
                    dateFormat: 'dd/mm/yy',
                    viewMode: "months",
                    minViewMode: "months",
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(1950, 1 - 1, 1)


                });
                $("#joining_date").datepicker({
                    dateFormat: 'dd/mm/yy',
                    showOtherMonths: true,
                    changeMonth: true,
                    changeYear: true

                });
            });
        </script>

        <?php include '../includes/footer.php'; ?>
    </body>
</html>
<?php
include '../includes/define.php';
verifyLogin();
?>
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
                    <a href="<?php echo BASE_URL; ?>/vehicle/vehicle.php" title="<?php echo BASE_URL; ?>">Vehicle</a>		                
                </li>
                <li class="active"><a title="">Add Vehicle</a></li>
            </ul>

        </div>
        <!-- General form elements -->
        <div class="widget mt15">
            <div class="navbar">
                <div class="navbar-inner">
                    <h6><i class="icon-align-justify"></i>Add Vehicle</h6>
                </div>
            </div>

            <div class="content_middle">
                <?php
                $name = "";
                $city_id = "";
                $registration_no = "";
                $insurence_validity = "";
                $capacity = "";
                $fare = "";
                $email = "";
                $mobile_no = "";
                $device_token = "";
                $driver1_id = "";
                $driver2_id = "";
                $addedon = "";
                $addedby = "";
                $status = "";
                $polution_validity = "";
                $fitness_validaity = "";
                $road_tax_validity = "";
                $imei_number="";
                if ((isset($_REQUEST['id'])) && (!empty($_REQUEST['id']))) {
                    $id = $_REQUEST['id'];
                    $result6 = $objConnect->selectWhere("vehicle", "id=$id");
                    $num6 = $objConnect->total_rows();
                    if ($num6) {
                        $row6 = $objConnect->fetch_assoc();
                        extract($row6);
                        $insurence_validity = changeFormat("Y-m-d", "d/m/Y", $insurence_validity);
                        $polution_validity = changeFormat("Y-m-d", "d/m/Y", $polution_validity);
                        $fitness_validaity = changeFormat("Y-m-d", "d/m/Y", $fitness_validaity);
                        $road_tax_validity = changeFormat("Y-m-d", "d/m/Y", $road_tax_validity);
                    } else {
                        echo "Vehicle Is not editable <a href='driver_list.php'>View Driver List</a>";

                        die();
                    }
                }
                ?>
                <form name="addtaxi_form" id="addtaxi_form" class="form" action="" method="post" enctype="multipart/form-data">
                    <table border="0" cellpadding="5" cellspacing="0" width="100%">

                        <tr>
                            <td colspan="2" height="10"></td>
                        </tr> 
                        <tr>
                            <td valign="top" width="20%" class="mtb"><label>City</label><span class="star">*</span></td>        
                            <td class="mtb">
                                <div class="new_input_field">
                                    <div class="formRight">
                                        <div class="new_input_field">

                                            <select name="city_id" id="city_id" class="required"  title="Select the City" onchange="get_vehicle_category(this.value);" >
                                                <option value="">--Select City--</option>
                                                <?php
                                                $result = $objConnect->select('city');
                                                while ($row = $objConnect->fetch_assoc()) {
                                                    ?>
                                                    <option <?php
                                                    if ($city_id == $row['id']) {
                                                        echo "selected='selected'";
                                                    }
                                                    ?> value="<?php echo $row['id']; ?>"><?php echo $row['city']; ?></option>
                                                        <?php
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>      
                        <tr>
                            <td valign="top" width="20%" class="mtb"><label>Category</label><span class="star">*</span></td>        
                            <td class="mtb">
                                <div class="new_input_field">
                                    <div class="formRight">
                                        <div class="new_input_field">

                                            <select name="category" id="ac" class="required"  title="Select the Category" onChange="fillvehicledetail(this.value)">
                                                <option value="">--Select--</option>
                                                <?php
                                                $result = $objConnect->select('vehicle_category');
                                                while ($row = $objConnect->fetch_assoc()) {
                                                    ?>
                                                    <option <?php
                                                    if ($category == $row['name']) {
                                                        echo "selected='selected'";
                                                    }
                                                    ?> value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="20%" class="mtb"><label>Vehicle Name</label><span class="star">*</span></td>        
                            <td class="mtb">
                                <div class="new_input_field">
                                    <input type="text" title="Enter the taxi number" id="name" class="required" name="name" required value="<?php echo $name; ?>" minlength="4" maxlength="30" />
                                </div>
                            </td>   	
                        </tr> 

                        <input type="hidden" name="capacity" id="capacity" value="<?php echo $capacity; ?>" >


                        <input type="hidden" name="fare" id="fare" value="<?php echo $fare; ?>" >

                        <tr>
                            <td valign="top" width="20%" class="mtb"><label>Registration No</label><span class="star">*</span></td>        
                            <td class="mtb">
                                <div class="new_input_field">
                                    <input type="text" value="<?php echo $registration_no; ?>" title="Enter The Registration no of Vehicle (For Example: MP 09 NB 6199)" class="required " name="registration_no" id="registration_no"   />
                                </div>
                            </td>   	
                        </tr> 
                        <tr>
                            <td valign="top" width="20%" class="mtb"><label>Email</label><span class="star">*</span></td>        
                            <td class="mtb">
                                <div class="new_input_field">
                                    <input type="email" value="<?php echo $email; ?>" title="Enter The Emial associated With Vehicle (For Example: example@gmail.com)" class="required " name="email" id="email"   />
                                </div>
                            </td>   	
                        </tr>
                        <tr>
                            <td valign="top" width="20%" class="mtb"><label>Mobile No</label><span class="star">*</span></td>        
                            <td class="mtb">
                                <div class="new_input_field">
                                    <input type="number" value="<?php echo $mobile_no; ?>" title="Enter The mobile no associated With Vehicle (For Example: 7566852411)" class="required " name="mobile_no" id="mobile_no"   />
                                </div>
                            </td>   	
                        </tr>
                        <tr>
                            <td valign="top" width="20%" class="mtb"><label>Imei number</label><span class="star">*</span></td>        
                            <td class="mtb">
                                <div class="new_input_field">
                                    <input type="text" value="<?php echo $imei_number; ?>" title="Enter The IMEI Number" name="imei_number" id="imei_number"   />
                                </div>
                            </td>   	
                        </tr>
                        <tr>
                            <td valign="top" width="20%" class="mtb"><label>Insurance Validity</label><span class="star">*</span></td>        
                            <td class="mtb">
                                <div class="new_input_field">
                                    <input type="text" name="insurence_validity" value="<?php echo $insurence_validity; ?>" id="insurence_validity" class="required"  required>                                                  
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="20%" class="mtb"><label>Polution Cert. Validity</label><span class="star">*</span></td>        
                            <td class="mtb">
                                <div class="new_input_field">
                                    <input type="text" name="polution_validity" value="<?php echo $polution_validity; ?>" id="polution_validity" class="required"  required>                                                  
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="20%" class="mtb"><label>Fitness Cert. Validity</label><span class="star">*</span></td>        
                            <td class="mtb">
                                <div class="new_input_field">
                                    <input type="text" name="fitness_validaity" value="<?php echo $fitness_validaity; ?>" id="fitness_validaity" class="required"  required>                                                  
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="20%" class="mtb"><label>Road Tax Cert. Validity</label><span class="star">*</span></td>        
                            <td class="mtb">
                                <div class="new_input_field">
                                    <input type="text" name="road_tax_validity" value="<?php echo $road_tax_validity; ?>" id="road_tax_validity" class="required"  required>                                                  
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="20%"><label>Polution Scan</label><span class="star">*</span></td>        
                            <td>
                                <div class="new_input_field">
                                    <input type="file" title="polution Image"  name="polution_scan" id="polution_scan"/>                                         </div>
                            </td>   	
                        </tr>
                        <tr>
                            <td valign="top" width="20%"><label>RC image</label></td>        
                            <td>
                                <div class="new_input_field">
                                    <input type="file" title="RC Image"  name="rc_scan" id="rc_scan"/>                                         </div>
                            </td>   	
                        </tr>
                        <tr>
                            <td valign="top" width="20%"><label>Fitness image</label></td>        
                            <td>
                                <div class="new_input_field">
                                    <input type="file" title="Fitness Image"  name="fitness_scan" id="fitness_scan"/>                                         </div>
                            </td>   	
                        </tr>
                        <tr>
                            <td valign="top" width="20%"><label>Insurance Scan</label></td>        
                            <td>
                                <div class="new_input_field">
                                    <input type="file" title="Insurance Image"  name="insurance_scan" id="insurance_scan"/>                                         </div>
                            </td>   	
                        </tr>
                        <tr>
                            <td valign="top" width="20%"><label>Road Tax Scan</label></td>        
                            <td>
                                <div class="new_input_field">
                                    <input type="file" title="Road Tax Image"  name="road_tax_scan" id="road_tax_scan"/>                                         </div>
                            </td>   	
                        </tr>
                        <tr>
                            <td valign="top" width="20%" class="mtb"><label>Driver 1</label><span class="star">*</span></td>        
                            <td class="mtb">
                                <div class="new_input_field">
                                    <div class="formRight">
                                        <div class="new_input_field">
                                            <?php 
                                            $search = "";
                                            $vehicle_id="";
                                                if ((isset($_REQUEST['id'])) && (!empty($_REQUEST['id']))) {
                                                    $search = " or vehicle_id=$id";
                                                    $xxxx=" where id !=$id";
                                                    $vehicle_id=$_REQUEST['id'];
                                                }
                                            ?>
                                            <select name="driver1_id" id="driver1_id" class="required"  title="Select the Driver1" onChange="driver2Fetch(this.value, 'driver2selecter','<?php echo $vehicle_id;?>')">
                                                <option value="">--Select--</option>
                                                <?php
                                                
                                                $sql="select * from driver where id not in (select driver1_id from vehicle $xxxx) and id not in (select driver2_id from vehicle $xxxx)";
                                              
                                                $result1 = $objConnect->execute($sql);
                                                while ($row1 = $objConnect->fetch_assoc()) {
                                                    ?>
                                                    <option <?php
                                                    if ($driver1_id == $row1['id']) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?> value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>
                                                        <?php
                                                    }
                                                    ?>  
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="20%" class="mtb"><label>Driver2</label><span class="star">*</span></td>        
                            <td class="mtb">
                                <div class="new_input_field">
                                    <div class="formRight">
                                        <div class="new_input_field" id="driver2selecter">
                                            <select name="driver2_id" id="driver2_id" class="required"  title="Select the Driver2" >
                                                <option value="">--Select--</option>
                                                <?php
                                                $sql="select * from driver where id not in (select driver1_id from vehicle $xxxx) and id not in (select driver2_id from vehicle $xxxx)";
                                                $result1 = $objConnect->execute($sql);
                                                while ($row2 = $objConnect->fetch_assoc()) {
                                                    ?>
                                                    <option <?php
                                                    if ($driver2_id == $row2['id']) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?> value="<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                            </select>
                                        </div>
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
                                <?php if ((isset($_REQUEST['id'])) && (!empty($_REQUEST['id']))) { ?>
                                    <input type="hidden" name="mode" value="edit"/>
                                    <input type="hidden" value="<?php echo $_REQUEST['id']; ?>" name="id">
                                    <?php
                                } else {
                                    ?>
                                    <input type="hidden" name="mode" value="new"/>
                                    <?php
                                }
                                ?>
                                <div class="button dredB">   <input type="reset" value="Reset" title="Reset" style="line-height:13px; background:#dadada; color:#303030;" /></div>
                                <div class="button greenB">  <input type="button" class="my_btn" value="submit" onClick="formSubmit('addtaxi_form', 'form_result', 'vehicle_update.php')" title="submit" /></div>
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

        function get_vehicle_category(value)
            {
                //alert(value);
                $.ajax({
                    url:'vehicle_update.php?mode=get_vehicle_category&value='+value,
                    success: function(data){
                       // alert(data)
                        $('#ac').html(data);
                    }


                });
            }


            $(document).ready(function () {
                $("#insurence_validity").datepicker({
                    dateFormat: 'dd/mm/yy',
                    viewMode: "months",
                    minViewMode: "months",
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(2011, 1 - 1, 1)
                });
                $("#polution_validity").datepicker({
                    dateFormat: 'dd/mm/yy',
                    viewMode: "months",
                    minViewMode: "months",
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(2011, 1 - 1, 1)
                });
                $("#fitness_validaity").datepicker({
                    dateFormat: 'dd/mm/yy',
                    viewMode: "months",
                    minViewMode: "months",
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(2011, 1 - 1, 1)
                });
                $("#road_tax_validity").datepicker({
                    dateFormat: 'dd/mm/yy',
                    viewMode: "months",
                    minViewMode: "months",
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(2011, 1 - 1, 1)
                });
            });
        </script>

        <?php include '../includes/footer.php'; ?>
    </body>
</html>
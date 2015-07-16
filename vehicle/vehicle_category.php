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
                    <a href="<?php echo BASE_URL; ?>" title="<?php echo BASE_URL; ?>">Home</a></li>
                 <li>
                    <a href="<?php echo BASE_URL; ?>vehicle/vehicle_category_list.php" title="<?php echo BASE_URL; ?>">Vehicle Category list</a></li>
                <li class="active"><a title="">Add Vehicle Category </a></li>
              </ul>
            </div>
        <!-- General form elements -->
       
        <div class="widget mt15">
            <div class="navbar">
                <div class="navbar-inner">
                    <h6><i class="icon-align-justify"></i>Add Vehicle Category</h6>
                </div>
            </div>
            
                    
                        <div class="content_middle">
                            <?php
                            $name = "";
                            $capacity = "";
                            $volume = "";
                            $fare = "";
                            $rate = "";
                            $min_fare = "";
                            $waiting_time = "";
                            $waiting_time_charge = "";
                            $contract_km = "";
                            $contract_hour = "";
                            $extra_km_rate = "";
                            $extra_time_rate = "";
                            $image = "";
                            $loading_charge="";
                            $loading_charge="";
                            $unloading_charge="";
                            $waiting_charge="";
                            $rate_per_drop_point="";
                            $loading_unloading_time_allowed="";
                            if ((isset($_REQUEST['id'])) && (!empty($_REQUEST['id']))) {
                                $id = $_REQUEST['id'];
                                $result6 = $objConnect->selectWhere("vehicle_category", "id=$id and status=1");
                                $num6 = $objConnect->total_rows();
                                if ($num6) {
                                    $row6 = $objConnect->fetch_assoc();
                                    extract($row6);
                                } else {
                                    echo "Vehicle category Is not editable <a href='vehicle_category_list.php'>View Driver List</a>";

                                    die();
                                }
                            }
                            ?>
                            <form name="addcategory_form" id="addcategory_form" class="form" action="" method="post" enctype="multipart/form-data">
                                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                                 <tr>
                                        <td valign="top" width="20%" class="mtb"><label>City</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <div class="formRight">
                                                    <div class="new_input_field">

                                                        <select name="city_id" id="ac" class="required"  title="Select the City" >
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
                                        <td valign="top" width="20%"><label>Category Name</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="text" title="Enter the Category Name" id="name" class="required" name="name" required value="<?php echo $name; ?>" minlength="4" maxlength="30" />
                                            </div>
                                        </td>   	
                                    </tr> 
                                    <tr>
                                        <td valign="top" width="20%"><label>Capacity(<small>kg</small>)</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field ">

                                                <input type="number" title="Enter The Vehicle Capacity(eg. 100)" class="required " value="<?php echo $capacity; ?>" name="capacity" id="capacity"   />

                                            </div>
                                        </td>   	
                                    </tr> 
                                    <tr>
                                        <td valign="top" width="20%"><label>Volume(<small>l x W x H</small>)</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field ">

                                                <input type="text" title="Enter The Vehicle Volume(eg. 20 X 10 X 7)" class="required " value="<?php echo $volume; ?>" name="volume" id="volume"   />

                                            </div>
                                        </td>   	
                                    </tr> 
                                    <tr>
                                        <td valign="top" width="20%"><label>Monthly Salary</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="number" title="Enter The Monthly Salary(eg. 21000)" class="required " value="<?php echo $fare; ?>" name="fare" id="fare"   />
                                            </div>
                                        </td>   	
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>Rate (for first 10 km)</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="number" title="Min Fare " class="required " name="firstten" id="firstten" value="<?php echo $firstten ?>"   />
                                            </div>
                                        </td>   	
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>Rate(post 10 km)</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="number" title="Min Fare " class="required " name="rate" id="rate" value="<?php echo $rate; ?>"   />
                                            </div>
                                        </td>   	
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>loading Charge</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="number" title="Min Fare " class="required " name="loading_charge" id="loading_charge" value="<?php echo $loading_charge; ?>"   />
                                            </div>
                                        </td>   	
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>Unloading Charge</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="number" title="Min Fare " class="required " name="unloading_charge" id="unloading_charge" value="<?php echo $unloading_charge; ?>"   />
                                            </div>
                                        </td>       
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>Min Fare</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="number" title="Min Fare " class="required " name="min_fare" id="min_fare"  value="<?php echo $min_fare; ?>" />
                                            </div>
                                        </td>   	
                                    </tr>
                                    
                                    <tr>
                                        <td valign="top" width="20%"><label>Hourly Price</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="number" title="Hourly Price(per hour)" class="required " value="<?php echo $waiting_time_charge; ?>" name="waiting_time_charge" id="wait_time_charge"/>                                         </div>
                                        </td>   	
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>Contract Km</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="number" title="Contract Km" class="required " name="contract_km" value="<?php echo $contract_km; ?>" id="contract_km"/>                                         </div>
                                        </td>   	
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>Contract Hour</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="number" title="Contract Hour" class="required " name="contract_hour" value="<?php echo $contract_hour; ?>" id="contract_hour"/>                                         </div>
                                        </td>   	
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>Extra km Rate</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="number" title="Extra km Rate" class="required " name="extra_km_rate" value="<?php echo $extra_km_rate; ?>" id="extra_km_rate"/>                                         </div>
                                        </td>   	
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>Rate/Drop Point</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="number" title="Rate/Drop Point" class="required " name="rate_per_drop_point" value="<?php echo $rate_per_drop_point; ?>" id="rate_per_drop_point"/>                                         </div>
                                        </td>   	
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>Waiting Charge(Per Minutes)</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="number" title="Waiting Charge" class="required " name="waiting_charge" value="<?php echo $waiting_charge; ?>" id="waiting_charge"/>                                         </div>
                                        </td>       
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>Loading/Unloading Time Allowed(In Minutes)</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="number" title="Loading/Unloading Time Allowed" class="required " name="loading_unloading_time_allowed" value="<?php echo $loading_unloading_time_allowed; ?>" id="loading_unloading_time_allowed"/>                                         </div>
                                        </td>       
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>Vehicle image</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="file" title="Vehicle Image"  name="image" id="image"/>                                         </div>
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
                                          
                                            <div class="button dredB">   <input type="reset" value="Reset" title="Reset" /></div>
                                            <div class="button greenB">  <input type="button" value="submit" onclick="formSubmit('addcategory_form', 'form_result', 'vehicle_category_update.php')" title="submit" /></div>
                                            <div class="clr">&nbsp;</div>
                                            <div class="form_result" id="form_result"></div>
                                        </td>
                                    </tr> 
                                </table>
                            </form>
                        </div>
                        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
                    </div>
               


        <?php include '../includes/footer.php'; ?>
    </body>
</html>
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
                    <a href="<?php echo BASE_URL; ?>/customer/customer_list.php" title="<?php echo BASE_URL; ?>">Customer List</a>		                
                </li>
                <li class="active"><a title="">Add Customer</a></li>
                            </ul>

        </div>
        <?php
        $customer_name="";
        $city_id="";
        $customer_email="";
        $custome_number="";
        $dob="";
        $customer_address="";
        $customer_organization="";
        $customer_category="";
        $image="";
        $bus_name="";
        $ref_name="";
        $organization_id="";
        
        if((isset($_REQUEST['id']))&&(!empty($_REQUEST['id']))){
            $id=$_REQUEST['id'];
            $result6=$objConnect->selectWhere("customer","id=$id and status=1");
            $row6=$objConnect->fetch_assoc();
            extract($row6);
            if($dob!="0000-00-00"){
            $dob=changeFormat("Y-m-d","d/m/Y",$dob);
            }
            else{
                $dob="";
            }
        }
?>
        <!-- General form elements -->
        <div class="widget ">
            <div class="navbar">
                <div class="navbar-inner">
                    <h6><i class="icon-align-justify"></i>Add Customer</h6>
                </div>
            </div>
           
                        <div class="content_middle">
                            <form name="addtaxi_form" id="addtaxi_form" class="form" action="" method="post" enctype="multipart/form-data">
                                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                                    <tr>
                                        <td colspan="2" class="style_1">Customer Information</td>

                                    </tr>   
                                    <tr>
                                        <td colspan="2" height="10"></td>
                                    </tr> 
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>City</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <div class="formRight">
                                                    <div class="new_input_field">

                                                        <select name="city_id" id="city_id" class="required"  title="Select the City" onchange="get_organization(this.value);" >
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
                                        <td valign="top" width="20%" class="mtb"><label>Customer Organization</label><span class="star"></span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <select  name="organization_id" id="organization_id" >
                                                    <option value="">Select Organization</option>
                                                    <?php 
                                                    $sql1="select *  from organization ";
                                                    $result1=  mysql_query($sql1) or die(mysql_error());
                                                    while($row1=  mysql_fetch_assoc($result1)){
                                                        ?>
                                                    <option value="<?php echo $row1['id']?>" <?php if($row1['id']==$organization_id){echo 'selected=selected';}?>><?php echo $row1['name'];?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                           
                                        </td>
                                    </tr>      
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Name</label><span class="star">*</span></td>        
                                        <td class="mtb">

                                            <div class="new_input_field">
                                                <input type="text" title="Enter name Of the Customer" id="customer_name" class="required" name="customer_name" required value="<?php echo $customer_name;?>" />
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Email</label></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <input type="email" title="Enter the Employeees Email" id="customer_email" name="customer_email"  value="<?php echo $customer_email;?>"  />
                                            </div>
                                        </td>   	
                                    </tr> 
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Mobile No</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <div class="formRight">
                                                    <input type="number" name="customer_number" id="customer_number" required value="<?php echo $customer_number;?>" minlength="10" maxlength="15">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Customer Address</label><span class="star"></span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <div class="formRight">
                                                    <textarea name="customer_address" id="customer_address" ><?php echo $customer_address;?></textarea>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Customer Category</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <div class="formRight">
                                                    <select name="customer_category" id="customer_category" class="required"  required>
                                                        <option <?php if($customer_category=="Regular"){echo 'selected="selected"';}?> value="Regular">Regular</option>
                                                        <option <?php if($customer_category=="Corporate"){echo 'selected="selected"';}?> value="Corporate">Corporate</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>DOB</label><span class="star"></span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <div class="formRight">
                                                    <input type="text" name="dob" id="dob"  value="<?php echo $dob;?>" >
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Photo</label><span class="star"></span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <input type="file" title=""  name="image" id="image"   />
                                            </div>
                                        </td>   	
                                    </tr> 
                                    <!-- <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Customer Organization</label><span class="star"></span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <select  name="customer_organization" id="customer_organization" onchange="if(this.value==''){$('#other').show();}else{$('#other').hide();$('#other').val('');}">
                                                    <option value=""> No Organization </option>
                                                    <?php 
                                                    $sql1="select distinct customer_organization from customer where customer_organization!=''";
                                                    $result1=  mysql_query($sql1) or die(mysql_error());
                                                    while($row1=  mysql_fetch_assoc($result1)){
                                                        ?>
                                                    <option value="<?php echo $row1['customer_organization']?>" <?php if($row1['customer_organization']==$customer_organization){echo 'selected=selected';}?>><?php echo $row1['customer_organization'];?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="new_input_field mt10">
                                                <input type="text" name="other" <?php if($customer_organization!=""){echo "style='display:none;'";}?> id="other">
                                            </div>
                                        </td>
                                    </tr> -->


                                    


                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Business Name</label></td>        
                                        <td class="mtb">

                                            <div class="new_input_field">
                                                <input type="text" title="Enter name Of the Business" id="bus_name"  name="bus_name"  value="<?php echo $bus_name;?>" />
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Referance Name</label></td>        
                                        <td class="mtb">

                                            <div class="new_input_field">
                                                <input type="text" title="Enter name Of the Referance" id="ref_name" name="ref_name"  value="<?php echo $ref_name;?>" />
                                            </div>

                                        </td>
                                    </tr>
                                        <?php if(!((isset($_REQUEST['id']))&&(!empty($_REQUEST['id'])))){
                                        ?>
                                    
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Password</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <div class="formRight">
                                                    <input type="password" value="" name="password" id="password" required/>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Confirm Password</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <div class="formRight">
                                                    <input type="password" value="" name="cpassword" id="cpassword" equalTo="#password"/>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="" class="star">*Required Fields</td>
                                    </tr>                         
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2">
                                            <br />
                                            <?php if((isset($_REQUEST['id']))&&(!empty($_REQUEST['id']))){?>
                                            <input type="hidden" name="mode" value="edit"/>
                                            <input type="hidden" value="<?php echo $_REQUEST['id'];?>" name="id">
                                            <?php }
                                            else{
                                                ?>
                                            <input type="hidden" name="mode" value="new"/>
                                            <?php
                                            }
                                            ?>
                                            <div class="button dredB">   <input type="reset" value="Reset" title="Reset" style="line-height:13px; background:#dadada; color:#303030;" /></div>
                                            <div class="button greenB">  <input type="button" class="my_btn" value="submit" onClick="formSubmit('addtaxi_form', 'form_result', 'customer_update.php')" title="submit" /></div>
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

        function get_organization(value)
            {
               // alert(value);
                $.ajax({
                    url:'customer_update.php?mode=organization&value='+value,
                    success: function(data){
                       // alert(data)
                        $('#organization_id').html(data);
                    }


                });
            }


            $(document).ready(function () {
                $("#dob").datepicker({
                    dateFormat: 'dd/mm/yy',
                    viewMode: "months",
                    minViewMode: "months",
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(1950, 1 - 1, 1)


                });

               /* var nsId= localStorage.getItem('_NSCaseId');
                                    alert(nsId);*/
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
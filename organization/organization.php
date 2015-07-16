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
                    <a href="<?php echo BASE_URL; ?>/organization/Organization_list.php" title="<?php echo BASE_URL; ?>">Organization</a>		                
                </li>
                <li class="active"><a title="">Organization</a></li>
            </ul>

        </div>
        <?php
        $name="";
        $email="";
        $city_id="";
        $mobile_no="";
        $dob="";
        $current_address="";
        $permanent_address="";
        $photo="";
        $position="";
        $joining_date="";
        $salary="";
        if((isset($_REQUEST['id']))&&(!empty($_REQUEST['id']))){
            $id=$_REQUEST['id'];
            $result6=$objConnect->selectWhere("organization","id=$id and status=1");
            $row6=$objConnect->fetch_assoc();
            extract($row6);
            $joining_date=changeFormat("Y-m-d","d/m/Y",$joining_date);
            $dob=changeFormat("Y-m-d","d/m/Y",$dob);
        }
?>
        <!-- General form elements -->
        <div class="widget ">
            <div class="navbar">
                <div class="navbar-inner">
                    <h6><i class="icon-align-justify"></i>Add Organization</h6>
                </div>
            </div>
           
                        <div class="content_middle">
                            <form name="addtaxi_form" id="addtaxi_form" class="form" action="" method="post" enctype="multipart/form-data">
                                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                                    <tr>
                                        <td colspan="2" class="style_1">Organization Information</td>

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
                                        <td valign="top" width="20%" class="mtb"><label>Name</label><span class="star">*</span></td>        
                                        <td class="mtb">

                                            <div class="new_input_field">
                                                <input type="text" title="Enter name Of the employee" id="name" class="required" name="name" required value="<?php echo $name;?>" />
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Email</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <input type="email" title="Enter the Employeees Email" id="email" class="required" name="email" required value="<?php echo $email;?>"  />
                                            </div>
                                        </td>   	
                                    </tr> 
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Phone No</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <div class="formRight">
                                                    <input type="number" name="phone_no" id="phone_no" required value="<?php echo $phone_no;?>" minlength="10" maxlength="15">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                   
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Address</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <div class="formRight">
                                                    <textarea name="address" id="address" class="required"  required><?php echo $address;?></textarea>
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
                                            <div class="button greenB">  <input type="button" class="my_btn" value="submit" onClick="formSubmit('addtaxi_form', 'form_result', 'organization_update.php')" title="submit" /></div>
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
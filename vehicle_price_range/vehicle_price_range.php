<?php include '../includes/define.php'; 



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
                    <a href="<?php echo BASE_URL; ?>/discount_coupon/coupon_list.php" title="<?php echo BASE_URL; ?>">Discount Coupons</a>		                
                </li>
                <li class="active"><a title="">Discount Coupons</a></li>
            </ul>

        </div>
       
        <!-- General form elements -->
        <div class="widget ">
            <div class="navbar">
                <div class="navbar-inner">
                    <h6><i class="icon-align-justify"></i>Vehicle Price Range</h6>
                </div>
            </div>
           
                        <div class="content_middle">
                            <form name="addcoupon_form" id="addtaxi_form" class="form" action="" method="post" enctype="multipart/form-data">
                                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                                    <tr>
                                        <td colspan="2" class="style_1">Vehicle Price Range Information</td>

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
                                        <td valign="top" width="20%" class="mtb"><label>Vehicle Category</label><span class="star"></span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <select  name="vehicle_category_id" id="vehicle_category_id" >
                                                    <option value="">Select Vehicle Category</option>
                                                    <?php 
                                                    $sql1="select *  from vehicle_category ";
                                                    $result1=  mysql_query($sql1) or die(mysql_error());
                                                    while($row1=  mysql_fetch_assoc($result1)){
                                                        ?>
                                                    <option value="<?php echo $row1['id']?>" <?php if($row1['id']==$vehicle_category_id){echo 'selected=selected';}?>><?php echo $row1['name'];?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                           
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Meters</label><span class="star">*</span></td>        
                                        <td class="mtb">

                                            <div class="new_input_field">
                                                <input type="number" title="Enter Meters" id="meters" class="required" name="meters" required  value="<?php echo $meters;?>" />
                                            </div>

                                        </td>
                                    </tr>
                                     <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Price</label><span class="star">*</span></td>        
                                        <td class="mtb">

                                            <div class="new_input_field">
                                                <input type="number" title="Enter Price" id="price" class="required" name="price" value="<?php echo $price;?>" required  />
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
                                            <div class="button greenB">  <input type="button" class="my_btn" value="submit" onClick="formSubmit('addtaxi_form', 'form_result', 'vehicle_price_range_update.php')" title="submit" /></div>
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
                $("#valid_till").datepicker({
                    dateFormat: 'dd/mm/yy',
                    viewMode: "months",
                    minViewMode: "months",
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date()


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
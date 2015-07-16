<?php
include '../includes/define.php';
verifyLogin();
?>
<html>
    <head>
<?php include '../includes/head.php'; ?>
    </head>
    <body data-base="<?php echo BASE_URL; ?>">
<?php include '../includes/header.php'; ?>
        <div class="crumbs">
            <ul id="breadcrumbs" class="breadcrumb">
                <li> <a href="<?php echo BASE_URL; ?>" title="<?php echo BASE_URL; ?>">Home</a> </li>
                <li> <a href="<?php echo BASE_URL; ?>/vehicle/driver.php" title="<?php echo BASE_URL; ?>">Driver</a> </li>
                <li class="active"><a title="">Add Driver</a></li>
            </ul>
        </div>
        <!-- General form elements -->
        <div class="widget row-fluid">
            <div class="navbar">
                <div class="navbar-inner">
                    <h6 class=""><i class="fa fa-align-justify"></i> Add Driver</h6>
                </div>
            </div>
           
                    <div class="cont_container mt10"><!--<div class="cont_container mt15 mt10">-->
                        <div class="content_middle">
                            <?php
                            $name = "";
                            $address = "";
                            $mobile = "";
                            $liecence_no = "";
                            $liecence_validity = "";
                            $emergency_contact = "";
$joining_date="";
                            if ((isset($_REQUEST['id'])) && (!empty($_REQUEST['id']))) {
                                $id = $_REQUEST['id'];
                                $result6 = $objConnect->selectWhere("driver", "id=$id and status=1");
                                $num6 = $objConnect->total_rows();
                                if ($num6) {
                                    $row6 = $objConnect->fetch_assoc();
                                    extract($row6);
                                    $liecence_validity = changeFormat("Y-m-d", "d/m/Y", $liecence_validity);
                                    $joining_date = changeFormat("Y-m-d", "d/m/Y", $joining_date);
                                } else {
                                    echo "Driver Is not editable <a href='driver_list.php'>View Driver List</a>";

                                    die();
                                }
                            }
                            ?>
                            <form name="adddriver_form" id="adddriver_form" class="form" action="" method="post" enctype="multipart/form-data">
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
                                        <td valign="top" width="20%" class="mtb"><label>Driver Name</label>
                                            <span class="star">*</span></td>
                                        <td class="mtb"><div class="new_input_field">
                                                <input type="text" title="Enter the Driver Name" id="name" class="required" name="name" required value="<?php echo $name; ?>" minlength="4" maxlength="30" />
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Mobile No</label>
                                            <span class="star">*</span></td>
                                        <td class="mtb"><div class="new_input_field">
                                                <input type="number" title="Enter The Mobile no  (For Example: 9876543210)" class="required " name="mobile" id="mobile" value="<?php echo $mobile; ?>"  minlength="10" maxlength="15"/>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Address</label>
                                            <span class="star">*</span></td>
                                        <td class="mtb"><div class="new_input_field">
                                                <textarea  title="Enter Address" class="required " name="address" id="address"  rows="4"><?php echo $address; ?></textarea>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Liecence no</label>
                                            <span class="star">*</span></td>
                                        <td class="mtb"><div class="new_input_field">
                                                <input type="text" title="Enter Liecence no" class="required " name="liecence_no" id="liecence_no" value="<?php echo $liecence_no; ?>"  />
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Liecence validity</label>
                                            <span class="star">*</span></td>
                                        <td class="mtb"><div class="new_input_field">
                                                <input type="text" title="Liecence Validity" class="required " name="liecence_validity" id="liecence_validity" value="<?php echo $liecence_validity; ?>"/>
                                            </div></td>
                                    </tr
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Joining Date </label>
                                            <span class="star">*</span></td>
                                        <td class="mtb"><div class="new_input_field">
                                                <input type="text" title="Joining Date" class="required " name="joining_date" id="joining_date" value="<?php echo $joining_date; ?>"/>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Emergency Contact</label>
                                            <span class="star">*</span></td>
                                        <td class="mtb"><div class="new_input_field">
                                                <input type="number" title="Enter The Mobile no  (For Example: 9876543210)"  name="emergency_contact" id="emergency_contact" value="<?php echo $emergency_contact; ?>"  minlength="10" maxlength="15"/>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Liecence Scan</label>
                                            <span class="star">*</span></td>
                                        <td class="mtb"><div class="new_input_field">
                                                <input type="file" title="Licence scan"  name="licence_scan" id="licence_scan" />
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Address Proof Scan</label>
                                            <span class="star">*</span></td>
                                        <td class="mtb"><div class="new_input_field">
                                                <input type="file" title="Address scan"  name="address_proof" id="address_proof" />
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Id Proof Scan</label>
                                            <span class="star">*</span></td>
                                        <td class="mtb"><div class="new_input_field">
                                                <input type="file" title="Id scan"  name="id_proof" id="id_proof" />
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Police Verification Scan</label>
                                            <span class="star">*</span></td>
                                        <td class="mtb"><div class="new_input_field">
                                                <input type="file" title="Police Verification scan"  name="police_verification" id="police_verification" />
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="" class="star">*Required Fields</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2">
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
                                            <br/>
                                            <div class="button dredB">
                                                <input type="reset" value="Reset" title="Reset" style="line-height:13px; background:#dadada; color:#303030;" />
                                            </div>
                                            <div class="button greenB">
                                                <input type="button" class="my_btn" value="submit" onClick="formSubmit('adddriver_form', 'form_result', 'driver_update.php')" title="submit" />
                                            </div>
                                            <div class="clr">&nbsp;</div>
                                            <div class="form_result" id="form_result"></div></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <div class="content_bottom">
                            <div class="bot_left"></div>
                            <div class="bot_center"></div>
                            <div class="bot_rgt"></div>
                        </div>
                    </div>
                </div>
            
        <script>
            $(document).ready(function () {
                $("#liecence_validity").datepicker({
                    dateFormat: 'dd/mm/yy',
                    viewMode: "months",
                    minViewMode: "months",
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(2011, 1 - 1, 1)
                });
                $("#joining_date").datepicker({
                    dateFormat: 'dd/mm/yy',
                    viewMode: "months",
                    minViewMode: "months",
                    changeMonth: true,
                    changeYear: true
                   
                });
            });
        </script>
<?php include '../includes/footer.php'; ?>
    </body>
</html>
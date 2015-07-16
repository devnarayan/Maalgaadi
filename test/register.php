<?php include '../includes/define.php'; ?>

<html><head>
        <?php include '../includes/head.php'; ?>
    </head>
    <body>
        <?php include '../includes/header.php'; ?>

        <!-- General form elements -->
        <div class="widget row-fluid">
            <div class="navbar">
                <div class="navbar-inner">
                    <h6><i class="icon-align-justify"></i>Add Driver</h6>
                </div>
            </div>

            <div class="container_content">

            

                <div class="container_content fl clr">
                    <div class="cont_container mt15 mt10">
                        <div class="content_middle">
                            <form name="adddriver_form" id="adddriver_form" class="form" action="" method="post" enctype="multipart/form-data">
                                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                                    <tr>
                                        <td>Driver Information</td>
                                        <td></td>	          
                                    </tr>          

                                    <tr>
                                        <td valign="top" width="20%"><label>Email</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="text" title="Enter the Driver Name" id="name" class="required" name="email" required value="" minlength="4" maxlength="30" />
                                            </div>
                                        </td>   	
                                    </tr> 
                                    <tr>
                                        <td valign="top" width="20%"><label>Mobile No</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="number" title="Enter The Mobile no  (For Example: 9876543210)" class="required " name="mobile_no" id="mobile"   minlength="10" maxlength="15"/>
                                            </div>
                                        </td>   	
                                    </tr> 
                                    <tr>
                                        <td valign="top" width="20%"><label>devicetoken</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <textarea  title="Enter Address" class="required " name="device_token" id="address"  rows="4"></textarea>
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

                                            <input type="hidden" name="mode" value="new"/>
                                            <div class="button dredB">   <input type="reset" value="Reset" title="Reset" /></div>
                                            <div class="button greenB">  <input type="button" value="submit" onclick="formSubmit('adddriver_form', 'form_result', '../api/register.php')" title="submit" /></div>
                                            <div class="clr">&nbsp;</div>
                                            <div class="form_result" id="form_result"></div>
                                        </td>
                                    </tr> 
                                </table>
                            </form>
                        </div>
                        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
                    </div>
                </div> 

            </div>

        </div>


        <?php include '../includes/footer.php'; ?>
    </body>
</html>
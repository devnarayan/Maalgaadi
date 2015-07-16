<?php include '../includes/define.php'; 

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); /*remember to declare $pass as an array*/
    $alphaLength = strlen($alphabet) - 1; /*put the length -1 in cache*/
    for ($i = 0; $i < 6; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); /*turn the array into a string*/
}


if(isset($_POST['submit']))
{
        $today = date("Y-m-d H:i:s");
               // $_POST['create_at'] = $today;
                 $num=$_POST['no_of_coupon'];
                for($i=0; $i<$num; $i++)
                {

                    $token=randomPassword();
                    
                   $arr['valid_till']= $_POST['valid_till'];
                   $arr['amount']= $_POST['amount'];
                   $arr['status']= 'unused';
                   $arr['coupan_code']= $token;
                   $arr['create_at'] = $today;
                   
                     $result1 = $objConnect->insert('discount_coupan', $arr);
                }
                if ($result1) {

                    header('location:discount_coupon_list.php');
                }
}

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
                    <h6><i class="icon-align-justify"></i>Create Discount Coupons</h6>
                </div>
            </div>
           
                        <div class="content_middle">
                            <form name="addcoupon_form" id="addtaxi_form" class="form" action="discount_coupon.php" method="post" enctype="multipart/form-data">
                                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                                    <tr>
                                        <td colspan="2" class="style_1">Discount Coupons Information</td>

                                    </tr>   
                                    <tr>
                                        <td colspan="2" height="10"></td>
                                    </tr>       
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>No of Coupons</label><span class="star">*</span></td>        
                                        <td class="mtb">

                                            <div class="new_input_field">
                                                <input type="number" title="Enter No of Coupons" id="no_of_coupon" class="required" name="no_of_coupon" required  />
                                            </div>

                                        </td>
                                    </tr>
                                     <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Amount</label><span class="star">*</span></td>        
                                        <td class="mtb">

                                            <div class="new_input_field">
                                                <input type="number" title="Enter Amount" id="amount" class="required" name="amount" required  />
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%" class="mtb"><label>Valid Till</label><span class="star">*</span></td>        
                                        <td class="mtb">
                                            <div class="new_input_field">
                                                <input type="text" title="Enter Valid Till" id="valid_till" class="required" name="valid_till" required  />
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
                                            
                                            <div class="button dredB">   <input type="reset" value="Reset" title="Reset" style="line-height:13px; background:#dadada; color:#303030;" /></div>
                                            <div class="button greenB">  <input type="submit" name="submit" class="my_btn" value="submit"  title="submit" /></div>
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
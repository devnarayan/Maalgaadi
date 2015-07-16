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
                    <a href="<?php echo BASE_URL; ?>discount/view_discount.php" title="<?php echo BASE_URL; ?>">View Customer Cash Receive</a></li>
                <li class="active"><a title="">Add Customer Cash Receive </a></li>
              </ul>
            </div>
        <!-- General form elements -->
        <div class="widget mt15">
            <div class="navbar">
                <div class="navbar-inner">
                    <h6><i class="icon-align-justify"></i>Add Customer Cash Receive</h6>
                </div>
            </div>
            <div class="content_middle">
                <?php
                $customer_id = "";
                $cashreceive_date = "";
                $cash_amount = "";
                $narration = "";
				$customer_organization = '';
                if ((isset($_REQUEST['id'])) && (!empty($_REQUEST['id']))) {
                $id = $_REQUEST['id'];
                $result6 = $objConnect->selectWhere("cashreceive", "id=$id ");
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
                            <form name="adddiscount_form" id="adddiscount_form" class="form" action="" method="post" enctype="multipart/form-data">
                                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                                    <tr>
                                        <td valign="top" width="20%"><label>Customer Name</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <input type="text" value="<?php echo $customer_name; ?>" title="Enter the first name with atleast 3 character" name="firstname" id="firstname" value=""  minlength="3"  placeholder="First Name"  autocomplete="off" />
                                                <input name="customer_id" id="customer_id" type="hidden" value="<?php echo $customer_id; ?>">
                                                <br/>
                                                 <span>Customer Name will Work if it will select from the list provided</span>
                                            </div>
                                        </td>   	
                                    </tr> 
                                    <tr>
                                        <td valign="top" width="20%"><label>Customer Organization</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field ">

                                                <input type="text" title="Enter The Customer Organization" readonly class="required " value="<?php echo $customer_organization; ?>" name="customer_organization" id="customer_organization"   />

                                            </div>
                                        </td>   	
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>Cash Receive Date</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field ">

                                                <input type="text" title="Enter The Cash Receive Date" class="required " value="<?php echo $cashreceive_date; ?>" name="cashreceive_date" id="cashreceive_date"   />

                                            </div>
                                        </td>   	
                                    </tr> 
                                    <tr>
                                        <td valign="top" width="20%"><label>Cash Receive Amount</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field ">

                                                <input type="text" title="Enter The Cash Receive Amount" class="required " value="<?php echo $cash_amount; ?>" name="cash_amount" id="cash_amount"   />

                                            </div>
                                        </td>   	
                                    </tr> 
                                    <tr>
                                        <td valign="top" width="20%"><label>Narration</label><span class="star">*</span></td>        
                                        <td>
                                            <div class="new_input_field">
                                                <textarea placeholder="Enter The Narration...!" class="required"  name="narration" id="narration"><?php echo $narration; ?></textarea>
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
                                          
                                            <div class="button dredB">   <input type="reset" value="Reset" title="Reset" /></div>
                                            <div class="button greenB">  <input type="button" value="submit" onClick="formSubmit('adddiscount_form', 'form_result', 'casheeceive_update.php')" title="submit" /></div>
                                            <div class="clr">&nbsp;</div>
                                            <div class="form_result" id="form_result"></div>
                                        </td>
                                    </tr> 
                                </table>
                            </form>
                        </div>
                        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
                    </div>
               <!--dtat tabl-->
    <script>
            $(document).ready(function () {
                $("#cashreceive_date").datepicker({
                    dateFormat: 'yy/mm/dd',
                    viewMode: "months",
                    minViewMode: "months",
                    changeMonth: true,
                    changeYear: true,
                    //minDate: new Date(2011, 1 - 1, 1)
                    minDate: new Date()
                });
               
                 $.ui.autocomplete.prototype._renderItem = function (ul, item) {
                  var data = item.customer_name + ", " + item.customer_email;
                  var re = new RegExp("(" + data + ")", "gi");
                  var t = data.replace(re, "<strong>$1</strong>");
                  return $("<li></li>").data("item.autocomplete", item)
                                       .append("<a>" + data + "</a>")
                                       .appendTo(ul);
                                    };
                                    $("#firstname").autocomplete({
                                        source: '../booking/booking_update.php?mode=autocompleteFirstname',
                                        select: function (event, ui) {
                                            console.log(ui.item.id);
                                            $('#customer_id').val(ui.item.id);
                                            $('#firstname').val(ui.item.customer_name);
											$('#customer_organization').val(ui.item.customer_organization);
                                            return false;
                                        },
                                        minLength: 1
                                    });
            });
        </script>


        <?php include '../includes/footer.php'; ?>
    </body>
</html>
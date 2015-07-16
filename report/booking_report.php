<?php
include '../includes/define.php';
verifyLogin();
?>
<html>
    <head>
        <?php include '../includes/head.php'; ?>
        <style>
            #footer{
                bottom:0 !important;  
            }
        </style>
    </head>
    <body data-base="<?php echo BASE_URL; ?>">
        <?php include '../includes/header.php'; ?>

        <div class="crumbs">
            <ul id="breadcrumbs" class="breadcrumb">
                <li>
                    <a href=<?php echo BASE_URL; ?>admin/dashboard title=<?php echo BASE_URL; ?>admin/dashboard>Home</a>		                </li>
                <li class="active"><a title="">Booking List</a></li>
            </ul>
        </div>

        <div class="content_middle mt15">   
            <form method="get" action="booking_search.php" id="reportSearch">
            <table border="0" cellpadding="5" cellspacing="0" width="100%">
                <tr>
                    <td colspan="4" class="style_1">Booking Report</td>
                </tr>   
                <tr>
                    <td colspan="4" height="10"></td>
                </tr>  
                <tr>
                    <td valign="top" width="20%" class="mtb">
                        Customer name
                    </td>
                    <td colspan="3">
                         <div class="new_booking_field ">
                                    <input type="text" title="Enter the first name with atleast 3 character" name="firstname" id="firstname" value=""  minlength="3"  placeholder="First Name"  autocomplete="off" />
                                    <input name="customer_id" id="customer_id" type="hidden" >
                                    <br>
                                    
                                </div>
                        <span>Customer Name will Work if it will select from the list provided</span>
                    </td>
                </tr>
                <tr>
                    <td valign="top" width="20%" class="mtb"><label>Customer Organization</label><span class="star"></span></td>        
                    <td class="mtb">
                        <div class="new_input_field">
                            <div class="new_input_field">
                                <select  name="customer_organization" id="customer_organization" onchange="if (this.value == '') {
                                                            $('#other').show();
                                                        } else {
                                                            $('#other').hide();
                                                            $('#other').val('');
                                                        }">
                                    <option value=""> All Organization </option>
                                    <?php
                                    $sql1 = "select distinct customer_organization from customer where customer_organization!=''";
                                    $result1 = mysql_query($sql1) or die(mysql_error());
                                    while ($row1 = mysql_fetch_assoc($result1)) {
                                        ?>
                                        <option value="<?php echo $row1['customer_organization'] ?>" ><?php echo $row1['customer_organization']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td valign="top" width="20%" class="mtb"><label>Status</label><span class="star">*</span></td>        
                    <td class="mtb">
                        <div class="new_input_field">
                                <select name="status">
                                    <option value="">All</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Canceled">Canceled</option>
                                    <option value="In Transit">In Transit</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td valign="top" width="20%" class="mtb"><label>Start Date</label><span class="star">*</span></td>        
                    <td class="mtb">
                        <div class="new_input_field">
                            <input type="text" title="Satrt Date From the booking should be search" id="startDate" name="startDate" readonly />
                        </div>
                    </td>
                     <td valign="top" width="20%" class="mtb"><label>End Date</label><span class="star">*</span></td>        
                    <td class="mtb">
                        <div class="new_input_field">
                            <input type="text" title="End Date To the booking should be search" id="endDate" name="endDate" readonly />
                        </div>
                    </td>
               
                </tr>
                <tr>
                    
                    
                </tr>
                    <tr>
                <td>&nbsp;</td>
                                        <td colspan="2">
                                            
                                            <div class="button dredB">   <input type="reset" value="Reset" onclick="$('#searchResult').html('');" title="Reset" style="line-height:13px; background:#dadada; color:#303030;" /></div>
                                            <div class="button greenB">  <input type="button" class="my_btn" value="Search" title="submit" onclick="formSubmit('reportSearch','searchResult','booking_search.php')" /></div>
                                            <div class="clr">&nbsp;</div>
                                           
                                        </td>
                </tr>
            </table>
        </form>
            
            <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
        </div>
<div class="searchResult" id="searchResult"></div>
        <script src="<?php echo BASE_PATH; ?>js/jquery.dataTables.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>css/jquery.dataTables.css">
    <!--dtat tabl-->
    <script>
            $(document).ready(function () {
                $("#startDate").datepicker({
                    dateFormat: 'dd/mm/yy',
                    showOtherMonths: true,
                    changeMonth: true,
                    changeYear: true


                });
                $("#endDate").datepicker({
                    dateFormat: 'dd/mm/yy',
                    showOtherMonths: true,
                    changeMonth: true,
                    changeYear: true

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
                                            return false;
                                        },
                                        minLength: 1
                                    });
            });
        </script>
    <style>
        tfoot {
            display: table-header-group;

        }
    </style>

<?php include '../includes/footer.php'; ?>
</body>
</html>
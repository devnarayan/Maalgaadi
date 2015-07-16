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
                    <a  href=<?php echo BASE_URL; ?>admin/dashboard title=<?php echo BASE_URL; ?>admin/dashboard>Home</a>		                </li>
                <li class="active"><a title="">Booking List</a></li>
            </ul>
        </div>
<?php
$startDat=(isset($_POST["startDate"])?$_POST["startDate"]:"");
$endDat=(isset($_POST["endDate"])?$_POST["endDate"]:"");
?>
        <div class="content_middle mt15">   
            <form method="get"  id="reportSearch1">
            <table border="0" cellpadding="5" cellspacing="0" width="100%">
                <tr>
                    <td colspan="3" class="style_1">Booking Report</td>
                    <td>
                        <a id="exportData" href="" target="_blank">
<button type="button" name="button" value="Download Excel" class="btn btn-xl btn-info">
<span> Download Excel <br></span>
</button>
</a>
                        
                    </td>
                </tr>   
                <tr>
                    <td colspan="4" height="10"></td>
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
                                            <div class="button greenB">  <input type="button" class="my_btn" value="Search" title="submit" onclick="formSubmitt('reportSearch1','searchResult','booking_search_daily.php'),onsendData()" /></div>
                                            <div class="clr">&nbsp;</div>
                                           
                                        </td>
                </tr>
            </table>
        </form>
            
            <div class="content_bottom">
                <div class="bot_left"></div>
                <div class="bot_center"></div>
                <div class="bot_rgt"></div>
                    
            </div>
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
            
            function onsendData()
            {
               var startDat = $('#startDate').val();
               var endDat = $('#endDate').val();
               $("#exportData").attr("href", "print_report_list_excel.php?endDat="+endDat+"&startDat="+startDat);
            }
            
        </script>
    <style>
        tfoot {
            display: table-header-group;

        }
    </style>

<?php include '../includes/footer.php'; ?>
</body>
</html>
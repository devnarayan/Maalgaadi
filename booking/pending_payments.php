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
                    <td valign="top" width="20%" class="mtb"><label>Customer Organization</label><span class="star">*</span></td>        
                    <td class="mtb">
                        <div class="new_input_field">
                            <div class="new_input_field">
                                <select  name="customer_organization" id="customer_organization" onchange="if (this.value == '') {
                                                            $('#other').show();
                                                        } else {
                                                            $('#other').hide();
                                                            $('#other').val('');
                                                        }">
                                    <option value=""> No Filter </option>
                                    <?php
                                    $sql1 = "select * from organization ";
                                    $result1 = mysql_query($sql1) or die(mysql_error());
                                    while ($row1 = mysql_fetch_assoc($result1)) {
                                        ?>
                                        <option value="<?php echo $row1['id'] ?>" ><?php echo $row1['name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td valign="top" width="20%" class="mtb"><label></label><span class="star"></span></td>        
                    <td class="mtb">
                       
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
        <div class="searchResult" id="searchResult">  
            <table class="table table-bordered table-striped table-condensed ">
                <tr>
                    <th>Booking Id</th>
                    <th>Customer name </th>
                    <th>Phone </th>
                    <th>Organization</th>
                    <th>Start</th>
                    <th>Destination</th>
                    <th>Pickup date</th>
                    <th>Amount</th>
                    <th>Payment Type</th>
                    <th>Payment</th>
                    <th>Balance</th>
                    <th>Pay</th>
                </tr>
                <?php
                $search1 = "";
                if ((isset($_POST['customer_organization'])) && (!empty($_POST['customer_organization']))) {
                    $search1 = " and customer_organization like '" . $_POST['customer_organization'] . "'";
                }
                $search2 = "";
                if ((isset($_POST['startDate'])) && (!empty($_POST['startDate']))) {
                    $date1 = changeFormat("d/m/Y", "Y-m-d 00:00:00", $_POST['startDate']);
                    $search2 = " and pickup_date >= '" . $date1 . "'";
                }
                $search3 = "";
                if ((isset($_POST['endDate'])) && (!empty($_POST['endDate']))) {
                    $date2 = changeFormat("d/m/Y", "Y-m-d 23:59:59", $_POST['endDate']);
                    $search3 = " and pickup_date <= '" . $date2 . "'";
                }
                $search4 = "";
                if ((isset($_POST['status'])) && (!empty($_POST['status']))) {
                    if ($_POST['status'] == "Completed") {
                        $search4 = " and booking.status==7";
                    } elseif ($_POST['status'] == "Pending") {
                        $search4 = " and booking.status>=-3 and booking.status<2";
                    } elseif ($_POST['status'] == "Canceled") {
                        $search4 = " and booking.status==99 ";
                    } elseif ($_POST['status'] == "In Transit") {
                        $search4 = " and booking.status>=2 and booking.status<7";
                    }
                }
                $total_amount = 0;
                $total_estimate = 0;
                $total_payment = 0;
                $total_balance = 0;

                $sql = "select booking.*, booking_short.distance_to_customer as to_customer,customer.customer_name,customer.customer_organization, booking_short.trip_time,booking_short.trip_distance,booking_short.payment_type,booking_short.payment,booking_short.total_payment_amount,booking_short.balance,booking_short.booking_type from booking inner join customer on customer.id=booking.customer_id left join booking_short on booking.id=booking_short.booking_id where booking.status=7 and booking_short.balance!=0 $search1 and booking.city_id='".$_SESSION['dash_city']."'";
                $result = $objConnect->execute($sql);
                $num = mysql_num_rows($result);
                while ($row = $objConnect->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo sprintf("%07d", $row['id']); ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['pick_up_no']; ?></td>
                        <td><?php echo $row['customer_organization']; ?></td>
                        <td><?php echo $row['current_location']; ?></td>
                        <td><?php echo $row['drop_location']; ?></td>
                        <td><?php echo date("d M Y h:i a", strtotime($row['pickup_date'])); ?></td>
                        <td><?php if ($row['total_payment_amount'] == "") {
                    echo $row['total_fare'] . " Estimated";
                    $total_estimate = $total_estimate + $row['total_fare'];
                } else {
                    echo $row['total_payment_amount'];
                    $total_amount = $total_amount + $row['total_payment_amount'];
                } ?></td>
                        <td><?php echo $row['payment_type']; ?></td>
                        <td><?php echo $row['payment'];
                $total_payment = $total_payment + $row['payment']; ?></td>
                        <td><?php echo $row['balance'];
                $total_balance = $total_balance + $row['balance']; ?></td>
                        <td><a href="payment.php?booking=<?php echo $row['id']; ?>" class="btn btn-success">Pay</a></td>
                    </tr>
    <?php
}
?>
                <th colspan="2">Total- <?php echo $num; ?> Bookings</th>

                <th colspan="4">Pending And transit booking total: <?php echo $total_estimate; ?></th>
                <th colspan="4"> Completed Booking Total: <?php echo $total_amount; ?></th>


                <th colspan="2">Payments: <?php echo $total_payment; ?><br/>
                    Balance: <?php echo $total_balance; ?></th>

            </table>

            
        </div>

        <script src="<?php echo BASE_PATH; ?>js/jquery.dataTables.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>css/jquery.dataTables.css">
    <!--dtat tabl-->
    <style>
        tfoot {
            display: table-header-group;

        }
    </style>
    <script>

        $(document).ready(function () {

            $('#example thead th:first-child').each(function () {
                var title = $('#example thead th:first-child').eq($(this).index()).text();
                $(this).html('<input type="text" style="width:60px;" placeholder="Book Id" />');
            });
            $('#example thead th:nth-child(2)').each(function () {
                var title = $('#example thead th:nth-child(2)').eq($(this).index()).text();
                $(this).html('<input type="text" style="width:80px;" placeholder="name" />');
            });
            $('#example thead th:nth-child(3)').each(function () {
                var title = $('#example thead th:nth-child(3)').eq($(this).index()).text();
                $(this).html('<input type="text"  placeholder="Emai" />');
            });
            $('#example thead th:nth-child(4)').each(function () {
                var title = $('#example thead th:nth-child(4)').eq($(this).index()).text();
                $(this).html('<input type="text" style="width:80px;" placeholder="Mobile" />');
            });
            var table = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "booking_data.php",
                "order": [[6, "desc"]]

            });
            // Apply the search
            table.columns().eq(0).each(function (colIdx) {
                $('input', table.column(colIdx).header()).on('keyup change', function () {
                    table
                            .column(colIdx)
                            .search(this.value)
                            .draw();
                });
            });
        });


    </script>
<?php include '../includes/footer.php'; ?>
</body>
</html>
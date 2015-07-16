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
        <div class="container_content">
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li>
                        <a href=<?php echo BASE_URL; ?> title=<?php echo BASE_URL; ?>>Home</a>	
                    </li>
                    <li>
                        <a href=booking_list.php title=<?php echo BASE_URL; ?>booking/booking_list.php>Booking List</a>
                    </li>
                    <li class="active"><a title="">Booking Detail</a></li>
                </ul>
            </div>
            <div class="cont_container mt15 mt10">
                <div class="content_middle"> 
                    <?php
                    $id = $_GET['booking'];
                    $result = $objConnect->selectWhere("booking", "id=$id");
                    $row = $objConnect->fetch_assoc();
                    ?>
                    <!-- Start Book-Now -->
                    <div class="banner">
                        <h2>
                            Booking Detail
                        </h2>
                    </div>
                    <div style="width:100%">
                        <div class="container">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="my-booking">
                                        <div class="row-fluid">
                                            <div class="span9">
                                                <div class="book-sec-1">
                                                    <div class="row space2">
                                                        <div class="span6">
                                                            <div class="field-1">
                                                                <h6>Booking no</h6>
                                                                <p> <?php echo sprintf("%07d", $row['id']); ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="span6">
                                                            <div class="field-1">
                                                                <h6>Last Status</h6>
                                                                <p> <span id="order"></span> Traveled till now.<br/>
                                                                    <span id="lastseen"></span> </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row space2">
                                                        <div class="span6">
                                                            <div class="field-1">
                                                                <h6>Date & Time</h6>
                                                                <p> <?php echo $row['pickup_date']; ?> </p>
                                                            </div>
                                                        </div>
                                                        <div class="span6">
                                                            <div class="field-1">
                                                                <h6>Contact No.</h6>
                                                                <p> <?php echo $row['phone']; ?> </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row space2">
                                                        <div class="span6">
                                                            <div class="field-1">
                                                                <h6>Pick up Address</h6>
                                                                <p> <?php echo $row['current_location']; ?> </p>
                                                            </div>
                                                        </div>
                                                        <div class="span6">
                                                            <div class="field-1">
                                                                <h6>Destination Address</h6>
                                                                <p> <?php echo $row['drop_location']; ?> </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row space2">
                                                        <div class="span6">
                                                            <div class="field-1">
                                                                <h6>Date & Time</h6>
                                                                <p> <?php echo $row['pickup_date']; ?> </p>
                                                            </div>
                                                        </div>
                                                        <div class="span6">
                                                            <div class="field-1">
                                                                <h6>Contact No.</h6>
                                                                <p> <?php echo $row['phone']; ?> </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row space2">
                                                        <div class="span6">
                                                            <div class="field-1">
                                                                <h6>Pick up Landmark</h6>
                                                                <p> <?php echo $row['pick_up_landmark']; ?> </p>
                                                            </div>
                                                        </div>
                                                        <div class="span6">
                                                            <div class="field-1">
                                                                <h6>Destination Landmark</h6>
                                                                <p> <?php echo $row['drop_landmark']; ?> </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row space2">
                                                        <div class="span6">
                                                            <div class="field-1">
                                                                <h6>Chosen Vehicle</h6>
                                                                <p> <?php
                                                                    $result1 = $objConnect->selectWhere('vehicle_category', "id=" . $row['vehicle']);
                                                                    $row1 = $objConnect->fetch_assoc();
                                                                    echo $row1['name'];
                                                                    ?> </p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="span3">
                                                <div class="book-sec-2">
                                                    <div class="row-fluid">
                                                        <div class="span12">
                                                            <div class="cols1">
                                                                <p class="txt-style-5"> <span class="style2" id="totalfare">Rs.<?php echo $row['total_fare']; ?>/-</span><br/>
                                                                    <strong>Base Fare</strong>: Rs <?php echo $row['model_minfare']; ?> & Rs<?php echo $row['firstten']; ?>  Per km<br/>
                                                                    <strong>Fare post 10 kms</strong>: Rs.<?php echo $row['rate']; ?> per km<br/>
                                                                    <?php if ($row['loading']) { ?><strong>Loading Charge</strong>: Rs.<?php echo $row['loading_charge']; ?> <br/><?php } ?>
                                                                    <?php if ($row['unloading']) { ?><strong>Un Loading Charge</strong>: Rs.<?php echo $row['loading_charge']; ?> <br/><?php } ?>
                                                                    <strong>Distance</strong>: <?php echo $row['distance_km']; ?> Km <br/>
                                                                    <strong>Trip charge</strong>: Rs.<?php echo $row['trip_fare']; ?> </p>
                                                            </div>
                                                            <div class="cols2 truck"> <img src="../uploads/<?php echo $row1['image'] ?>" alt="" title="" width="150px" onerror="this.src='../images/no-image.png'" /> </div>


                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>

                                        <div class="row-fluid">
                                            <div class="span12"> 
                                                <table class="table table-striped table-bordered">
                                                    <tr><th>Status</th><th>time</th></tr>
                                                    <?php
                                                    $result2 = $objConnect->selectWhere("booking_logs", "booking_id=$id group by status order by datetime asc");
                                                    while ($row2 = $objConnect->fetch_assoc()) {
                                                        ?>
                                                        <tr><td><?php
                                                                if ($row2['status'] == "start to customer") {
                                                                    echo "Moving towards customer";
                                                                } elseif ($row2['status'] == "reached to customer") {
                                                                    echo "At Pickup location";
                                                                } elseif ($row2['status'] == "start loading") {
                                                                    echo "loading goods";
                                                                } elseif ($row2['status'] == "stop loading") {
                                                                    echo "Goods Loaded ";
                                                                } elseif ($row2['status'] == "start trip") {
                                                                    echo "Running towards destination";
                                                                } elseif ($row2['status'] == "stop trip") {
                                                                    echo "Reached To Destination";
                                                                } elseif ($row2['status'] == "start unloading") {
                                                                    echo "Unloading Goods";
                                                                } elseif ($row2['status'] == "stop unloading") {
                                                                    echo "Goods Unloaded and processing for payment";
                                                                } elseif ($row2['status'] == "complete booking") {
                                                                    echo "Booking completed";
                                                                } else {
                                                                    echo $row2['status'];
                                                                }
                                                                ?></td><td><?php echo date('d/m/Y H:i:s', strtotime($row2['datetime'])); ?></td></tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row-fluid row-border mt15">
                                            <div class="span12">
                                                <table class="table table-bordered table-striped ">
                                                    <thead>
                                                        <tr>
                                                            <th>Distance To customer</th>
                                                            <th>Trip Time</th>
                                                            <th>Trip Distance</th>
                                                            <th>Payment Type</th>
                                                            <th>Total Amount </th>
                                                            <th>Payment </th>
                                                            <th>Balance </th>
                                                            <th>Booking Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $result3 = $objConnect->selectWhere("booking_short", "booking_id=$id");
                                                        while ($row3 = $objConnect->fetch_assoc()) {
                                                            ?>
                                                        <tr>
                                                    <td><?php echo $row3['distance_to_customer'];?></td>
                                                    <td><?php echo $row3['wait_time'];?> min <script >$("#totalfare").html("Rs. <?php echo $row3['total_payment_amount'];?>");</script></td>
                                                    <td><?php echo $row3['trip_distance'];?></td>
                                                    <td><?php echo $row3['payment_type'];?></td>
                                                    <td><?php echo $row3['total_payment_amount'];?></td>
                                                    <td><?php echo $row3['payment'];?></td>
                                                    <td><?php echo $row3['balance'];?></td>
                                                    <td><?php echo $row3['booking_type'];?></td>
                                                        </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>

                    <style>
                        #map-canvas {
                            height: 400px;
                            margin: 0px;
                            padding: 0px
                        }
                    </style>
                    <!-- End Book-Now -->
                </div>
                <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
            </div>

        </div>
        <?php include '../includes/footer.php'; ?>
    </body>
</html>
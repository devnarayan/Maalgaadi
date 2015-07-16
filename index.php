<?php
require './includes/define.php';
verifyLogin();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include './includes/head.php'; ?>
    </head>
    <body data-base="<?php echo BASE_URL; ?>">
        <?php include './includes/header.php'; ?>

       

        <!-- General form elements -<div class="widget row-fluid">-->
       
           
            <!--<div class="container_content">--> 

              
                <form id="dashboard">
                <div class="widget chartWrapper">
<!--                    <div class="title"> <img src="<?php echo BASE_URL; ?>images/stats.png" alt="" class="titleIcon" />
                            <h6>Drivers</h6>
                        </div>-->
                    <div class="body">
                    <div id="map-canvas" class="boookingpagegraph"></div>
                    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBIkQyG2nXYEVIOt3cce94TEdWDVuBG7MY&signed_in=true" type="text/javascript"></script>
<!--                  <script src="js/markerclusterer.js"></script>-->
                  <script src="js/oms.js"></script>
                    <script src="js/maps.js"></script>
                    
                    </div>
<!--                </div>
                </form>-->
                  <!-- Action tabs -->
                <div class="actions-wrapper">
                
                    <div class="actions">
                        <div id="user-stats">
                            <ul class="round-buttons">
                                <li>
                                    <div class="depth"><a href="<?php echo BASE_URL; ?>vehicle/vehicle.php" title="Add Vehicle" class="tip"><i class="fa fa-taxi"></i></a></div>
                                    <span class="rapid_title">Vehicle</span> </li>
                                <li>
                                    <div class="depth"><a href="<?php echo BASE_URL; ?>booking/booking.php" title="Add Booking" class="tip"><i class="fa fa-trello"></i></a></div>
                                    <span class="rapid_title">Bookings</span> </li>
                                <li>
                                    <div class="depth"><a href="<?php echo BASE_URL; ?>employee/employee_list.php" title="Employee Management " class="tip"><i class="fa fa-users"></i></a></div>
                                    <span class="rapid_title">Employee</span></li>
                                <li>
                                    <div class="depth"><a href="<?php echo BASE_URL; ?>/settlement/driver_remaining.php" title="Settlement" class="tip"><i class="fa fa-wrench"></i></a></div>
                                    <span class="rapid_title">Settlement </span> </li>
                            </ul>
                        </div>
                        <div id="quick-actions">
                            <ul class="statistics">
                                <li>
                                    <div class="top-info"> <a href="<?php echo BASE_URL; ?>customer/customer_list.php" title="TOTAL CUSTOMERS" class="blue-square"><i class="fa fa-users"></i></a> <strong><?php  echo $objConnect->getcount('customer',"1 and city_id='".$_SESSION['dash_city']."'");?></strong> </div>
                                    <div class="progress progress-micro">
                                        <div class="bar" style="width: 60%;"></div>
                                    </div>
                                    <span class="rapid_title">TOTAL CUSTOMERS</span> </li>
                                <li>
                                    <div class="top-info"> <a href="<?php echo BASE_URL; ?>vehicle/vehicle_list.php" title="TOTAL Vehicle" class="red-square"><i class="fa fa-taxi"></i></a> <strong><?php  echo $objConnect->getcount('vehicle',"1 and city_id='".$_SESSION['dash_city']."'");?></strong> </div>
                                    <div class="progress progress-micro">
                                        <div class="bar" style="width: 20%;"></div>
                                    </div>
                                    <span class="rapid_title">TOTAL VEHICLE</span> </li>
                                <li>
                                    <div class="top-info"> <a href="<?php echo BASE_URL; ?>vehicle/driver_list.php" title="TOTAL DRIVERS" class="purple-square"><i class="fa fa-suitcase"></i></a> <strong><?php  echo $objConnect->getcount('driver',"1 and city_id='".$_SESSION['dash_city']."'");?></strong> </div>
                                    <div class="progress progress-micro">
                                        <div class="bar" style="width: 90%;"></div>
                                    </div>
                                    <span class="rapid_title">TOTAL DRIVERS</span> </li>
                                <li>
                                    <div class="top-info"> <a href="<?php echo BASE_URL; ?>booking/booking_list.php" title="TOTAL Bookings" class="green-square"><i class="fa fa-user"></i></a> <strong><?php  echo $objConnect->getcount('booking',"status<=7 and status>-4 and city_id='".$_SESSION['dash_city']."'");?></strong> </div>
                                    <div class="progress progress-micro">
                                        <div class="bar" style="width: 70%;"></div>
                                    </div>
                                    <span class="rapid_title">TOTAL BOOKINGS</span> </li>
                                <li>
                                    <div class="top-info"> <a href="<?php echo BASE_URL; ?>booking/booking_list.php" title="Pending Booking " class="sea-square"><i class="fa fa-trello"></i></a> <strong><?php  echo $objConnect->getcount('booking',"status<2 and status>-4 and city_id='".$_SESSION['dash_city']."'");?></strong> </div>
                                    <div class="progress progress-micro">
                                        <div class="bar" style="width: 50%;"></div>
                                    </div>
                                    <span class="rapid_title">Pending Bookings</span> </li>
                                <li>
                                    <div class="top-info"> <a href="<?php echo BASE_URL; ?>booking/booking_list.php" title="In Transit Booking" class="sea-square"><i class="fa fa-book"></i></a> <strong><?php  echo $objConnect->getcount('booking',"status<7 and status>1 and city_id='".$_SESSION['dash_city']."'");?></strong> </div>
                                    <div class="progress progress-micro">
                                        <div class="bar" style="width: 50%;"></div>
                                    </div>
                                    <span class="rapid_title">Running Booking </span> </li>
<!--                                <li>
                                    <div class="top-info"> <a href="<?php echo BASE_URL; ?>manage/Vehicle" title="TOTAL VehicleES" class="sea-square"><i class="fa fa-bar-chart"></i></a> <strong>1</strong> </div>
                                    <div class="progress progress-micro">
                                        <div class="bar" style="width: 50%;"></div>
                                    </div>
                                    <span class="rapid_title">REPORTS </span> </li>-->
                            </ul>
                        </div>
                        <div id="map">
                            <ul class="dashboard_report_tab">
                                <li>
                                    <div class="top-info"> <a href="<?php echo BASE_URL; ?>report/booking_report.php" title="Booking Reports"> <img src="<?php echo BASE_URL; ?>images/edit-notes.png" class="image" alt="Unassigned Vehiclees Today"  /> <br>
                                            <span class="rapid_title"> Booking Report</span> </a> </div>
                                </li>
                                <li>
                                    <div class="top-info"> <a href="<?php echo BASE_URL; ?>settlement/driver_payment.php" title="Payments"> <img src="<?php echo BASE_URL; ?>images/edit-notes.png" class="image" alt="Unassigned Vehiclees Today"  /> <br>
                                            <span class="rapid_title"> Vehicle Payment </span> </a> </div>
                                </li>
<!--                                <li>
                                    <div class="top-info"> <a href="#free_Vehicle" title="Free Vehiclees Today"> <img src="<?php echo BASE_URL; ?>images/taxi.png" class="image" alt="Free Vehiclees Today"  /> <br>
                                            <span class="rapid_title"> 0 Free Vehicles Today </span> </a> </div>
                                </li>
                                <li>
                                    <div class="top-info"> <a href="#free_drivers" title="Unassigned Drivers Today"> <img src="<?php echo BASE_URL; ?>images/driver.png" class="image" alt="Unassigned Drivers Today"  /> <br>
                                            <span class="rapid_title"> 4 Unassigned Drivers Today </span> </a> </div>
                                </li>
                                <li>
                                    <div class="top-info"> <a href="#liveuser" title="Live Passengers"> <img src="<?php echo BASE_URL; ?>images/manager.png" class="image" alt="Live Passengers"  /> <br>
                                            <span class="rapid_title"> 2										Live Passengers </span> </a> </div>
                                </li>-->
                            </ul>
                        </div>
                        <ul class="action-tabs">
                            <li><a href="#quick-actions" title="">Statistics</a></li>
                            <li><a href="#user-stats" title="">Rapid Access</a></li>
                            <li><a href="#map" title="" id="map-link">Reports</a></li>
                        </ul>
                    </div>
                   
                    
                </div>
                <!-- /action tabs --> 
                
                <!-- Chart -->
                
                    
<!--                    <div class="widget chartWrapper">
                        <div class="title"> <img src="<?php echo BASE_URL; ?>images/stats.png" alt="" class="titleIcon" />
                            <h6>Customer's Chart</h6>
                        </div>
                        <div class="body">
                            <div class="chart" id="container_userchart"></div>
                        </div>
                    </div>

                     Company User Details 
                    <div class="widget chartWrapper">
                        <div class="title"><img src="<?php echo BASE_URL; ?>images/stats.png" alt="" class="titleIcon" />
                            <h6>Drivers Chart</h6>
                            <div class="title">
                                <div class="one">Start date
                                    <input type="text"  readonly title="Select the date and time"  id="userstartdate" name="userstartdate" value=""  />
                                    <span id="startdate_error" class="errors" style="display:none;"></span> End date
                                    <input type="text"  readonly title="Select the date and time"  id="userenddate" name="userenddate" value=""  />
                                    <span id="enddate_error" class="errors" style="display:none;"></span>
                                    <div class="button blackB">
                                        <input type="button" name="change_usercompany" id="change_usercompany" value="GO" title="Go" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="chart" id="user_company" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
                        </div>
                    </div>
                     Company User Details  
                     Company User Details 
                    <div class="widget chartWrapper">
                        <div class="title"><img src="<?php echo BASE_URL; ?>images/stats.png" alt="" class="titleIcon" />
                            <h6>Booking Chart</h6>
                            <div class="title">
                                <div class="one">Start date
                                    <input type="text"  readonly title="Select the date and time"  id="userstartdate" name="userstartdate" value=""  />
                                    <span id="startdate_error" class="errors" style="display:none;"></span> End date
                                    <input type="text"  readonly title="Select the date and time"  id="userenddate" name="userenddate" value=""  />
                                    <span id="enddate_error" class="errors" style="display:none;"></span>
                                    <div class="button blackB">
                                        <input type="button" name="change_usercompany" id="change_usercompany" value="GO" title="Go" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="chart" id="booking_chart" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
                        </div>
                    </div>

                    <div class="widget chartWrapper">
                        <div class="title"><img src="<?php echo BASE_URL; ?>images/stats.png" alt="" class="titleIcon" />
                            <h6>Employee's Chart</h6>
                            <div class="title">
                                <div class="one">Start date
                                    <input type="text"  readonly title="Select the date and time"  id="transtartdate" name="transtartdate" value=""  />
                                    <span id="transtartdate_error" class="errors" style="display:none;"></span> End date
                                    <input type="text"  readonly title="Select the date and time"  id="tranenddate" name="tranenddate" value=""  />
                                    <span id="tranenddate_error" class="errors" style="display:none;"></span>
                                    <div class="button blackB">
                                        <input type="button" name="change_transcompany" id="change_transcompany" value="GO" title="Go" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="chart" id="transaction_company" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
                        </div>
                    </div>
                     Company Transaction Details  

                     Company Account Details  

                     Company Account Details 

                    <div class="widgets" id="liveuser">
                        <div class="oneTwo" > 
                             Login Users widget 
                            <div class="widget" >
                                <div class="title"><img src="<?php echo BASE_URL; ?>images/add.png" alt="" class="titleIcon" />
                                    <h6>Live Customers</h6>
                                </div>
                                <table cellpadding="0" cellspacing="0" width="100%" class="sTable" >
                                    <thead>
                                        <tr>
                                            <td width="80">Name</td>
                                            <td width="80">Last login</td>
                                            <td width="80">Phone</td>
                                            <td width="80">Address</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center"><a href="<?php echo BASE_URL; ?>manage/passengerinfo/9" title="asdfg" >asdfg</a></td>
                                            <td><span>2014-06-16 05:40:02</span></td>
                                            <td><span >9111111111</span></td>
                                            <td><span >Indore, M.P.</span></td>
                                        </tr>
                                        <tr>
                                            <td align="center"><a href="<?php echo BASE_URL; ?>manage/passengerinfo/3" title="manoj" >manoj</a></td>
                                            <td><span>2014-05-08 02:30:35</span></td>
                                            <td><span >8888888888</span></td>
                                            <td><span >Indore, M.P.</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                             Available Vehiclees widget 
                            <div class="widget" id="free_Vehicle">
                                <div class="title"><img src="<?php echo BASE_URL; ?>images/add.png" alt="" class="titleIcon" />
                                    <h6>Today Free </h6>
                                </div>
                                <table cellpadding="0" cellspacing="0" width="100%" class="sTable" >
                                    <thead>
                                        <tr>
                                            <td width="80">Vehicle No</td>
                                            <td width="80">Company Name</td>
                                            <td width="80">Driver Name</td>
                                            <td width="80">Driver phone number</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="4" align="center"> No Data Found!</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                             Free Vehiclees widget 
                            <div class="widget" id="free_Vehiclees">
                                <div class="title"><img src="<?php echo BASE_URL; ?>images/add.png" alt="" class="titleIcon" />
                                    <h6>Today Assigned Vehicles</h6>
                                </div>
                                <table cellpadding="0" cellspacing="0" width="100%" class="sTable" >
                                    <thead>
                                        <tr>
                                            <td width="80">Vehicle No</td>
                                            <td width="80">Vehicle Name</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center"><a href="<?php echo BASE_URL; ?>manage/Vehicleinfo/9" title="" >MP-11-MC-7156</a></td>
                                            <td align="center"><a href="<?php echo BASE_URL; ?>manage/companydetails/2" title="" > <img   width="32" height="32" src="<?php echo BASE_URL; ?>images/2.png"/> <br/>
                                                    Tata-Ace</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="oneTwo" > 

                             Free Drivers widget 
                            <div class="widget" id="free_drivers">
                                <div class="title"><img src="<?php echo BASE_URL; ?>images/add.png" alt="" class="titleIcon" />
                                    <h6>Today Assigned Drivers</h6>
                                </div>
                                <table cellpadding="0" cellspacing="0" width="100%" class="sTable" >
                                    <thead>
                                        <tr>
                                            <td width="80">Driver Name</td>
                                            <td width="80"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center"><a href="<?php echo BASE_URL; ?>manage/driverinfo/22" title="" >Elbi</a></td>
                                            <td align="center"><a href="<?php echo BASE_URL; ?>manage/companydetails/9" title="" > <img   width="32" height="32" src="<?php echo BASE_URL; ?>images/9.png"/> <br/>
                                                    test</a></td>
                                        </tr>
                                        <tr>
                                            <td align="center"><a href="<?php echo BASE_URL; ?>manage/driverinfo/23" title="" >Rajesh</a></td>
                                            <td align="center"><a href="<?php echo BASE_URL; ?>manage/companydetails/9" title="" > <img   width="32" height="32" src="<?php echo BASE_URL; ?>images/9.png"/> <br/>
                                                    test</a></td>
                                        </tr>
                                        <tr>
                                            <td align="center"><a href="<?php echo BASE_URL; ?>manage/driverinfo/24" title="" >Dogan</a></td>
                                            <td align="center"><a href="<?php echo BASE_URL; ?>manage/companydetails/9" title="" > <img   width="32" height="32" src="<?php echo BASE_URL; ?>images/9.png"/> <br/>
                                                    test</a></td>
                                        </tr>
                                        <tr>
                                            <td align="center"><a href="<?php echo BASE_URL; ?>manage/driverinfo/25" title="" >Robin</a></td>
                                            <td align="center"><a href="<?php echo BASE_URL; ?>manage/companydetails/9" title="" > <img   width="32" height="32" src="<?php echo BASE_URL; ?>images/9.png"/> <br/>
                                                    test</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                             Latest Vehiclees widget 
                            <div class="widget" >
                                <div class="title"><img src="<?php echo BASE_URL; ?>images/add.png" alt="" class="titleIcon" />
                                    <h6>Latest updates</h6>
                                </div>
                                <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
                                    <tr>
                                        <td align="center">Total Bookings</td>
                                        <td align="center"><a href="<?php echo BASE_URL; ?>manage/company" title="Total Companies" >0</a></td>
                                    </tr>
                                    <tr>
                                        <td align="center">Current Bookings</td>
                                        <td align="center"><a href="<?php echo BASE_URL; ?>manageusers/passengers" title="Total Passengers" >58</a></td>
                                    </tr>
                                    <tr>
                                        <td align="center">Total Drivers</td>
                                        <td align="center"><a href="<?php echo BASE_URL; ?>manage/driver" title="Total Drivers" >16</a></td>
                                    </tr>
                                    <tr>
                                        <td align="center">Total Vehicles</td>
                                        <td align="center"><a href="<?php echo BASE_URL; ?>manage/Vehicle" title="Total Vehiclees" >9</a></td>
                                    </tr>
                                    <tr>
                                        <td align="center">Total Customers</td>
                                        <td align="center"><a href="<?php echo BASE_URL; ?>manage/Vehicle" title="Total Vehiclees" >9</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
               
            </div>
            </div>-->



            




            <script src="<?php echo BASE_URL; ?>js/highcharts.js"></script> 
            <?php include 'includes/footer.php'; ?>
            <script type="text/javascript" src="js/index.js" defer>
            </script> 
           
    </body>
</html>

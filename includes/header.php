<?php 
    if(isset($_POST['set_city']))
    {

            $dash_city=$_POST['dash_city'];

            $ltln=mysql_query("SELECT * FROM `city` WHERE `id`='".$dash_city."' ");
            $r_ltln=mysql_fetch_array($ltln);
            $lat=$r_ltln['lat'];
            $lng=$r_ltln['lng'];

            $_SESSION['dash_city']=$dash_city;
            $_SESSION['city_lat']=$lat;
            $_SESSION['city_lng']=$lng;

         //   $_SESSION['dash_city'];
    }

?>

<script type="text/javascript">
       $(document).ready(function () {
           // Get All UserAccess List
       var uaid = localStorage.getItem("EmployeeAccess");

           var arid = uaid.toString().split(',');
           for (mid = 0; mid < arid.length; mid++) {
               $(".MD" + arid[mid].toString()).show();
           }
       })
</script>

<input type="hidden" name="baseurl" id="baseurl" value="<?php echo BASE_URL; ?>">
<div class="overflow">
    <div class="img">
        <img src="<?php echo BASE_PATH?>images/ajax-loader1.gif">
    </div>
</div>
<!-- Fixed top -->
<div id="top">
    <div class="fixed">
        
           <ul class="top-menu">
            <!--<li><a class="all_balance"></a></li>-->
                <li style="margin-top: 3.5%;">
                    <div class="new_input_field">
                        <div class="formRight">
                            <div class="new_input_field">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <select name="dash_city" id="dash_city" class="required"  title="Select the City" style="float: left;" >
                                  <?php
                                    $result = $objConnect->select('city');
                                    while ($row = $objConnect->fetch_assoc()) {

                                        $city_id=$row['id'];
                                        $chk=mysql_query("SELECT * FROM `assign_city_admin` WHERE `emp_id`='".$_SESSION['executive_id']."' ");
                                        $r_check=mysql_fetch_array($chk);
                                        $ass_city_id=$r_check['city_id'];
                                        $arr_city_id=explode(',', $ass_city_id);


                                            if (in_array($city_id, $arr_city_id)) 
                                            {
                                                if($row['id']==$_SESSION['dash_city'])
                                                {
                                                    echo '<option selected  value="'.$row['id'].'" >'.$row['city'].'</option> '; 

                                                }else
                                                {
                                                      echo '<option  value="'.$row['id'].'" >'.$row['city'].'</option> ';
                                                }
                                            }
                                       
                                        }
                                        ?>

                                </select>
                                <input type="hidden" id="city_lat" name="city_lat" value="<?php echo  $_SESSION['city_lat']; ?>" />
                                <input type="hidden" id="city_lng" name="city_lng" value="<?php echo  $_SESSION['city_lng']; ?>" />
                                <input type="submit" name="set_city" value="Set" style="margin-top: 5px;" >
                            </form>
                            </div>
                        </div>
                    </div> 
                </li>
            			<li><a class="fullview1"></a></li>
                    
                 <!--                   <li><a class="showmenu"></a></li>-->
            <li class="dropdown">
                <a class="user-menu" data-toggle="dropdown">
                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $_SESSION['executive_photo'];?>" onerror="this.src='<?php echo BASE_URL; ?>images/userPic.png'" alt="" /><span>Welcome <?php echo ucfirst($_SESSION['executive_name']);?> <b class="caret"></b></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo BASE_URL; ?>profile.php" title=""><i class="fa fa-user"></i>Profile</a></li>
                    <li><a href="<?php echo BASE_URL; ?>defaultTask.php?function=logout" title=""><i class="fa fa-remove"></i>Logout</a></li>
                </ul>
            </li>
        </ul>
        <a href="<?php echo BASE_URL; ?>" target = "_blank" title="" class="logo"><img src="<?php echo BASE_URL; ?>images/logo.png" alt="" /><span id="blue"></span></a>

    </div>
</div>
<!-- /fixed top -->

<div id="container"><!-- Content container -->
    <?php include 'sidebar.php'; ?>

    <!-- Content -->
    
    <div id="content">
<script>
           /* $(document).ready(function () {
               
                
                    var value= $('#dash_city').val();

                    alert("hiii"+value);
                    
                   localStorage.setItem('_NSCaseId', value); 

                $("select option[value='" + value + "']").attr("selected","selected");

            });*/
        </script>
<?php
include '../includes/define.php';
verifyLogin();

if(isset($_POST['f_city']) && isset($_POST['a_vehicle_cat_id']))
{
    $a_vehicle_cat_id=$_POST['a_vehicle_cat_id'];
    $f_city=$_POST['f_city'];

    $assign_vehicle_cat_id=implode(',', $a_vehicle_cat_id);
        
        $res1= mysql_query("SELECT * FROM `assign_city_vehicle_category` WHERE `city_id`='$f_city'");           
          $res2= mysql_num_rows($res1);
          if($res2>0)
          {
                mysql_query("UPDATE assign_city_vehicle_category SET `vehicle_category_id`='$assign_vehicle_cat_id' WHERE `city_id`='$f_city'");
          }
            else
            {
                mysql_query("INSERT INTO assign_city_vehicle_category (`city_id`,`vehicle_category_id`)VALUES('$f_city','$assign_vehicle_cat_id')");
            }

}

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
                    <a href=<?php echo BASE_URL; ?>admin/dashboard title=<?php echo BASE_URL; ?>admin/dashboard>Home</a>
                    </li>
                <li class="active"><a title="">Assign Vehicle Category List</a></li>
            </ul>
        </div>

        <div class="content_middle mt15">   
            <form method="post"  id="reportSearch1" action="vehicle_category_assign.php">
            <table border="0" cellpadding="5" cellspacing="0" width="100%">
                <tr>
                    <td colspan="4" class="style_1">Assign Vehicle Category</td>
                   
                </tr>   
                <tr>
                    <td colspan="4" height="10"></td>
                </tr> 
                <tr>
                    <td valign="top" width="20%" class="mtb"><label>City</label><span class="star"></span></td>        
                    <td class="mtb">
                        <div class="new_input_field">
                            <select  name="city_id" id="city_id" >
                                <option value="">Select City</option>
                                <?php 
                                $sql1="select *  from city ";
                                $result1=  mysql_query($sql1) or die(mysql_error());
                                while($row1=  mysql_fetch_assoc($result1)){
                                    ?>
                                        <option value="<?php echo $row1['id']?>" <?php if(isset($_GET['cur_city_id'])) {if($row1['id']==$_GET['cur_city_id']){echo 'selected=selected';}}?> ><?php echo $row1['city'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                       
                    </td>
                </tr>       
                          
               
                    <tr>
                            <td>&nbsp;</td>
                                        <td colspan="2">
                                            
                                            <div class="button dredB">   <input type="reset" value="Reset" onClick="$('#searchResult').html('');" title="Reset" style="line-height:13px; background:#dadada; color:#303030;" /></div>
                                            <div class="button greenB">  <input type="submit" name="search" class="my_btn" value="search" title="submit"  /></div>
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
<div class="searchResult" id="searchResult">
<?php if(isset($_POST['search']) && !empty($_POST['city_id']) || isset($_GET['cur_city_id']))
            {
                if(isset($_GET['cur_city_id']))
                {
                    $city_id=$_GET['cur_city_id'];

                }else
                {
                    $city_id=$_POST['city_id'];

                }

              $chk=mysql_query("SELECT * FROM `city` WHERE `id`='$city_id' ");
                    $r_check=mysql_fetch_array($chk);
echo'<h2 style="float: left;">City Name: </h2><h3>'.$r_check['city'].'</h3>';
?>
<form method="post"  id="reportSearch1" action="vehicle_category_assign.php?cur_city_id=<?php echo $city_id; ?>">
<table class="table table-bordered table-striped table-condensed ">

    <tr>

        <th>S no. </th>

        <th></th>

        <th>Vehicle Category</th>

        

    </tr>

    
    <?php 
            if(!empty($city_id))
            {
              
                echo'<input type="hidden" name="f_city" value="'.$city_id.'">';
                $sql="SELECT * FROM `vehicle_category` ";
             
                $res=mysql_query($sql);
                $i=1;
               while($result=mysql_fetch_array($res))
                { 

                    $vehicle_cat_id=$result['id'];
                    $chk=mysql_query("SELECT * FROM `assign_city_vehicle_category` WHERE `city_id`='$city_id' ");
                    $r_check=mysql_fetch_array($chk);
                    $ass_vehicle_category_id=$r_check['vehicle_category_id'];
                    $arr_vehicle_category_id=explode(',', $ass_vehicle_category_id);

                   echo'<tr>
                            <td>'.$i.'</td>';
                            if(in_array($vehicle_cat_id, $arr_vehicle_category_id))
                            {
                                echo'<td><input type="checkbox"  value="'.$vehicle_cat_id.'" checked name="a_vehicle_cat_id[]"/></td>';
                            }else
                            {
                                 echo'<td><input type="checkbox" value="'.$vehicle_cat_id.'"  name="a_vehicle_cat_id[]"/></td>';
                            }
                           echo' <td>'.$result['name'].'</td>
                            
                        </tr>';


                         $i++;
                }
               
            }
    ?>

        


    
</table>
<div class="button greenB">  <input type="submit" name="submit" class="my_btn" value="submit" title="submit"  /></div>
</form>
<?php } ?>


</div>
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
<?php
include '../includes/define.php';

$mode = $_REQUEST['mode'];
unset($_POST['mode']);
switch ($mode) {
    case "new":
     
                $today = date("Y-m-d H:i:s");
               // $_POST['create_at'] = $today;
                 $num=$_POST['no_of_coupon'];
                for($i=0; $i<$num; $i++)
                {

                    $token=randomkeys();
                    
                   $arr['valid_till']= $_POST['valid_till'];
                   $arr['coupan_code']= $token;
                   $arr['create_at'] = $today;
                     $result1 = $objConnect->insert('discount_coupan', $arr);
                }
                if ($result1) {

                    echo "Employee Added Successfully <a href='organization_list.php'>View  List</a>";
                }
        break;
    case "edit":
        $id=$_POST['id'];
        
                $result1 = $objConnect->update('organization', $_POST,"id=$id");
                if ($result1) {

                    echo "redirectOrganization Edited <a href='organization_list.php'>View  List</a>URLorganization_list.php";
                }
        break;
    case "fetchCategory":
        $result = $objConnect->selectWhere('vehicle_category', "name='" . $_POST['name'] . "' and status=1");
        $row = $objConnect->fetch_assoc();
        print_r(json_encode($row));
        break;

    case "delete_coupon":
        $id=$_GET['id'];
        $sql=mysql_query("DELETE FROM discount_coupan WHERE id='$id'");
        header('location:discount_coupon_list.php');
        break;
    case "fetchDriver2":
        ?>
        <select name="driver2_id" id="driver2_id1" class="required"  title="Select the Driver2" >
            <option value="">--Select--</option>
            <?php
            $result2 = $objConnect->selectWhere('driver', "id!='" . $_POST['id'] . "' and vehicle_id=''");
            while ($row2 = $objConnect->fetch_assoc()) {
                ?>
                <option value="<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></option>
                <?php
            }
            ?>
        </select>
        <?php
        break;
    default:
        break;
}
?>
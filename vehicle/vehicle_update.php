<?php
include '../includes/define.php';
$mode = $_REQUEST['mode'];
unset($_POST['mode']);
unset($_GET['mode']);
switch ($mode) {
    case "new":
        $result = $objConnect->selectWhere('vehicle', "registration_no='" . $_POST['registration_no'] . "' and status=1");
        $num = $objConnect->total_rows();
        if (!$num) {
            $_POST['insurence_validity'] = changeFormat("d/m/Y", "Y-m-d", $_POST['insurence_validity']);
            $_POST['polution_validity'] = changeFormat("d/m/Y", "Y-m-d", $_POST['polution_validity']);
            $_POST['fitness_validaity'] = changeFormat("d/m/Y", "Y-m-d", $_POST['fitness_validaity']);
            $_POST['road_tax_validity'] = changeFormat("d/m/Y", "Y-m-d", $_POST['road_tax_validity']);
            if ((isset($_FILES['polution_scan']['tmp_name'])) && (!empty($_FILES['polution_scan']['tmp_name']))) {
                $_POST['polution_scan'] = uploadFile("polution_scan", $_FILES);
            }
            if ((isset($_FILES['rc_scan']['tmp_name'])) && (!empty($_FILES['rc_scan']['tmp_name']))) {
                $_POST['rc_scan'] = uploadFile("rc_scan", $_FILES);
            }
            if ((isset($_FILES['fitness_scan']['tmp_name'])) && (!empty($_FILES['fitness_scan']['tmp_name']))) {
                $_POST['fitness_scan'] = uploadFile("fitness_scan", $_FILES);
            }
            if ((isset($_FILES['insurance_scan']['tmp_name'])) && (!empty($_FILES['insurance_scan']['tmp_name']))) {
                $_POST['insurance_scan'] = uploadFile("insurance_scan", $_FILES);
            }
            if ((isset($_FILES['road_tax_scan']['tmp_name'])) && (!empty($_FILES['road_tax_scan']['tmp_name']))) {
                $_POST['road_tax_scan'] = uploadFile("road_tax_scan", $_FILES);
            }
            $today = date("Y-m-d H:i:s");
            $_POST['addedon'] = $today;
            $_POST['addedby'] = $_SESSION['executive_id'];
            $_POST['status'] = 1;
            $result1 = $objConnect->insert('vehicle', $_POST);
            if ($result1) {
                $arr['vehicle_id'] = $result1;
                $result2 = $objConnect->update('driver', $arr, "(id=" . $_POST['driver1_id'] . " or id=" . $_POST['driver2_id'] . ")");
                echo "Vehicle Added Successfully <a href='vehicle_list.php'>View  List</a>";
            }
        } else {
            echo "Vehicle  Already Exist  <a href='vehicle_list.php'>View List</a>";
        }
        break;
    case "edit":
        $_POST['insurence_validity'] = changeFormat("d/m/Y", "Y-m-d", $_POST['insurence_validity']);
        $_POST['polution_validity'] = changeFormat("d/m/Y", "Y-m-d", $_POST['polution_validity']);
        $_POST['fitness_validaity'] = changeFormat("d/m/Y", "Y-m-d", $_POST['fitness_validaity']);
        $_POST['road_tax_validity'] = changeFormat("d/m/Y", "Y-m-d", $_POST['road_tax_validity']);
        if ((isset($_FILES['polution_scan']['tmp_name'])) && (!empty($_FILES['polution_scan']['tmp_name']))) {
            $_POST['polution_scan'] = uploadFile("polution_scan", $_FILES);
        }
        if ((isset($_FILES['rc_scan']['tmp_name'])) && (!empty($_FILES['rc_scan']['tmp_name']))) {
            $_POST['rc_scan'] = uploadFile("rc_scan", $_FILES);
        }
        if ((isset($_FILES['fitness_scan']['tmp_name'])) && (!empty($_FILES['fitness_scan']['tmp_name']))) {
            $_POST['fitness_scan'] = uploadFile("fitness_scan", $_FILES);
        }
        if ((isset($_FILES['insurance_scan']['tmp_name'])) && (!empty($_FILES['insurance_scan']['tmp_name']))) {
            $_POST['insurance_scan'] = uploadFile("insurance_scan", $_FILES);
        }
        if ((isset($_FILES['road_tax_scan']['tmp_name'])) && (!empty($_FILES['road_tax_scan']['tmp_name']))) {
            $_POST['road_tax_scan'] = uploadFile("road_tax_scan", $_FILES);
        }
        $result1 = $objConnect->update('vehicle', $_POST, "id=" . $_POST['id']);
        if ($result1) {
            $brr['vehicle_id'] = 0;
            $result2 = $objConnect->update('driver', $brr, "(vehicle_id=" . $_POST['id'] . ")");
            $arr['vehicle_id'] = $result1;
            $result2 = $objConnect->update('driver', $arr, "(id=" . $_POST['driver1_id'] . " or id=" . $_POST['driver2_id'] . ")");
            echo "Vehicle Updated Successfully <a href='vehicle_list.php'>View  List</a>";
        }
        break;
    case "fetchCategory":
        $result = $objConnect->selectWhere('vehicle_category', "name='" . $_POST['name'] . "' and status=1");
        $row = $objConnect->fetch_assoc();
        print_r(json_encode($row));
        break;
    case "fetchDriver2":
        ?>
        <select name="driver2_id" id="driver2_id1" class="required"  title="Select the Driver2" >
            <option value="">--Select--</option>
            <?php
            $vehicle_id = $_POST['vehicle'];
            if ((isset($vehicle_id)) && (!empty($vehicle_id))) {
                
                $xxxx = " where id !=$vehicle_id";
            
            }

            $sql2 = "select * from driver where id!='" . $_POST['id'] . "' and id not in (select driver1_id from vehicle $xxxx) and id not in (select driver2_id from vehicle $xxxx)";
echo $sql2;
            $result2 = $objConnect->execute($sql2);
            while ($row2 = $objConnect->fetch_assoc()) {
                ?>
                <option value="<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></option>
                <?php
            }
            ?>
        </select>
        <?php
        break;


           case "fetchCategory":
        $result = $objConnect->selectWhere('vehicle_category', "name='" . $_POST['name'] . "' and status=1");
        $row = $objConnect->fetch_assoc();
        print_r(json_encode($row));
        break;
    case "get_vehicle_category":
        
        $sql2 = "select * from `vehicle_category` where `city_id`='".$_GET['value']."'";
            $result2 = $objConnect->execute($sql2);
            while ($row2 = $objConnect->fetch_assoc()) {
                ?>
                <option value="<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></option>
                <?php
            }
          
        break;

    default:
        break;
}
?>
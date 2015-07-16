<?php
include '../includes/define.php';

$mode = $_REQUEST['mode'];
unset($_POST['mode']);
switch ($mode) {
    case "new":
     
                $today = date("Y-m-d H:i:s");
                $_POST['create_at'] = $today;

                $city_name=$_POST['city'];

                $response=file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=".$city_name."&sensor=false"); 

                $result=json_decode($response);
                $lat=$result->results[0]->geometry->location->lat;
                $lng=$result->results[0]->geometry->location->lng; 

                $_POST['lat'] = $lat;
                $_POST['lng'] = $lng;
                
                $result1 = $objConnect->insert('city', $_POST);
                if ($result1) {

                    echo "City Added Successfully <a href='city_list.php'>View  List</a>";
                }
        break;
    case "edit":
        $id=$_POST['id'];
        
                $result1 = $objConnect->update('city', $_POST,"id=$id");
                if ($result1) {

                    echo "redirectCity Edited <a href='city_list.php'>View  List</a>URLcity_list.php";
                }
        break;
    case "fetchCategory":
        $result = $objConnect->selectWhere('vehicle_category', "name='" . $_POST['name'] . "' and status=1");
        $row = $objConnect->fetch_assoc();
        print_r(json_encode($row));
        break;

    case "delete_city":
        $id=$_GET['id'];
        $sql=mysql_query("DELETE FROM city WHERE id='$id'");
        header('location:city_list.php');
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
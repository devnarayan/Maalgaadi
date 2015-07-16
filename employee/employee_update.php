<?php
include '../includes/define.php';
$mode = $_POST['mode'];
unset($_POST['mode']);
switch ($mode) {
    case "new":
        $result = $objConnect->selectWhere('employee', "email='" . $_POST['email'] . "' and status=1");
        $num = $objConnect->total_rows();

        if (!$num) {
            if ($_POST['cpassword'] == $_POST['password']) {
                unset($_POST['cpassword']);

                if ((isset($_FILES['photo']['tmp_name'])) && (!empty($_FILES['photo']['tmp_name']))) {
                    $_POST['photo'] = uploadFile('photo', $_FILES);
                }
                $_POST['joining_date'] = changeFormat("d/m/Y", "Y-m-d", $_POST['joining_date']);
                $_POST['dob'] = changeFormat("d/m/Y", "Y-m-d", $_POST['dob']);
                $today = date("Y-m-d H:i:s");
                $_POST['added_on'] = $today;
                $_POST['added_by'] = $_SESSION['executive_id'];
                $_POST['status'] = 1;
                $result1 = $objConnect->insert('employee', $_POST);
                if ($result1) {

                    echo "Employee Added Successfully <a href='employee_list.php'>View  List</a>";
                }
            } else {
                echo "Password Confirm password Do not match";
            }
        } else {
            echo "Employee Already Exist  <a href='employee_list.php'>View List</a>";
        }
        break;
    case "edit":
        $id=$_POST['id'];
         if ((isset($_FILES['photo']['tmp_name'])) && (!empty($_FILES['photo']['tmp_name']))) {
                    $_POST['photo'] = uploadFile('photo', $_FILES);
                }
                $_POST['joining_date'] = changeFormat("d/m/Y", "Y-m-d", $_POST['joining_date']);
                $_POST['dob'] = changeFormat("d/m/Y", "Y-m-d", $_POST['dob']);
                $result1 = $objConnect->update('employee', $_POST,"id=$id");
                if ($result1) {

                    echo "redirectEmployee Edited <a href='employee_list.php'>View  List</a>URLemployee_list.php";
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
<?php

include '../includes/define.php';
$mode = $_POST['mode'];
unset($_POST['mode']);
switch ($mode) {
    case "new":

        $result = $objConnect->selectWhere('vehicle_category', "name='" . $_POST['name'] . "'");
        $num = $objConnect->total_rows();
        if (!$num) {
            if ((isset($_FILES['image']['tmp_name'])) && (!empty($_FILES['image']['tmp_name']))) {
                $_POST['image'] = uploadFile("image", $_FILES);
            }
            $today = date("Y-m-d H:i:s");
            $_POST['added_on'] = $today;
            $_POST['added_by'] = $_SESSION['executive_id'];
            $_POST['status'] = 1;
            $objConnect->insert('vehicle_category', $_POST);
            echo "Vehicle Category Added Successfully <a href='vehicle_category_list.php'>View Category List</a>";
        } else {
            echo "Vehicle Category Already Exist  <a href='vehicle_category_list.php'>View Category List</a>";
        }
        break;
    case "edit":
        $id = $_POST['id'];
        if ((isset($_FILES['image']['tmp_name'])) && (!empty($_FILES['image']['tmp_name']))) {
            $_POST['image'] = uploadFile("image", $_FILES);
        }
        $result1 = $objConnect->update('vehicle_category', $_POST, "id=$id");
        if ($result1) {

            echo "redirect Vehicle Category Edited <a href='vehicle_category_list.php'>View  List</a>URLvehicle_category_list.php";
        }
        break;
    default:
        break;
}
?>
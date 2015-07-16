<?php
include '../includes/define.php';
$mode = $_POST['mode'];
unset($_POST['mode']);
switch ($mode) {
    case "new":
        $today = date("Y-m-d H:i:s");
        if ((isset($_FILES['licence_scan']['tmp_name'])) && (!empty($_FILES['licence_scan']['tmp_name']))) {
                $_POST['licence_scan'] = uploadFile("licence_scan", $_FILES);
            }
            if ((isset($_FILES['address_proof']['tmp_name'])) && (!empty($_FILES['address_proof']['tmp_name']))) {
                $_POST['address_proof'] = uploadFile("address_proof", $_FILES);
            }
            if ((isset($_FILES['id_proof']['tmp_name'])) && (!empty($_FILES['id_proof']['tmp_name']))) {
                $_POST['id_proof'] = uploadFile("id_proof", $_FILES);
            }
            if ((isset($_FILES['police_verification']['tmp_name'])) && (!empty($_FILES['police_verification']['tmp_name']))) {
                $_POST['police_verification'] = uploadFile("police_verification", $_FILES);
            }
            
        $_POST['liecence_validity'] = changeFormat("d/m/Y", "Y-m-d", $_POST['liecence_validity']);
        $_POST['joining_date'] = changeFormat("d/m/Y", "Y-m-d", $_POST['joining_date']);
        $_POST['added_on'] = $today;
        $_POST['added_by'] = $_SESSION['executive_id'];
        $_POST['status'] = 1;
        $objConnect->insert('driver', $_POST);
        echo "Driver Added Successfully <a href='driver_list.php'>View Driver List</a>";
        break;
    case "edit":
        $id = $_POST['id'];
        $_POST['liecence_validity'] = changeFormat("d/m/Y", "Y-m-d", $_POST['liecence_validity']);

        $result1 = $objConnect->update('driver', $_POST, "id=$id");
        if ($result1) {

            echo "redirect Driver Edited <a href='driver_list.php'>View  List</a>URLdriver_list.php";
        }
        break;
        
    default:
        break;
}
?>
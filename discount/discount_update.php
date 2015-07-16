<?php

include '../includes/define.php';
$mode = $_POST['mode'];
unset($_POST['mode']);
switch ($mode) {
    case "new":

        $result = $objConnect->selectWhere('discount', "customer_id='" . $_POST['customer_id'] . "' and discount_date = '" . $_POST['discount_date'] . "' ");
        $num = $objConnect->total_rows();
        if (!$num) {
            $_POST['customer_name'] = $_POST['firstname'];
            $today = date("Y-m-d H:i:s");
            $_POST['added_on'] = $today;
            $_POST['added_by'] = $_SESSION['executive_id'];
            unset($_POST['firstname']);
            $objConnect->insert('discount', $_POST);
            echo "Customer Discount Added Successfully <a href='view_discount.php'>View Customer Discount List</a>";
        } else {
            echo "Customer Discount Already Exist on this Date. <a href='view_discount.php'>View Customer Discount</a>";
        }
        break;
    case "edit":
        $id = $_POST['id'];
       $_POST['customer_name'] = $_POST['firstname'];
           unset($_POST['firstname']);
        $result1 = $objConnect->update('discount', $_POST, "id=$id");
        if ($result1) {
                 
            echo "redirect Customer Discount Edited <a href='view_discount.php'>View  List</a>URLview_discount.php";
        }
        break;
    default:
        break;
}
?>
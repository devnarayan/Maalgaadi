<?php
include '../includes/define.php';
$mode = $_REQUEST['mode'];
unset($_POST['mode']);
unset($_GET['mode']);
switch ($mode) {
    case "new":
        $result = $objConnect->selectWhere('employee', "email='" . $_POST['email'] . "' and status=1");
        $num = $objConnect->total_rows();

        if (!$num) {
            if ($_POST['cpassword'] == $_POST['password']) {
                unset($_POST['cpassword']);

                if ((isset($_FILES['image']['tmp_name'])) && (!empty($_FILES['image']['tmp_name']))) {
                    $_POST['image'] = uploadFile('image', $_FILES);
                }
                if($_POST['customer_organization']==""){
                    $_POST['customer_organization']=$_POST['other'];
                }
               unset($_POST['other']);
                $_POST['dob'] = changeFormat("d/m/Y", "Y-m-d", $_POST['dob']);
                $today = date("Y-m-d H:i:s");
                $_POST['added_on'] = $today;
                $_POST['added_by'] = $_SESSION['executive_id'];
                $_POST['status'] = 1;
                $result1 = $objConnect->insert('customer', $_POST);
                if ($result1) {

                    echo "Customer Added Successfully <a href='customer_list.php'>View  List</a>";
                }
            } else {
                echo "Password Confirm password Do not match";
            }
        } else {
            echo "Customer Already Exist  <a href='employee_list.php'>View List</a>";
        }
        break;
    case "edit":
        $id=$_POST['id'];
         if ((isset($_FILES['photo']['tmp_name'])) && (!empty($_FILES['photo']['tmp_name']))) {
                    $_POST['photo'] = uploadFile('photo', $_FILES);
                }
                 if($_POST['customer_organization']==""){
                    $_POST['customer_organization']=$_POST['other'];
                }
               unset($_POST['other']);
                $_POST['dob'] = changeFormat("d/m/Y", "Y-m-d", $_POST['dob']);
                $result1 = $objConnect->update('customer', $_POST,"id=$id");
                if ($result1) {

                    echo "redirectCustomer Edited <a href='customer_list.php'>View  List</a>URLcustomer_list.php";
                }
        break;

      case "organization":
        
        $sql2 = "select * from `organization` where `city_id`='".$_GET['value']."'";
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
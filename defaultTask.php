<?php

include 'includes/define.php';
$task = $_GET['function'];

switch ($task) {
    case "login":
        $username = $_POST['email'];
        $password = $_POST['password'];
        //  login("adminusers", $username, $password);

        $table = "employee";
        $query = "select * from `$table` where `email` like '$username'";

        $result = $objConnect->execute($query);
        $num = $objConnect->total_rows();
        if ($num) {
            $row = $objConnect->fetch_assoc();
            if ($password == $row['password']) {

                $employee = "select * from `employee_access` where `emp_id`='".$row['id']."'";
                $employee2 = $objConnect->execute($employee);
                $employee1 = $objConnect->fetch_assoc();
                $employee_module_id=$employee1['module_id'];



                $query1 = "select * from `assign_city_admin` where `emp_id`='".$row['id']."'";
                $result1 = $objConnect->execute($query1);
                $row1 = $objConnect->fetch_assoc();

                $city=explode(',', $row1['city_id']);
                $city_id=$city[0];

                $ltln=mysql_query("SELECT * FROM `city` WHERE `id`='".$city_id."' ");
                $r_ltln=mysql_fetch_array($ltln);
                $lat=$r_ltln['lat'];
                $lng=$r_ltln['lng'];

                $_SESSION['dash_city']=$city_id;
                $_SESSION['city_lat']=$lat;
                $_SESSION['city_lng']=$lng;
                $_SESSION['executive_name'] = $row['name'];
                $_SESSION['executive_id'] = $row['id'];
                $_SESSION['executive_position'] = $row['position'];
                $_SESSION['executive_photo'] = $row['photo'];
                $_SESSION['executive_email'] = $row['email'];
                echo "success-".$employee_module_id;
            } else {
                echo "Email and Password do not match";
            }
        } else {
            echo "User not registered";
        }
        break;

    case "changepass":

        $currentpassword = $_POST['currentpassword'];
        $newpassword = $_POST['newpassword'];
        $cunpassword = $_POST['cunpassword'];
        $name = $_SESSION['admin_username'];
        $id = $_SESSION['admin_user_id'];
        if ($newpassword == $cunpassword) {
            $q = "select * from adminusers where password='$currentpassword'";
            $r = mysql_query($q);
            $result = mysql_fetch_assoc($r);
            if ($result > 0) {


                $sql = "UPDATE adminusers SET password='$newpassword' WHERE id='$id' and name='$name'";

                mysql_query($sql)or die(mysql_error());

                echo "Successfully Update your password";
            } else {
                echo "your old password wrong";
            }
        } else {
            echo "Confirm password and new password are not matched";
        }
        ?> <script>window.location.reload(true);</script>
        <?php

        break;


    case "logout":

        logout("admin");
        break;
}
?>
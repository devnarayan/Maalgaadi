<?php
include '../includes/define.php';
$mode = $_REQUEST['mode'];
unset($_POST['mode']);
unset($_GET['mode']);
switch ($mode) {
    case "deletefav":
        $id=$_POST['id'];
         $result=$objConnect->deleteRow("favorite_location","id = ($id)");
         echo "success";
        break;
    case "editFav":
        $_POST['last_updated']=date("Y-m-d H:i:s");
        $_POST['status']=0;
        $id=$_POST['id'];
        $objConnect->update("favorite_location",$_POST,"id=$id");
        echo "Edited Successfully";
        break;
}
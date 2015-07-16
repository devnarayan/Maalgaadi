<?php
include './includes/define.php';
if((isset($_POST['table']))&&(!empty($_POST['table']))&&(isset($_POST['id']))&&(!empty($_POST['id']))){
    $table=$_POST['table'];
    $id=$_POST['id'];
    if($table=="vehicle_category"){
        $result1=$objConnect->selectWhere($table,"id in ($id)");
        while ($row1 =$objConnect->fetch_asoc()) {
            if(!empty($row1['image'])){
                $image=BASE_PATH."uploads/".$row1['image'];
                unset($image);
            }
        }
    }
    $result=$objConnect->deleteRow($table,"id in ($id)");
    if($result){
        echo "Success";
    }
    else{
        echo "Try Again";
    }
}
else{
    echo "Some error occurred, Please Refresh and try again.";
}
?>
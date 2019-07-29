<?php
$connection  = mysqli_connect('localhost','root','' , 'accounts');
$userObj  = mysqli_query($connection , 'SELECT * FROM `users`');
if(isset($_POST['data'])){
    $dataArr = $_POST['data'] ;
    foreach($dataArr as $id){
        mysqli_query($connection , "DELETE FROM users where id='$id'");
    }
    echo 'record deleted successfully';
}
?>
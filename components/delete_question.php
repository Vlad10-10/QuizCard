<?php
include './server/server.php';
if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    mysqli_query($conn, "DELETE FROM engtest WHERE id=$id");
}
?>

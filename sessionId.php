<?php
session_start();
if(isset($_POST['deleteButton'])) {
    $_SESSION['accessedId'] = $_POST['deleteId'];
    if($_POST['deleteId']) {
        header('Location: ./delete.php');
    }
}
?>
<?php
    session_start();

    //Διακοπτει το SESSION και σε πεταει στο home1.php
    if(isset($_SESSION['user_id']))
        {
            unset($_SESSION['user_id']);
        }
    header("Location: home1.php");
    die;                 
?>
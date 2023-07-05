<?php require_once('common.php');
    session_start();

    if (isset($_GET['id'])) {


        $id = $_GET['id'];

        $sql = "DELETE FROM reservation WHERE reservation_id = '$id' ";
        $result = $conn->query($sql);
        if ($result == TRUE) {

            echo "Record deleted successfully.";
    
        }else{
    
            echo "Error:" . $sql . "<br>" . $conn->error;
        }
        header("Location: admin.php");
    }

?>

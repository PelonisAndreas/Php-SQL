<?php require_once('common.php');
    session_start();

    if (isset($_GET['id'])) {


        $id = $_GET['id'];

        $sql = "DELETE FROM reservation WHERE user_user_id = '$id' ";
        $result = $conn->query($sql);

        // cannot delete admins roles
        $sql2 = "DELETE FROM user WHERE user_id = '$id' AND user_role<>'Admin'";
        $result2 = $conn->query($sql2);

        if ($result == TRUE) {

            echo "Record deleted successfully.";
    
        }else{
    
            echo "Error:" . $sql . "<br>" . $conn->error;
        }
        header("Location: admin.php");
    }

?>

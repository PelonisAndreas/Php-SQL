<?php require_once('common.php');
    session_start();

    if (isset($_GET['id'])) {


        $id = $_GET['id'];

        // για να γινει delete ενα screening στο οποιο υπαρχουν reservations θα πρεπει να διαγραφθουν ολα τα reservations για αυτο το screening
        $sql = "DELETE FROM reservation WHERE screening_screening_id = '$id' ";
        $result = $conn->query($sql);

        $sql2 = "DELETE FROM screening WHERE screening_id = '$id' ";
        $result2 = $conn->query($sql2);
        if ($result2 == TRUE) {

            echo "Record deleted successfully.";
    
        }else{
    
            echo "Error:" . $sql . "<br>" . $conn->error;
        }
        header("Location: admin.php");
    }

?>
<?php require_once('common.php');
    session_start();

    if (isset($_GET['id'])) {


        $id = $_GET['id'];

        //Για να γινει delete ενα movie θα πρεπει πρωτα να διαγραφουν ολα τα reservations που σχετιζονται με αυτο το movie.
        $sql = "DELETE FROM reservation WHERE movie_movie_id = '$id' ";
        $result = $conn->query($sql);


        //Για να γινει delete ενα movie θα πρεπει πρωτα να διαγραφουν ολα τα screenings που σχετιζονται με αυτο το movie.
        $sql2 = "DELETE FROM screening WHERE movie_movie_id = '$id' ";
        $result2 = $conn->query($sql2);

        $sql3 = "DELETE FROM movie WHERE movie_id = '$id' ";
        $result3 = $conn->query($sql3);
        if ($result3 == TRUE) {

            echo "Movie Record deleted successfully.";
    
        }else{
    
            echo "Error:" . $sql . "<br>" . $conn->error;
        }
        header("Location: admin.php");

    }

?>

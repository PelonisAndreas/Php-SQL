<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css\styles.css">
        <script src="js/script.js" defer></script>
        <style>
             .cancelbutton{
                display: block;
                padding: 15px;
                color: white;
                text-decoration: none;
                background-color:  red;
                border-radius: 10px;
                border: transparent;
                cursor: pointer; 
                width: 14%;
            }
            
           
                            
        </style>

        <?php require_once('common.php');
            session_start();

            // Ελεγχει αν ο user που ειναι στην σελιδα log_in.php εχει κανει log_in και αν εχει το σωστο SESSION
            function check_login($conn){
                // Ελεγχει αν εχει οριστει το SESSION με το user_id του user που εκανε log in
                if(isset($_SESSION['user_id']))
                {
                    $id = $_SESSION['user_id'];
                    $query = "select * from user where user_id = '$id' limit 1";

                    $result = mysqli_query($conn , $query);
                    // Ελεγχει αν υπαρχει η εγγραφη στο database
                    if($result && mysqli_num_rows($result) > 0)
                    {
                        $user_data  = mysqli_fetch_assoc($result);
                        return $user_data;
                    }
                }
                // Αν δεν εχει οριστει το SESSION με το user_id εκεινου που εκανε log in τοτε σε πηγαινει παλι στο home1.php
                header("Location: home1.php");
                die;

            }
            
            $user_data   = check_login($conn);



            // Εδω γινεται η αλλαγη στα στοιχεια των reservations απο τον admin
            if (isset($_POST['reservation_id'])&&isset($_POST['screening_screening_id'])&&isset($_POST['user_user_id'])&&isset($_POST['ticket_amount'])&&isset($_POST['movie_movie_id'])){

                $queryUpdateReservation="UPDATE reservation SET reservation_id='" . $_POST['reservation_id'] . "' ,screening_screening_id='" . $_POST['screening_screening_id'] . "' ,user_user_id='" . $_POST['user_user_id'] . "' ,ticket_amount='" . $_POST['ticket_amount'] . "',movie_movie_id='" . $_POST['movie_movie_id'] . "' WHERE reservation_id='" . $_POST['reservation_id'] . "'";
                echo ($queryUpdateReservation);
                $resultUpdateReservation = $conn->query($queryUpdateReservation);

                if(!$resultUpdateReservation) echo ("failed").$conn->error."<br><br>";
                header("Location: admin.php");
            }
          
            

        ?>

    </head>
    <body onload="fillReservationFormValues()">
        <header>
            <img src="images\pngwing.com.png" width="125" height="110"><div class="header">Settlement<br>Cinemas</div>
        </header>
        <div id="nav">
            <ul>

                <div id="signup">
                    <li class="user_welcome">
                        <?php
                            echo "Logged in as: ".$user_data['user_username']."";
                        ?>
                    </li>
                    <li >
                    <!-- Log out button που σε πεταει στο log_out.php -->
                    <a href="log_out.php">Log out</a>
                </li>
                </div>
                
                
            </ul>
        </div>

    

    <div class="wrapper">
        <div id="inner" style="padding-top: 10px;">
            <div class="flex-container-row">
            <!-- Υπαρχει προβλημα οταν στο input παει να μπει κειμενο με αποστροφο ' μεσα καθως μπερδευει το που τελειωνει το text -->

            <?php 
             /*συμπληρωνει στην φορμα τα στοιχεια του ωστα να κανει αλλαγες. Ξανα τρεχει μεσα στο script η βαση δεδομενων για να συγκρινει το id απτο GET και  συμπληρωνει τα στοιχεια
            στο script. υπαρχει μια String() function που αλλαζει τα τεξτ σε string γιατι επιστρεφουν ως κατι διαφορετικο και αλλιως δεν εμφανιζονται*/
                echo "
                    <form class='movies' method='post' action='update_reservation.php'>
                    <div class='container'>
                    <h1>Reservation Update</h1>
                    <hr>

                    <label for='reservation_id'><b>Reservation ID:</b></label>
                    <input id='selectReservation_id' type='text' placeholder='ID' name='reservation_id' readonly style='background-color:#c4c4c4;'>  

                    <br>
                    <br>

                    <label for='screening_screening_id'><b>Screening's Id:</b></label>
                    <select id='selectScreening_id' name='screening_screening_id'>";
                    

                    // Εμφανιζει τις διαθεσιμες ωρες απο τα screenings για να γινει καποιο update στο reservation
                    $sqlScreenings = "select * from screening";
                    $resultScreenings=$conn->query($sqlScreenings);
                        if(!$resultScreenings) die($conn->error);
                            while($row=$resultScreenings->fetch_array(MYSQLI_ASSOC)){
                                echo "<option value='".$row['screening_id']."'>".$row['screening_time']."</option><br>";
                            }
                    
                    echo "</select>
                    <br>
                    <br>
                    <br>


                    <label for='user_user_id'><b>User's Id:</b></label>
                    <input id='selectUser_id' type='text' placeholder='Director' name='user_user_id' readonly style='background-color:#c4c4c4;'>

                    <label for='ticket_amount'><b>Amount of Tickets:</b></label>
                    <input id='selectTicket_amount' type='text' placeholder='Tickets' name='ticket_amount' >

                    <label for='movie_movie_id'><b>Movie's Id:</b></label>
                    <input id='selectMovie_id' type='text' placeholder='Movie Id' name='movie_movie_id' readonly style='background-color:#c4c4c4;'>

                    <script defer>

                    ";
                    // function που γεμιζει τα labels αναλογα με το id που παιρνει το GET
                    echo"
                    
                        function fillReservationFormValues() {
                            ";

                            $id= $_GET['id'];
                            $sql2 = "select * from reservation";
                            $result4=$conn->query($sql2);

                            if(!$result4) die($conn->error);
                            while($row=$result4->fetch_array(MYSQLI_ASSOC)){
                                echo "if( String('$id') === String('".$row['reservation_id']."')){
                                    document.getElementById('selectReservation_id').value = String('".$row['reservation_id']."');
                                    document.getElementById('selectScreening_id').value = String('".$row['screening_screening_id']."');
                                    document.getElementById('selectUser_id').value = String('".$row['user_user_id']."');
                                    document.getElementById('selectTicket_amount').value = String('".$row['ticket_amount']."');
                                    document.getElementById('selectMovie_id').value = String('".$row['movie_movie_id']."');
                                }";
                            }

                    echo "};
                    </script>
                   
                    
                    

                    <button type='submit' class='signup'>Make changes</button>
                    
                    <br>
                    ";
                    ?>
                    <!-- Cancel Button για το User Management -->
                    <br>
                    <button type="button" onclick="location.href='admin.php'" class="cancelbutton">Cancel</button>
                    <?php
                    echo "
                    

                    </div>
                    </form>
                </div>";

            ?>
                    

            </div>
        </div>
        
    </div>


        <footer>
            <div class="flex-container">
                <div style="flex-grow: 2; align-self: center;">
                    <h1 id="footer">Social Media:</h1>
                    <a href="https://twitter.com/dsunipigr" target="_blank"><img src="https://play-lh.googleusercontent.com/x3XxTcEYG6hYRZwnWAUfMavRfNNBl8OZweUgZDf2jUJ3qjg2p91Y8MudeXumaQLily0" width="55px" height="49px"> </a> 
                    <a href="https://instagram.com/unipi.ds?igshid=YmMyMTA2M2Y=" target="_blank"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e7/Instagram_logo_2016.svg/2048px-Instagram_logo_2016.svg.png" width="55px" height="49px"> </a> 
                    <a href="https://www.facebook.com/ds.unipi.gr" target="_blank"><img src="https://seeklogo.com/images/F/facebook-logo-C64946D6D2-seeklogo.com.png" width="55px" height="49px"> </a>
                </div>
                <div style="flex-grow: 2;align-self: center;">                           
                    <h1 id="footer">Στοιχεία Επικοινωνίας</h1>
                    <p> Διεύθυνση: Δρόμος, Πόλη, Χώρα</p>
                    <p>Τηλέφωνο:<a href="tel:+1234-567-8910"> 123-456-7899</a> </p>
                    <p>E-mail:<a href="mailto: someone@example.com"> someone@example.com</a></p>
                </div>
                <div style="flex-grow: 2; align-self: center;"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12586.102080772627!2d23.6528681!3d37.9415137!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3e0dce8e58812705!2zzqDOsc69zrXPgM65z4PPhM6uzrzOuc6_IM6gzrXOuc-BzrHOuc-Oz4I!5e0!3m2!1sel!2sgr!4v1660049594308!5m2!1sel!2sgr" width="315" height="215" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                </div>
            </div>
        </footer>

    </body>
</html>
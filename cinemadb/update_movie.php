<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css\styles.css">
        <script src="js/script.js" defer></script>

        <!-- το style υπαρχει εδω ωστε να δουλευει και στο Microsoft Edge -->
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
                    $query = "select * from user where user_id = $id limit 1";

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



            // Εδω γινεται η αλλαγη στα στοιχεια του χρηστη απο τον admin
            if (isset($_POST['movie_id'])&&isset($_POST['movie_name'])&&isset($_POST['movie_director'])&&isset($_POST['movie_desc'])){

                $queryUpdateMovie="UPDATE movie SET movie_id='" . $_POST['movie_id'] . "' ,movie_name='" . $_POST['movie_name'] . "' ,movie_director='" . $_POST['movie_director'] . "' ,movie_desc='" . $_POST['movie_desc'] . "' WHERE movie_id='" . $_POST['movie_id'] . "'";
                echo ($queryUpdateMovie);
                $resultUpdateMovie = $conn->query($queryUpdateMovie);

                if(!$queryUpdateMovie) echo ("failed").$conn->error."<br><br>";
                header("Location: admin.php");
            }
          
            

        ?>

    </head>
    <body onload="fillMovieFormValues()">
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
                    <form class='movies' method='post' action='update_movie.php'>
                    <div class='container'>
                    <h1>Movie Update</h1>
                    <hr>

                    <label for='movie_id'><b>Movie's ID:</b></label>
                    <input id='selectMovie_id' type='text' placeholder='ID' name='movie_id' readonly style='background-color:#c4c4c4;'>  

                    <br>
                    <br>

                    <label for='movie_name'><b>Title:</b></label>
                    <input id='selectMovie_name' type='text' placeholder='Title' name='movie_name' >

                    <label for='movie_director'><b>Director:</b></label>
                    <input id='selectMovieDirector' type='text' placeholder='Director' name='movie_director' >

                    <label for='movie_desc'><b>Description:</b></label>
                    <input id='selectMovie_desc' type='text' placeholder='Description' name='movie_desc' >

                    <script defer>

                    ";
                    // function που γεμιζει τα labels αναλογα με το id που παιρνει το GET
                    echo"
                    
                        function fillMovieFormValues() {
                            ";

                            $id = $_GET['id'];
                            $sql2 = "select * from movie";
                            $result4=$conn->query($sql2);

                            if(!$result4) die($conn->error);
                            while($row=$result4->fetch_array(MYSQLI_ASSOC)){
                                echo "if(String('$id') === String('".$row['movie_id']."')){
                                    document.getElementById('selectMovie_id').value = String('".$row['movie_id']."');
                                    document.getElementById('selectMovie_name').value = String('".$row['movie_name']."');
                                    document.getElementById('selectMovieDirector').value = String('".$row['movie_director']."');
                                    document.getElementById('selectMovie_desc').value = String('".$row['movie_desc']."');
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
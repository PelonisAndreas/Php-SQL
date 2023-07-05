<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css\styles.css">
        <script src="js/script.js" defer></script>

        <!-- Ticket +/- Quantity Button -->
        <style>
            /* Chrome, Safari, Edge, Opera /
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }
            */

            input[type=number] {
                -webkit-appearance: textfield;
                -moz-appearance: textfield;
                appearance: textfield;
            }
            .button{
                color: green;
                font-size: 30px;
                border-radius: 2px;
                padding:3px;
                margin: 3px;
                user-select: none;
                }
                .button:hover{
                background-color: grey;
                cursor: pointer;
                }

              
            .cancelbutton{
                display: block;
                padding: 15px;
                color: white;
                text-decoration: none;
                background-color:  #ff0000;
                border-radius: 10px;
                border: transparent;
                cursor: pointer; 
                width: 40%;
            }
       
        </style>

        <?php require_once('common.php');
            session_start();

            function random_num(){
                $var = rand(1,10000);
                return $var;
            }

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
          
            
            /////////// MOVIE
            // pairnei apto url to id kai me vasi auto ftiaxnei kati variables pou ta xrhsimopoioume kato gia na emfanisoume alles plirofories
            if (isset($_GET['id'])) {
                $movie_id = $_GET['id'];
                $sql = "SELECT * FROM movie WHERE movie_id = $movie_id";
                $result2 = $conn->query($sql);

                if ($result2->num_rows > 0) {
                    $row = $result2->fetch_assoc();
                    $movie_name = $row["movie_name"];
                    $movie_director = $row["movie_director"];
                    $movie_desc = $row['movie_desc'];
                    
                }
            }

            if (isset($_POST['ticketAmount'])&&isset($_POST['screening_id'])){
                $ticket_amount = $_POST['ticketAmount'];
                $reservation_id= random_num();
                $screening_screening_id = $_POST['screening_id'];
                $user_user_id = $user_data['user_id'];

                $query3="INSERT into reservation values"."('$reservation_id','$screening_screening_id', '$ticket_amount', '$movie_id','$user_user_id')";
                echo ($query3);
                $result4 = $conn->query($query3);


                if(!$query3) echo ("failed").$conn->error."<br><br>";
                header("Location: log_in.php");

            }

        ?>

       
        


    </head>
    <body>
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

            <?php 
            // Εμφανιζει το ονομα και την εικονα της επιλεγμενης ταινιας
                echo "
                
                <div class='movies' style='border: 3px solid orange; width: 300px; height: auto; text-align: center; background-color: lightyellow; border-radius: 6px; margin-left:5px; margin-right:5px;'>
                    <div class='item'>
                        <h2>". $movie_name . "</h2>
                        <img src='images/$row[movie_name].png' width=270 height=400 style='margin-top: 10px;'>
                    </div>
                </div>
                <div class='movies' >
                    <br>
                    <br>
                    <br>
                    <label for='user_name'><b>Director: </b>".$movie_director."</label>
                        
                    <br>
                    <br>
                    <br>

                    <label for='user_name'><b>Description: </b><p style='font-size: 18px'>".$movie_desc."</p></label>
                    
                    
                </div>
                <div style='margin-left: 25px'>
                    <form class='movies' method='post' action='tickets.php?id=$movie_id'>
                    <div class='container'>
                    <h1>Buy Tickets</h1>
                    <hr>
                   
                    <label for='user_name'><b>Screening Time:</b></label>

                    <select id='screening_time' name='screening_id'>";

                    // Τα screening_time εμφανιζονται αναλογα το movie_id
                    $sql = "select * from screening where movie_movie_id =$movie_id ";
                    $result3=$conn->query($sql);
                    if(!$result3) die($conn->error);
                    while($row=$result3->fetch_array(MYSQLI_ASSOC)){
                        echo "<option value='".$row['screening_id']."'>".$row['screening_time']."</option>";
                    }

                    echo "</select>
         
                    <br>
                    <br>
                    <br>

                    <input type='number' id='ticketAmount' name='ticketAmount' value='1'>
                    <a class='button' onclick='ticketPlus();'>+</a>
                    <a class='button' onclick='ticketMinus();'>-</a>

                    <script>
                    function ticketMinus() {
                        temp = document.getElementById('ticketAmount').value;
                        if(temp>1){
                        document.getElementById('ticketAmount').value = temp-1;
                        }
                    }

                    function ticketPlus() {
                        temp = document.getElementById('ticketAmount').value;
                        document.getElementById('ticketAmount').value = parseInt(temp)+1;
                    }
                    </script>
                    <br>
                    <br>
                    <br>
                    
                    <button id='tickets_button' type='submit'>Buy tickets</button>
                    ";
                    ?>
                    <!-- Cancel Button -->
                    <br>
                    <button type="button" onclick="location.href='log_in.php'" class="cancelbutton">Cancel</button>
                    <?php
                    echo "

                    </div>
                    </form>
                </div>";
                    // Χρησιμοποιειται Js για να επιλεχθει το πληθος των ticket
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
                    <h1 id="footer">Στοιχεια Επικοινωνιας</h1>
                    <p> Διευθυνση: Δρομος, Πολη, Χωρα</p>
                    <p>Τηλεφωνο:<a href="tel:+1234-567-8910"> 123-456-7899</a> </p>
                    <p>E-mail:<a href="mailto: someone@example.com"> someone@example.com</a></p>
                </div>
                <div style="flex-grow: 2; align-self: center;"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12586.102080772627!2d23.6528681!3d37.9415137!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3e0dce8e58812705!2zzqDOsc69zrXPgM65z4PPhM6uzrzOuc6_IM6gzrXOuc-BzrHOuc-Oz4I!5e0!3m2!1sel!2sgr!4v1660049594308!5m2!1sel!2sgr" width="315" height="215" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                </div>
            </div>
        </footer>

    </body>
</html>
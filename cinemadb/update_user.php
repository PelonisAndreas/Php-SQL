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
                background-color:  #ff0000;
                border-radius: 10px;
                border: transparent;
                cursor: pointer; 
                width: 8.2%;
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
      

        ?>

    </head>
    <body onload="fillUserFormValues()">
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
             /*συμπληρωνει στην φορμα τα στοιχεια του ωστα να κανει αλλαγες. Ξανα τρεχει μεσα στο script η βαση δεδομενων για να συγκρινει το id απτο GET και  συμπληρωνει τα στοιχεια
            στο script. υπαρχει μια String() function που αλλαζει τα τεξτ σε string γιατι επιστρεφουν ως κατι διαφορετικο και αλλιως δεν εμφανιζονται*/
                echo "
                    <form class='movies' method='post' action='admin.php'>
                    <div class='container'>
                    <h1>User Update</h1>
                    <hr>


                    <label for='user_username'><b>Username:</b></label>
                    <input id='selectUser_username' type='text' placeholder='Username' name='user_username' >

                    <label for='user_id'><b>User's ID:</b></label>
                    <input id='selectUser_id' type='text' placeholder='ID' name='user_id' readonly style='background-color:#c4c4c4;'>  

                    <label for='user_role'><b>Role:</b></label>
                    <select id='selectUser_role' name='user_role'>
                        <option value='not_assigned'>not_assigned</option>
                        <option value='User'>User</option>
                        <option value='Admin'>Admin</option>
                    </select>
                    <br>
                    <br>

                    <label for='user_email'><b>Email:</b></label>
                    <input id='selectUser_email' type='text' placeholder='Email' name='user_email' >

                    <label for='user_name'><b>Name:</b></label>
                    <input id='selectUser_name' type='text' placeholder='Name' name='user_name' >

                    <label for='user_surname'><b>Surname:</b></label>
                    <input id='selectUser_surname' type='text' placeholder='Surname' name='user_surname' >

                    <label for='user_country'><b>Country:</b></label>
                    <input id='selectUser_country' type='text' placeholder='Country' name='user_country' >

                    <label for='user_city'><b>City:</b></label>
                    <input id='selectUser_city' type='text' placeholder='City' name='user_city' >

                    <label for='user_address'><b>Address:</b></label>
                    <input id='selectUser_address' type='text' placeholder='Address' name='user_address' >

                    <script defer>
                    
                    ";
                    // function που γεμιζει τα labels αναλογα με το id που παιρνει το GET
                    echo"
                    
                    function fillUserFormValues() {
                        ";
                       
                        $id = $_GET['id'];
                        
                        $sql2 = "select * from user having user_id ='$id'";
                        $result4=$conn->query($sql2);

                        

                        if(!$result4) die($conn->error);
                        while($row=$result4->fetch_array(MYSQLI_ASSOC)){
                            echo "if(String('$id') === String('".$row['user_id']."')){
                                document.getElementById('selectUser_username').value = String('".$row['user_username']."');
                                document.getElementById('selectUser_id').value = String('".$row['user_id']."');
                                document.getElementById('selectUser_role').value = String('".$row['user_role']."');
                                document.getElementById('selectUser_email').value = String('".$row['user_email']."');
                                document.getElementById('selectUser_name').value = String('".$row['user_name']."');
                                document.getElementById('selectUser_surname').value = String('".$row['user_surname']."');
                                document.getElementById('selectUser_country').value = String('".$row['user_country']."');
                                document.getElementById('selectUser_city').value = String('".$row['user_city']."');
                                document.getElementById('selectUser_address').value = String('".$row['user_address']."');}";
                        }

                    echo "}</script>
                                     

                    <button type='submit' class='signup'>Make changes</button>
                    ";
                    ?>
                    <!-- Cancel Button για το User Management -->
                    <br>
                    <button type="button" onclick="location.href='admin.php'" class="cancelbutton">Cancel</button>
                    <?php
                    echo "
                    <br>
                    

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
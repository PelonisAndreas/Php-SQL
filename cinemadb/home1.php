<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css\styles.css">
        <script src="js/script.js" defer></script>

        <?php require_once('common.php');

        session_start();
        $_SESSION;

        function random_num(){
            $var = rand(1,9999999999);
            return $var;
        }
        
            $user_role ="not_assigned";

                // Sign_up ενος user            
                if (isset($_POST['user_name'])&&isset($_POST['user_surname'])&&isset($_POST['user_country'])&&isset($_POST['user_city'])&&isset($_POST['user_address'])&&isset($_POST['user_email'])&&isset($_POST['user_username'])&&isset($_POST['user_password'])){
                    $user_id= uniqid();
                    $user_name=$_POST['user_name'];
                    $user_surname=$_POST['user_surname'];
                    $user_country=$_POST['user_country'];
                    $user_city=$_POST['user_city'];
                    $user_address=$_POST['user_address'];
                    $user_email=$_POST['user_email'];
                    $user_username=$_POST['user_username'];
                    $user_password=$_POST['user_password'];
                    
            
                    $query="INSERT into user values"."('$user_id','$user_name', '$user_surname', '$user_country', '$user_address', '$user_email', '$user_username', '$user_password', '$user_role', '$user_city')";
                    echo ($query);
                    $result = $conn->query($query);

                    if(!$query) echo ("failed").$conn->error."<br><br>";
                }

                // Ελεγξε αν στο log-in modal εχει τιμες
                if (isset($_POST['log_username'])&&isset($_POST['log_password'])){
                    $log_username = $_POST['log_username'];
                    $log_password = $_POST['log_password'];

                    $query2 = "select * from user where user_username = '$log_username' limit 1";
                    $result2 = mysqli_query($conn, $query2);

                    if($result2)
                    {
                        // Ελεγχει αν υπαρχει η εγγραφη στο database
                        if($result2 && mysqli_num_rows($result2) > 0)
                        {
                            // Περναει τα αποτελεσματα στην μεταβλητη $user_data
                            $user_data  = mysqli_fetch_assoc($result2);
                                
                            // Ελεγχει αν το password του user ειναι αυτο που εχει το modal
                            if($user_data['user_password'] === $log_password)
                            {
                                // Δημιουργει το Session με το id του user που εκανε log in
                                $_SESSION['user_id'] = $user_data['user_id'];
                                
                                header("Location: log_in.php");
                                die;
                            }
                            
                        }
                    }
                    // Σε περιπτωση που μπουν λαθος στοιχεια
                    echo "<script>alert('Wrong Username or Password!')</script>";  
                    
                    
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
                    <li><button onclick="document.getElementById('id02').style.display='block'">Log In</button></li>
                    <li><button onclick="document.getElementById('id01').style.display='block'">Sign Up</button></li>
                </div>
            </ul>
        </div>

     <div class="wrapper">
        <div id="id01" class="modal">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">X</span>
                <form class="modal-content" action="home1.php" method="post">
                    <div class="container">
                    <h1>Sign Up</h1>
                    <p>Please fill in this form to create an account.</p>
                    <hr>
                    

                   <!-- Sign UP Modal -->
                   <label for="user_name"><b>Name:</b></label>
                    <input type="text" placeholder="Enter your Name" name="user_name" required>

                    <label for="user_surname"><b>Surname:</b></label>
                    <input type="text" placeholder="Enter your Surname" name="user_surname" required>  

                    <label for="countries"><b>Country:</b></label>
                    <select onmouseup="showCities();" class="text" name="user_country" id="countries" ></select>
        
                    <br>
                    <br>

                    <label for="cities"><b>City:</b></label>
                    <select class="text" name="user_city" id="cities"></select>

                    <br>
                    <br>

                    <label for="address"><b>Address:</b></label>
                    <input type="text" placeholder="Type your Address" name="user_address" required>

                    <label for="user_email"><b>Email:</b></label>
                    <input type="text" placeholder="Enter your Email" name="user_email" required>

                    <label for="user_username"><b>Username:</b></label>
                    <input type="text" placeholder="Type your Username" name="user_username" required>

                    <label for="user_password"><b>Password:</b></label>
                    <input type="password" placeholder="Type your Password" name="user_password" required>
                    <!-- To type="password" krivei to input -->

                    <label>
                        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
                    </label>

                    <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

                    <div class="clearfix">
                        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                        <button type="submit" class="signup">Sign Up</button>
                    </div>
                    </div>
                </form>
                </div>

                <!-- LOGIN -->
                <div id="id02" class="modal">
                    <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">X</span>
                    <form class="modal-content" action="home1.php" method="post">
                        <div class="container">
                        <h1>Log in</h1>
                        <p>Please fill in the blanks to Log in</p>
                        <hr>
                        

                    <!-- log in Modal -->
                        <label for="user_username"><b>Username:</b></label>
                        <input type="text" placeholder="Type your Username" name="log_username" required>

                        <label for="user_password"><b>Password:</b></label>
                        <input type="password" placeholder="Type your Password" name="log_password" required>

                        <div class="clearfix">
                            <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
                            <button type="submit" class="signup">Log In</button>
                        </div>
                        </div>
                    </form>
                </div>


         <div id="inner" style="padding-top: 10px;">
            <div class="flex-container-row">
                    <?php
                    $sql='select * from movie';
                    $result=$conn->query($sql);
                    if (!$result) die($conn->error);

                    // Εμφανιση ταινιων και redirect στο movie_desc.php αν πατηθει μια ταινια
                    while ($row=$result->fetch_array(MYSQLI_ASSOC)){
                        echo "<div class='movies' style='border: 3px solid orange; width: 180px; height: auto; text-align: center; background-color: lightyellow; border-radius: 6px; margin-left:5px; margin-right:5px;'>
                        <div class='item'><a href='movie_desc.php?id=".$row['movie_id']."' style='text-decoration: none'><img src='images/$row[movie_name].png' width=150 height=220 style='margin-top: 10px;'><br> ".$row['movie_name']."<br></a></div> </div>";
                    }
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



        <div id="nav">
            <ul>
                <div>
                    <li><button >Home</button></li>
                    <li><button >About Us</button></li>
                    <li><button >Events</button></li>
                    <li><button >Rate Us</button></li>
                    <li><button >Find an Event</button></li>
                    <li><button >History</button></li>
                </div>
                <div id="signup">
                    <li><button onclick="document.getElementById('id02').style.display='block'">Log In</button></li>
                    <li><button onclick="document.getElementById('id01').style.display='block'">Sign Up</button></li>
                </div>
            </ul>
        </div>
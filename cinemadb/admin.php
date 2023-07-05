<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css\styles.css">
        <script src="js/script.js" defer></script>

       


        <style>
            table{
                background-color: white;
                padding: 5px;
                margin: auto;
            }

            th{
                font-size: 18px;
                background-color: lightcoral;
                color: white;
                border-radius: 5px;
                padding-left: 50px;
                padding-right: 50px;
                text-align: center;
            }
            td{
                border-radius: 10px;
                padding: 5px;
                text-align: center;
            }
            td>a.update{
                font-family: cursive;
                text-decoration: none;
                padding: 5px;
                background-color: blue;
                color: white;
                border-radius: 5px;
                border:black solid 1px;
            }
            td>a.delete{
                font-family: cursive;
                text-decoration: none;
                padding: 5px;
                background-color: red;
                color: white;
                border-radius: 5px;
                border:black solid 1px;
            }
            a.create{
                font-family: cursive;
                text-decoration: none;
                padding: 5px;
                color: white;
                border-radius: 5px ;
                border:black solid 1px;
                background-color:#32CD30; 
                float:right;
                cursor: pointer;
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
            if (isset($_POST['user_username'])&&isset($_POST['user_id'])&&isset($_POST['user_role'])&&isset($_POST['user_email'])&&isset($_POST['user_name'])&&isset($_POST['user_surname'])&&isset($_POST['user_country'])&&isset($_POST['user_city'])&&isset($_POST['user_address'])){

                $query2="UPDATE user SET user_id='" . $_POST['user_id'] . "', user_name='" . $_POST['user_name'] . "', user_surname='" . $_POST['user_surname'] . "' ,user_country='" . $_POST['user_country'] . "' ,user_address='" . $_POST['user_address'] . "' ,user_email='" . $_POST['user_email'] . "' ,user_username='" . $_POST['user_username'] . "' ,user_role='" . $_POST['user_role'] . "' ,user_city='" . $_POST['user_city'] . "' WHERE user_id='" . $_POST['user_id'] . "'";
                echo ($query2);
                $result2 = $conn->query($query2);

                if(!$query2) echo ("failed").$conn->error."<br><br>";
        
            }

            function random_num(){
                $var = rand(1,999999999);
                return $var;
            }
            
                $user_role ="not_assigned";

            // o Admin κανει create καινουργιους users
            
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

            // o Admin κανει create καινουργια movies
            if (isset($_POST['movie_name'])&&isset($_POST['movie_director'])&&isset($_POST['movie_desc'])){
                $movie_id= random_num();
                $movie_name=$_POST['movie_name'];
                $movie_director=$_POST['movie_director'];
                $movie_desc=$_POST['movie_desc'];
                
        
                $query="INSERT into movie values"."('$movie_id','$movie_name', '$movie_director', '$movie_desc')";
                echo ($query);
                $result = $conn->query($query);

                if(!$query) echo ("failed").$conn->error."<br><br>";
            }
          
            // o Admin κανει create καινουργια screenings
            if (isset($_POST['screening_tickets'])&&isset($_POST['movie_movie_id'])&&isset($_POST['screening_time'])){
                $screening_id= random_num();
                $screening_tickets=$_POST['screening_tickets'];
                $movie_movie_id=$_POST['movie_movie_id'];
                $screening_time=$_POST['screening_time'];
                
        
                $query="INSERT into screening values"."('$screening_id','$screening_tickets', '$movie_movie_id', '$screening_time')";
                echo ($query);
                $result = $conn->query($query);

                if(!$query) echo ("failed").$conn->error."<br><br>";
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

        <!--USER MANAGEMENT WITH MODAL FOR CREATE USER-->
        <div id="id01" class="modal">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">X</span>
                <form class="modal-content" action="admin.php" method="post">
                    <div class="container">
                    <h1>Create User</h1>
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

                   


                    <div class="clearfix">
                        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                        <button type="submit" class="signup">Create User</button>
                    </div>
                    </div>
                </form>
                </div>

        <div id="inner" style="padding-top: 10px;">

        <a class="create" onclick="document.getElementById('id01').style.display='block'" style="background-color:#32CD30; float:right;">Create User</a>

    
        <h3 style='text-align:center; font-family: cursive; color:lightcoral; text-decoration:underline blue solid;'>USER MANAGEMENT</h3>

            <div class="flex-container-row">
            <?php 
            $sqlUserManagement = "select * from user";

            $resultUserManagement = $conn->query($sqlUserManagement);

                echo "
                <table class='table'>
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Username</th> 
                        <th>Last Name</th>  
                        <th>Email</th>    
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody> ";
                            if ($resultUserManagement->num_rows > 0) {
                                while ($row = $resultUserManagement->fetch_assoc()) {
                                    echo"
                                    <tr>
                                    <td>".$row['user_id']."</td>
                                    <td>".$row['user_username']."</td>
                                    <td>".$row['user_surname']."</td>
                                    <td>".$row['user_email']."</td>
                                    <td>".$row['user_role']."</td>
                                    <td><a class='update' href='update_user.php?id=".$row['user_id']."'>Edit</a>&nbsp;<a class='delete' href='delete_user.php?id=".$row['user_id']."'>Delete</a></td>
                                    </tr>                       
                                    ";
                                }
                                echo "<br>";
                            }
                            echo "</tbody>
                            </table>";
            ?>      

            </div>
            <br> <br> <br> <br> <br>
            <!--MOVIE MANAGEMENT WITH MODAL FOR CREATE MOVIE-->
        <a class="create" onclick="document.getElementById('id03').style.display='block'">Create Movie</a>
        <div id="id03" class="modal">
                <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">X</span>
                <form class="modal-content" action="admin.php" method="post">
                    <div class="container">
                    <h1>Create Movie</h1>
                    <hr>                  

                   <!-- Create Movie Modal -->
                   <!-- Υπαρχει προβλημα οταν στο description παει να μπει κειμενο με αποστροφο ' μεσα καθως το μπερδευει το που τελειωνει το text -->
                   <label for="movie_name"><b>Movie Name:</b></label>
                    <input type="text" placeholder="Enter Movie's Name" name="movie_name" required>

                    <label for="movie_director"><b>Movie Director:</b></label>
                    <input type="text" placeholder="Enter Movie's Director" name="movie_director" required>  

                    <label for="movie_desc"><b>Movie Description:</b></label>
                    <input type="text" placeholder="Enter Movie's Description" name="movie_desc" required>  
        
                    <br>
                    <br>
                   


                    <div class="clearfix">
                        <button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn">Cancel</button>
                        <button type="submit" class="signup">Create Movie</button>
                    </div>
                    </div>
                </form>
                </div>


            <h3 style='text-align:center; font-family: cursive; color:lightcoral; text-decoration:underline blue solid;'>MOVIE MANAGEMENT</h3>

            <div class="flex-container-row">
            <?php 
            $sqlMovieManagement = "select * from movie";

            $resultMovieManagement = $conn->query($sqlMovieManagement);

                echo "
                <table class='table'>
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Movie Name</th> 
                        <th>Director's Name</th>  
                        <th>Description</th>    
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody> ";
                            if ($resultMovieManagement->num_rows > 0) {
                                while ($row = $resultMovieManagement->fetch_assoc()) {
                                    echo"
                                    <tr>
                                    <td>".$row['movie_id']."</td>
                                    <td>".$row['movie_name']."</td>
                                    <td>".$row['movie_director']."</td>
                                    <td>".$row['movie_desc']."</td>
                                    <td><a class='update' href='update_movie.php?id=".$row['movie_id']."'>Edit</a>&nbsp;<a class='delete' href='delete_movie.php?id=".$row['movie_id']."'>Delete</a></td>
                                    </tr>                       
                                    ";
                                }
                                echo "<br>";
                            }
                            echo "</tbody>
                            </table>";
            ?>      

            </div>

            <br> <br> <br> <br> <br>
            
            <h3 style='text-align:center; font-family: cursive; color:lightcoral; text-decoration:underline blue solid;'>RESERVATION MANAGEMENT</h3>

            <div class="flex-container-row">
            <?php 
            $sqlReservationManagement = "select * from reservation";

            $resultReservationManagement = $conn->query($sqlReservationManagement);

                echo "
                <table class='table'>
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Screening Id</th> 
                        <th>User</th>
                        <th>Tickets</th> 
                        <th>Movie ID</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody> ";
                            if ($resultReservationManagement->num_rows > 0) {
                                while ($row = $resultReservationManagement->fetch_assoc()) {
                                    echo"
                                    <tr>
                                    <td>".$row['reservation_id']."</td>
                                    <td>".$row['screening_screening_id']."</td>

                                    ";

                                    //  Τρεχοντας ενα ακομη sql query παιρνουμε τιμες του table user για να εμφανισουμε το user_username, αντι για το element user_user_id του table reservation
                                    $sqluserid ="select user_username from user where user_id='".$row['user_user_id']."'";
                                    $resultUserid=$conn->query($sqluserid);
                                    $row1 = $resultUserid->fetch_assoc();
                                    echo "

                                    <td>".$row1['user_username']."</td>

                                    <td>".$row['ticket_amount']."</td>
                                    <td>".$row['movie_movie_id']."</td>
                                    <td><a class='update' href='update_reservation.php?id=".$row['reservation_id']."'>Edit</a>&nbsp;<a class='delete' href='delete_reservation.php?id=".$row['reservation_id']."'>Delete</a></td>
                                    </tr>                       
                                    ";
                                }
                                echo "<br>";
                            }
                            echo "</tbody>
                            </table>";
            ?>      

            </div>

            <br> <br> <br> <br> <br>
            
            <!--Screening MANAGEMENT WITH MODAL FOR CREATE MOVIE-->
        <a class="create" onclick="document.getElementById('id06').style.display='block'">Create Screening</a>
        <div id="id06" class="modal">
                <span onclick="document.getElementById('id06').style.display='none'" class="close" title="Close Modal">X</span>
                <form class="modal-content" action="admin.php" method="post">
                    <div class="container">
                    <h1>Create Screening</h1>
                    <hr>                  

                   <!-- Create Screening Modal -->
                    <label for="screening_tickets"><b>Screening Tickets:</b></label>
                    <input type="text" placeholder="Screening Tickets" name="screening_tickets" required>  

                    <label for="movie_id"><b>Movie Id:</b></label>
                    <!-- Εμφανιζονται οι ταινιες σε ενα dropdown menu για να επιλεξει για πιο θα δημιουργηθει το screening -->
                    <select id='selectMovie_id' name='movie_movie_id'>
                        <?php
                        $sqlMovie = "select * from movie";
                        $resultMovies=$conn->query($sqlMovie);
                            if(!$resultMovies) die($conn->error);
                                while($row=$resultMovies->fetch_array(MYSQLI_ASSOC)){
                                    echo "<option value='".$row['movie_id']."'>".$row['movie_name']."</option><br>";
                                }
                        ?>
                    </select> 

                    <br>
                    <br>

                    <label for="screening_time"><b>Screening Time:</b></label>
                    <input type="text" placeholder="Screening Time" name="screening_time" required>  
        
                    <br>
                    <br>
                   


                    <div class="clearfix">
                        <button type="button" onclick="document.getElementById('id06').style.display='none'" class="cancelbtn">Cancel</button>
                        <button type="submit" class="signup">Create</button>
                    </div>
                    </div>
                </form>
            </div>
            <h3 style='text-align:center; font-family: cursive; color:lightcoral; text-decoration:underline blue solid;'>SCREENING MANAGEMENT</h3>

            <div class="flex-container-row">
            <?php 
            $sqlScreeningManagement = "select * from screening";

            $resultScreeningManagement = $conn->query($sqlScreeningManagement);

                echo "
                <table class='table'>
                    <thead>
                        <tr>
                        <th>Screening ID</th>
                        <th>Screening Tickets</th> 
                        <th>Movie</th>
                        <th>Screening Time</th> 
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody> ";
                            if ($resultScreeningManagement->num_rows > 0) {
                                while ($row = $resultScreeningManagement->fetch_assoc()) {
                                    echo"
                                    <tr>
                                    <td>".$row['screening_id']."</td>
                                    <td>".$row['screening_tickets']."</td>

                                    ";

                                    //  Τρεχοντας ενα ακομη sql query παιρνουμε τιμες του table movie για να εμφανισουμε το movie_name, αντι για το element  movie_movie_id του table screening
                                    $sqlmovie_name ="select movie_name from movie where movie_id=".$row['movie_movie_id']."";
                                    $resultMovie_name=$conn->query($sqlmovie_name);
                                    $row1 = $resultMovie_name->fetch_assoc();
                                    echo "

                                    <td>".$row1['movie_name']."</td>

                                    <td>".$row['screening_time']."</td>
                                    <td><a class='update' href='update_screening.php?id=".$row['screening_id']."'>Edit</a>&nbsp;<a class='delete' href='delete_screening.php?id=".$row['screening_id']."'>Delete</a></td>
                                    </tr>                       
                                    ";
                                }
                                echo "<br>";
                            }
                            echo "</tbody>
                            </table>";
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
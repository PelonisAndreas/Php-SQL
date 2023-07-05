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
                    </li>
                    <li >
                    <!-- Log out button που σε πεταει στο home1.php -->
                    <a href="home1.php">Go back</a>
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
               
                <div class='movies' style='border: 3px solid orange; width: 370px; height: auto; text-align: center; background-color: lightyellow; border-radius: 6px; margin-left:5px; margin-right:5px;'>
                    <div class='item'>
                        
                        <img src='images/$row[movie_name].png' width=320 height=460 style='margin-top: 10px;'>
                    </div>
                </div>
                <div>
                    <form class='movies' method='post' action='tickets.php?id=$movie_id'>
                    <div class='container'>
                    <h1>".$movie_name."</h1>
                    <hr>
                    

                   
                    <label for='user_name'><b>Director: </b>".$movie_director."</label>
                     
                    <br>
                    <br>
                    <br>

                    <label for='user_name'><b>Description: </b><p style='font-size: 18px'>".$movie_desc."</p></label>
                    
                    
                    <br>
                    <br>
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
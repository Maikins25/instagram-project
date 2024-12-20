<?php

/*************************************************************************************************
 * index.php
 *
 * Main page for the Hanover DPW Park Permitting application.
 *
 * This page will use the optional 'content' request parameter to include a specific page. If the
 * parameter is not specified then the default list page will be included.
 *************************************************************************************************/

include('library.php');

?>
<!DOCTYPE html>
<html>
    <head>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="style.css?v=<?php echo rand();?>" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

        <title>HHS Connect</title>
    </head>


<header class="header">
    <h1 class="header_logo"><a href="index.php"><img class="header_img"  src="images/hhsLogo.png" alt="hhsLogo"></a></h1>

    <nav class="header_nav">
        <ul class="header_ul">
                        
                        
                        
            <li>
                <a class="header_a" href="index.php?content=post">Make A Post</a>
            </li>
            
            <li>
                <a class="header_a" href="index.php?content=following">Follow Your Friends</a>
            </li>
            
            <?php
                         
                       if(isset($_SESSION['userId'])){
                      
                           $sql = <<<SQL
                           select user_username
                           from users
                           where user_id = $user
                           
                           
                           SQL;
                           
                           $conn = get_database_connection();
                           
                           $result = mysqli_query($conn, $sql);
                           $image_path = "profilePics/";
                           
                           while ($row = $result->fetch_assoc())
                           {
                                         
                                echo'<li>';
                                echo '<a class="header_a" href="index.php?content=settings">Account</a>';
                                echo'</li>';
                                  
                           }

                       }else{
                        echo '<div class="LogInDiv">';
                        echo '<a class="header_a" href = "index.php?content=Login">Log In</a>';
                        echo '</div>';

                        echo '<div class="LogInDiv">';
                        echo '<a class="header_a" href = "index.php?content=Register">Sign Up</a>';
                        echo '</div>';
                        
                       
                       }
                        
                        ?>


                    


        </ul>


    </nav>




</header>

<!-- style=" background-image: url('images/madeBackground.png' -->
    <body id="body" background="images/background.png" >
        
        <!-- Navigation -->
        <div>
            <!-- <nav class="navbar navbar-expand-lg bg-dark-subtle">
                
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        
                        
                        
                            <li class="nav-item1">
                                <a class="nav-link <?php print($content == 'post' ? 'active' : ''); ?>" href="index.php?content=post">Make A Post</a>
                            </li>
                            <li>
                                <a class="home-logo" href="index.php">
                                    <img width="150" src="images/hhsLogo.png"></img>
                                </a>
                            </li>
                            <li class="nav-item2">
                                    <a class="nav-link <?php print($content == 'following' ? 'active' : ''); ?>" href="index.php?content=following">Follow Your Friends</a>
                            </li>

                        


                        </ul>
                        <?php
                         
                       if(isset($_SESSION['userId'])){
                      
                           $sql = <<<SQL
                           select user_username
                           from users
                           where user_id = $user
                           
                           
                           SQL;
                           
                           $conn = get_database_connection();
                           
                           $result = mysqli_query($conn, $sql);
                           $image_path = "profilePics/";
                           
                           while ($row = $result->fetch_assoc())
                           {
                                  
                                  echo 'Logged in as ' .$row['user_username'];
                                 
                                  
   
                                  echo '<div class="username">';
                                  echo '<a href="index.php?content=settings"><img class="profilePic" src="' . $image_path . $user . '.png"></a>';
                                  echo '</div>';
                                  
                           }

                       }else{
                        echo '<div class="LogInDiv">';
                        echo '<a class="LogInButton" href = "index.php?content=Login">Log In</a>';
                        echo '</div>';

                        echo '<div class="LogInDiv">';
                        echo '<a class="LogInButton" href = "index.php?content=Register">Sign Up</a>';
                        echo '</div>';
                        
                        echo '<a href="index.php?content=settings"> <i class="fa fa-user-circle-o fa-3x profilePic " aria-hidden="true"></i> </a>';
                       
                       }
                        
                        ?>
                       
                </div>
            </nav> -->
        </div>

        <!-- Main Content -->
        
        <div >
           <?php 
           include(get_content() . '.php'); 
           
           
        //    if($content == 'index'){
        //        include('instaFeed.php');
               
        //    }
           ?>
       </div>
    </body>
</html>
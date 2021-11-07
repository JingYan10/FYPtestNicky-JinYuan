<?php
    session_start();
?>
|<?php
    include_once 'header.php';
?>
<link rel="stylesheet" href="header&footer.css">



            <!--content here-->
            <h1>Page Header</h1>
            <div class="container">
                
                <div class="removethis" style="margin-bottom: 1500px;"></div>                
            </div>
            <?php
            require_once 'includes/databaseHandler.inc.php';
            require_once 'includes/functions.inc.php';

           
            echo "friendCode : ".generateFriendCode($conn);
            ?>
<?php
    include_once 'footer.php';
?>
           

    
</body>
</html>
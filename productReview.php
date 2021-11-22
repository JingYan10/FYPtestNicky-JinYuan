<?php
// Start the session
session_start();
?>
<?php
include_once 'header.php';
?>
<!--link to css-->
<link rel="stylesheet" href="productReview.css">
<!--content here-->

<?php
include_once 'includes/databaseHandler.inc.php';



if (isset($_GET["productID"])) {
    $productID = $_GET["productID"];
    $sql = "SELECT * FROM product where productID='$productID';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $_SESSION["productID"] = $row["productID"];
            $_SESSION["productName"] = $row["productName"];
            $_SESSION["productImage"] = $row["productImage"];
            $_SESSION["productQuantity"] = $row["productQuantity"];
        }
    } else {
        echo "no data";
    }
}

?>

<section class="login-form">

    <div class="center">

        <form action="includes/productReview.inc.php" method="post">
            <div class="txt_field">
                <input type="hidden" name="productID" value="<?php echo $_SESSION['productID']; ?>">
                <p>Product ID : <?php echo "P00" . $_SESSION['productID']; ?></p>
            </div>
            <div class="txt_field">
                <p>Product Name : <?php echo $_SESSION['productName']; ?></p>
            </div>
            <div class="txt_field">
                <p>Product picture</p>
                <img style="width:140px;height:140px;" src="<?php echo $_SESSION['productImage']; ?>" alt="">
            </div>
            <div class="txt_field">
                <p>Product rating</p>
                <input type="hidden" name="rating" id="rating">
                <i class="fa fa-star fa-2x" data-index="0"></i>
                <i class="fa fa-star fa-2x" data-index="1"></i>
                <i class="fa fa-star fa-2x" data-index="2"></i>
                <i class="fa fa-star fa-2x" data-index="3"></i>
                <i class="fa fa-star fa-2x" data-index="4"></i>
            </div>
            <div class="txt_field">
                <p>Comments</p>

                <textarea type="text" rows="6" cols="40" name="productComment"></textarea>
            </div>
            <input type="submit" class="button" name="submit" value="submit">
        </form>



        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyInput") {
                echo "<div style='text-align:center;color:red;font-weight:600'>fill up the blank space</div>";
            } else if ($_GET["error"] == "wrongLogin") {
                echo "<div style='text-align:center;color:red;font-weight:600'>inccorect login</div>";
            }
        }
        ?>
    </div>

</section>

<div class="removethis" style="margin-bottom: 700px;"></div>

<!--footer-->
<?php
include_once 'footer.php';
?>

<script src="http://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
<script>
    var ratedIndex = -1,
        uID = 0;

    $(document).ready(function() {
        resetStarColors();

        if (localStorage.getItem('ratedIndex') != null) {
            setStars(parseInt(localStorage.getItem('ratedIndex')));
            uID = localStorage.getItem('uID');
        }

        $('.fa-star').on('click', function() {
            ratedIndex = parseInt($(this).data('index'));
            localStorage.setItem('ratedIndex', ratedIndex);
            $('#rating').val(ratedIndex);
        });

        $('.fa-star').mouseover(function() {
            resetStarColors();
            var currentIndex = parseInt($(this).data('index'));
            setStars(currentIndex);
        });

        $('.fa-star').mouseleave(function() {
            resetStarColors();

            if (ratedIndex != -1)
                setStars(ratedIndex);
        });


    });

    function setStars(max) {
        for (var i = 0; i <= max; i++)
            $('.fa-star:eq(' + i + ')').css('color', 'orange');
    }

    function resetStarColors() {
        $('.fa-star').css('color', 'black');
    }
</script>
</body>

</html>
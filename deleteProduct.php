<?php
session_start();
?>

<?php
include_once 'header.php';
?>

<!--link to css-->
<link rel="stylesheet" href="editProduct.css">

<!--content here-->

<?php
if (isset($_GET["error"])) {
    $_SESSION["productID"];
    $_SESSION["productName"];
    $_SESSION["productImage"];
    $_SESSION["productQuantity"];
    $_SESSION["productPrice"];
} else {
    $_SESSION["productID"] = $_GET["productID"];
    $_SESSION["productName"] = $_GET["productName"];
    $_SESSION["productImage"] = $_GET["productImage"];
    $_SESSION["productQuantity"] = $_GET["productQuantity"];
    $_SESSION["productPrice"] = $_GET["productPrice"];
}

?>


<section class="deleteProduct-form">
    <div class="center">
        <h1>Delete product</h1>
        <form action="includes/deleteProduct.inc.php" method="post" enctype="multipart/form-data" id="uniqueDeleteForm">
            <div class="txt_field">
                <p>Product ID : <?php echo "P00" . $_SESSION['productID']; ?></p>
                <input type="hidden" name="productID" value="<?php echo $_SESSION['productID']; ?>">
            </div>
            <div class="txt_field">
                <p>Product Name : <?php echo $_SESSION['productName']; ?></p>
            </div>
            <div class="txt_field">
                <p>Product picture</p>
                <img style="width:140px;height:140px;" src="<?php echo $_SESSION['productImage']; ?>" alt="">
            </div>
            <div class="txt_field">
                <p>Product quantity : <?php echo $_SESSION['productQuantity']; ?></p>
            </div>
            <div class="txt_field">
                <p>Product price : <?php echo $_SESSION['productPrice']; ?></p>
            </div>
            <button class="button" type="button" onclick="myFunction3()" >Delete</button>
        </form>

        <?php

        ?>
    </div>
</section>

<div class="removethis" style="margin-bottom: 700px;"></div>



<?php
include_once 'footer.php';
?>

<!--javascript-->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function myFunction3() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#uniqueDeleteForm").submit();
                console.log("testing");
            }
        })
    }
</script>
<!--for backtotop()-->
<script>
    var btn = $('#button');

    $(window).scroll(function() {
        if ($(window).scrollTop() > 300) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    });

    btn.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, '300');
    });
</script>
<!--for toggleMenu()-->
<script>
    $(document).ready(function() {
        $(".menu-icon").click(function() {
            $("#Menuitems").fadeToggle(200);
        });
    });

    $(window).bind("resize", function() {
        if ($(window).width() > 800)
            $("#Menuitems").css("display", "block");
        else
            $("#Menuitems").css("display", "none");
    });
</script>

</body>

</html>
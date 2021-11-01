<?php
// Start the session
session_start();
?>

<?php
    include_once 'header.php';
?>

<link rel="stylesheet" href="faq.css">
            <!--FAQ content-->
      
            <div class="container">


                <h1>FAQ ( Frequently Asked Question )</h1>

                <div class="spacing-top" style="margin-top: 50px;"></div>

                <div class="accordion-menu">
                    <ul>
                        <li>
                            <input type="checkbox" checked>
                            <i class="arrow"></i>
                            <h2><i class="fas fa-question"></i>Languages Used</h2>
                            <p>This UI was written in HTML and CSS.</p>
                        </li>
                        <li>
                            <input type="checkbox" checked>
                            <i class="arrow"></i>
                            <h2><i class="fas fa-question"></i>How it Works</h2>
                            <p>Using the sibling and checked selectors, we can determine 
                                the styling of sibling elements based on the checked state
                                of the checkbox input element. 
                            </p>
                        </li>
                        <li>
                            <input type="checkbox" checked>
                            <i class="arrow"></i>
                            <h2><i class="fas fa-question"></i>Points of Interest</h2>
                            <p>
                                By making the open state default for when :checked isn't 
                                detected, we can make this system accessable for browsers 
                                that don't recognize :checked.
                            </p>
                        </li>
                    </ul>

                    
                    
                </div>

<?php
    include_once 'footer.php';
?>
    
    <!--for faq()-->
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }
    </script>



</body>

</html>
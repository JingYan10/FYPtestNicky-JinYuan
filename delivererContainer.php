<div class="seller-container">
    <div class="product-container">
        <div class="productInfo">
            <?php
            $userEmail = $_SESSION["userEmail"];
            $sql = "SELECT * FROM workingshift WHERE userEmail = '$userEmail';";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0) {
                $_SESSION["workingShiftDataExistence"] = true;
            }
            if ($_SESSION["workingShiftDataExistence"] == false) {
                echo "<a href='selectWorkingShift.php'><input type='button' class='btnCreateProduct' value='Select working shift'></a>";
            }
            ?>


            <button class="btnShowProductListing" onclick="toggleProductListing()">show delivery jobs</button>
            <input type="text" class="productSearchBar" name="search" id="search" placeholder="search by product name">
            <div id="product-listing" style="display:none;" class="product-listing">



                <div id="result"></div>
                <?php
                $userEmail = $_SESSION["userEmail"];

                $sql = "SELECT * FROM shipment where userEmail='$userEmail' ";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0) {
                    echo '<table>
                            <thead>
                                <tr>
                                    <th scope="col">Shipment ID</th>
                                    <th scope="col">Sold product ID</th>
                                    <th scope="col">Product quantity</th>
                                    <th scope="col">Shipment date</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead><tbody id="output">';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . "S00" . $row['shipmentID'] . "</td>";
                        echo "<td>" . $row['soldProductID'] . "</td>";
                        echo "<td>" . $row['soldProductQuantity'] . "</td>";
                        echo "<td>" . $row['shipmentDate'] . "</td>";
                        echo "<td>";
                        $shipmentData = "shipmentID=" . $row['shipmentID'] . "&soldProductID=" . $row['soldProductID'] . "&soldProductQuantity=" . $row['soldProductQuantity'] . "&shipmentDate=" . $row['shipmentDate'];
                        echo "<a href='viewShipmentDetail.php?" . $shipmentData . "'>" . "<button class='btnEditProduct'>view</button></a>";
                        
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo ' </tbody></table>';
                } else {
                    echo 'there is no job';
                }
                ?>
                <div style="margin-bottom:50px;"></div>





            </div>
        </div>
    </div>
</div>
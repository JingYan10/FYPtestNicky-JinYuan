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
            }else{
                $_SESSION["workingShiftDataExistence"] = false;
            }
            if ($_SESSION["workingShiftDataExistence"] == false) {
                echo "<a href='selectWorkingShift.php'><input type='button' class='btnCreateProduct' value='Select working shift'></a>";
            }
            ?>


            <button class="btnShowProductListing" onclick="toggleProductListing()">show delivery jobs</button>
            <input type="text" class="productSearchBar" name="search2" id="search2" placeholder="search by shipment status, type (all) to display all">
            <div id="product-listing" style="display:none;" class="product-listing">



                <div id="result"></div>
                <?php
                $userEmail = $_SESSION["userEmail"];

                $sql = "SELECT * FROM shipment where userEmail='$userEmail' GROUP BY shipmentArrangementNo; ";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0) {
                    echo '<table>
                            <thead>
                                <tr>
                                    <th scope="col">Shipment date</th>
                                    <th scope="col">Shipment Arrangement No</th>
                                    <th scope="col">Shipment status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead><tbody id="output2">';
                        
                    while ($row = mysqli_fetch_assoc($result)) { 
                        echo "<tr>";
                        echo "<td>" . $row['shipmentDate'] . "</td>";
                        echo "<td>" . $row['shipmentArrangementNo'] . "</td>";
                        echo "<td>" . $row['shipmentStatus'] . "</td>";
                        echo "<td>";
                        $shipmentData = "shipmentID=" . $row['shipmentID'] . "&soldProductID=" . $row['soldProductID'] . "&soldProductQuantity=" . $row['soldProductQuantity'] . "&shipmentDate=" . $row['shipmentDate']."&shipmentArrangementNo=" . $row['shipmentArrangementNo']."&shipmentStatus=" . $row['shipmentStatus'];
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
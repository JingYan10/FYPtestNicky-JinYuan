<div class="seller-container">
    <div class="product-container">
        <div class="productInfo">
            <a href="createProduct.php"><input type="button" class="btnCreateProduct" value="createProduct"></a>
            <button class="btnShowProductListing" onclick="toggleProductListing()">show product listing</button>
            <input type="text" class="productSearchBar" name="search" id="search" placeholder="search by product name">
            <div id="product-listing" style="display:none;" class="product-listing">



            <div id="result"></div>
                <?php
                $sql = "SELECT * FROM product where userEmail='tete1234@gmail.com' AND deleteStatus IS NULL ";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0) {
                    echo '<table>
                            <thead>
                                <tr>
                                    <th scope="col">Product ID</th>
                                    <th scope="col">Product name</th>
                                    <th scope="col">product image</th>
                                    <th scope="col">product quantity</th>
                                    <th scope="col">product price</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead><tbody id="output">';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . "P00" . $row['productID'] . "</td>";
                        echo "<td>" . $row['productName'] . "</td>";
                        echo "<td>" . "<img style='height:140px;width:140px;' src=" . $row['productImage'] . ">" . "</td>";
                        echo "<td>" . $row['productQuantity'] . "</td>";
                        echo "<td>" . $row['productPrice'] . "</td>";
                        echo "<td>";
                        $productData = "productID=" . $row['productID'] . "&productName=" . $row['productName'] . "&productImage=" . $row['productImage'] . "&productQuantity=" . $row['productQuantity'] . "&productPrice=" . $row['productPrice'];
                        echo "<a href='editProduct.php?" . $productData . "'>" . "<button class='btnEditProduct'>edit</button></a>";
                        echo "<a href='deleteProduct.php?" . $productData . "'>" . "<button class='btnDeleteProduct'>delete</button></a>";
                        echo "<a href='createBidding.php?" . $productData . "'>" . "<button class='btnCreateBidding'>create bidding</button></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo ' </tbody></table>';
                } else {
                    echo 'there is no product created';
                }
                ?>
                <div style="margin-bottom:50px;"></div>





            </div>
        </div>
    </div>
</div>

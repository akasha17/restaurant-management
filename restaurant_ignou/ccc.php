 echo '<div class="total-amount-container">';
                                    echo '<div class="item-details">';
                                    echo '<label>Item Name:</label>';
                                    echo '<p>' . $row['name'] . '</p>';
                                    echo '<label>Restaurant Name:</label>';
                                    echo '<p>' . $restaurant_name . '</p>';
                                    echo '<label>Price:</label>';
                                    echo '<p>₹' . $row['price'] . '</p>';
                                    echo '<label>Quantity:</label>';
                                    echo '<p id="quantityDisplay">1</p>';
                                    echo '<label>Total Amount:</label>';
                                    echo '<p id="totalAmountDisplay">₹' . $row['price'] . '</p>';
                                    echo '</div>';
                                    echo '<button class="btn btn-primary" onclick="makePayment()">Make Payment</button>';
                                    echo '</div>';
                                } else {
                                    echo '<p>Error retrieving item details.</p>';
                                }
                            } else {
                                echo '<p>Invalid parameters.</p>';
                            }
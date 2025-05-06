code
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if (isset($_POST['add_to_cart'])) {
    $item_id = (int)$_POST['item_id'];
    $quantity = 1;

    // Fetch user_id from the session
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    // Check if the item is already in the user's cart
    $check_query = "SELECT * FROM cart WHERE user_id = ? AND item_id = ?";
    $stmt_check = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt_check, "ii", $user_id, $item_id);
    mysqli_stmt_execute($stmt_check);

    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) == 0) {
        // If not, insert the item into the cart
        $insert_query = "INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt_insert, "iii", $user_id, $item_id, $quantity);
        
        if (mysqli_stmt_execute($stmt_insert)) {
            echo "<script>alert('Item added to cart.'); window.location.href = 'cart.php';</script>";
            exit();
        } else {
            die("Insert error: " . mysqli_error($con));
        }
    } else {
        echo "<script>alert('Item is already in the cart.'); window.location.href = 'recipe.php';</script>";
        exit();
    }
}
?>



cart.php



Fetch items from the cart table
Assuming $_SESSION['user_id'] contains the ID of the currently logged-in user
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$cartQuery = "SELECT cart.*, menu.name AS item_name, menu.price AS item_price, menu.image AS item_image, restaurants.name AS restaurant_name
              FROM cart
              JOIN menu ON cart.item_id = menu.item_id
              JOIN restaurants ON cart.rest_id = restaurants.id
              WHERE cart.user_id = $user_id";

$cartResult = mysqli_query($con, $cartQuery);

$itemCount = mysqli_num_rows($cartResult);


$totalAmount = 0;
 <?php
    if ($itemCount > 0) {
        ?>
        <div class="container">
            <p id="total-amount">Total Amount: <?php echo $totalAmount; ?></p>
            <a href="payment.php">Proceed to Payment</a>
        </div>
        <?php
    } else {
        Show a message that the cart is empty
        echo "<p>Your cart is empty.</p>";
    }
    ?>

    <script>
    // Add this function to your existing JavaScript
function updateTotalAmountDisplay() {
    var grandTotal = 0;
    $('.item-total').each(function () {
        grandTotal += parseFloat($(this).text());
    });

    // Display the grand total
    $('#total-amount-display').text(number_format(grandTotal, 2));
}

// Add this line inside the updateTotal function
updateTotalAmountDisplay();
function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

</script>
<script>
    // jQuery script to update totals and handle item removal
    $(document).ready(function () {
        $('.quantity-input').on('input', function () {
            updateTotal(this);
        });

        $('.delete-item').on('click', function () {
            var itemId = $(this).data('item-id');
            var confirmDelete = confirm('Do you really want to delete this item?');
            
            if (confirmDelete) {
                // Remove the item from the page
                $(this).closest('tr').remove();

                // Make an AJAX request to delete the item from the database
                $.ajax({
                    url: 'delete-item.php', // URL to your PHP script for deleting from the database
                    method: 'POST',
                    data: { item_id: itemId },
                    success: function (response) {
                        // Handle success (you can log the response to the console for debugging)
                        console.log(response);
                        updateGrandTotal(); // Update total after successful item deletion
                    },
                    error: function (error) {
                        // Handle error (you can log the error to the console for debugging)
                        console.error(error);
                    }
                });
            }
        });

        function updateTotal(input) {
            var quantity = $(input).val();
            var price = $(input).closest('tr').find('td:eq(2)').text(); // Assuming the price is in the third column
            var total = (parseFloat(price) * parseInt(quantity)).toFixed(2);
            $(input).closest('tr').find('td:eq(5) .item-total').text(total);

            updateGrandTotal();
        }

        function updateGrandTotal() {
            var grandTotal = 0;
            $('.item-total').each(function () {
                grandTotal += parseFloat($(this).text());
            });

            // Display the grand total
            $('#total-amount').text('Total Amount: ' + grandTotal.toFixed(2));
        }
    });
</script>
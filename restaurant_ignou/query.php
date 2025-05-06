 $quantity = isset($_POST['quantity'][$itemId]) ? intval($_POST['quantity'][$itemId]) : 1;

        $itemTotal = $itemPrice * $quantity;
        $totalAmount += $itemTotal;



        td>
            <input type="number" class="quantity-input" name="quantity[<?php echo $itemId; ?>]" value="<?php echo $quantity; ?>" min="1" onchange="updateTotal(this, <?php echo $itemPrice; ?>, <?php echo $itemId; ?>);">
        </td>
        <td><span class="item-total" id="item-total-<?php echo $itemId; ?>"><?php echo $itemTotal; ?></span></td>
        <td>
            <input type="checkbox" name="selectedItems[]" value="<?php echo $itemId; ?>">
        </td>
        <td>
            <button type="button" class="delete-item" data-item-id="<?php echo $itemId; ?>">
                <i class="fa fa-trash" aria-hidden="true"></i> Remove
            </button>
        </td>
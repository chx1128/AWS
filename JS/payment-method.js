document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('paymentForm').addEventListener('submit', function (event) {
        event.preventDefault();
        var paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

        if (paymentMethod === 'creditCard') {
            window.location.href = 'credit-card.php';
        } else if (paymentMethod === 'eWallet') {
            window.location.href = 'tng.php';
        }
    });

    // Retrieve cart items from local storage and display only the items in the cart
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    const cartContainer = document.querySelector('.cart-items');

    if (cartItems.length > 0) {
        const table = document.createElement('table');
        const tbody = document.createElement('tbody');
        table.innerHTML = `
                    <tr>
                        <th class="item">Item</th>
                        <th class="quantity">Quantity</th>
                        <th class="price">Price</th>
                    </tr>
            `;

        let totalPrice = 0;

        cartItems.forEach(item => {
            // Calculate subtotal price for each item
            const subTotalPrice = item.price * item.quantity;
            // Check if the item is selected in the cart
            if (item.quantity > 0) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>RM ${subTotalPrice}</td>
                `;
                tbody.appendChild(row);
                // Calculate total price
                totalPrice += subTotalPrice;
            }
        });

        // Display total price
        const totalRow = document.createElement('tr');
        totalRow.innerHTML = `
            <td colspan="2" class="totalPrice">Total Price:</td>
            <td id="totalPriceCell" class="totalPrice">RM ${totalPrice.toFixed(2)}</td>
        `;
        tbody.appendChild(totalRow);

        table.appendChild(tbody);
        cartContainer.appendChild(table);
    }

    // Update total price when quantity changes
    document.querySelectorAll('.cart-items input[type="number"]').forEach(input => {
        input.addEventListener('change', () => {
            let totalPrice = 0;
            cartItems.forEach(item => {
                // Update item quantity
                if (item.id === parseInt(input.dataset.itemId)) {
                    item.quantity = parseInt(input.value);
                }
                // Calculate total price
                totalPrice += item.price * item.quantity;
            });
            // Update total price display
            document.getElementById('totalPriceCell').textContent = `RM ${totalPrice.toFixed(2)}`;
            // Update cart items in local storage
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
        });
    });
});

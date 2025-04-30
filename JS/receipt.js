document.addEventListener('DOMContentLoaded', () => {
    // Example od customer name and ID
    const customerName = "John Doe";
    const transactionID = "T000";
    // Retrieve stored date
    const transactionDate = localStorage.getItem('transactionDate');
    // Retrieve stored time
    const transactionTime = localStorage.getItem('transactionTime');

    // Add customer name and transaction ID 
    const customerInfo = document.querySelector('.customer-info');
    customerInfo.innerHTML = `
        <p><b>Customer Name :</b> ${customerName}</p>
        <p><b>Transaction ID :</b> ${transactionID}</p>
        <p><b>Date :</b> ${transactionDate}</p>
        <p><b>Time :</b> ${transactionTime}</p>
    `;

    // Remove stored date and time from localStorage after display
    localStorage.removeItem('transactionDate');
    localStorage.removeItem('transactionTime');

    const receiptContent = document.querySelector('.receipt-content');

    // Retrieve cart items from local storage
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    let totalPrice = 0;

    if (cartItems.length > 0) {
        // Display cart items for ticket purchasing
        const table = document.createElement('table');
        const tbody = document.createElement('tbody');
        table.appendChild(tbody);

        // Add table header row
        const headerRow = document.createElement('tr');
        headerRow.innerHTML = `
            <th class="item">Item</th>
            <th class="quantity">Quantity</th>
            <th class="price">Price</th>
        `;
        tbody.appendChild(headerRow);

        cartItems.forEach(item => {
            const subTotalPrice = item.price * item.quantity;
            if (item.quantity > 0) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>RM ${subTotalPrice.toFixed(2)}</td>
                `;
                tbody.appendChild(row);
                totalPrice += subTotalPrice;
            }
        });

        const totalRow = document.createElement('tr');
        totalRow.innerHTML = `
            <td colspan="2" class="totalPrice">Total Price:</td>
            <td id="totalPriceCell" class="totalPrice">RM ${totalPrice.toFixed(2)}</td>
        `;
        tbody.appendChild(totalRow);

        receiptContent.appendChild(table);
    } else {
        // Display subscription purchases
        receiptContent.innerHTML = `
            <div class="subDetails">
                <h2>Subscription</h2>
                <p class="subContent">
                    - Free Parking <br/>  
                    - Buy 10 Get 1 Free <br/>
                    - Fast Lane Entrance <br/>
                </p>
                <h2 class="totalPrice">Total Price: RM 200.00</h2>
            </div>
        `;
    }

    // Attach event listener to the print button
    document.querySelector('.print-button').addEventListener('click', function () {
        window.print();
    });

    // Clear cart items from local storage after payment
    localStorage.removeItem('cartItems');
});

// Search Function 
function search() {
    let searchInput = document.getElementById("tranId").value.trim();
    let tableRows = document.querySelectorAll("#tableBody tr");
    let pattern = /^T\d{3}$/;

    if (!pattern.test(searchInput)) {
        alert("Please enter a valid Transaction ID.");
        return;
    }
    
    // Use a Set to keep track of visible row indices
    let visibleRows = new Set(); 

    // Loop through each cell in the first column (Transaction ID column)
    for (let i = 0; i < tableRows.length; i++) {
        let transactionIDCell = tableRows[i].querySelector("td:first-child");
        let transactionID = transactionIDCell.textContent.trim();

        // Check if the current cell's Transaction ID matches the search input
        if (transactionID === searchInput) {
            // If the row has a rowspan, mark all affected rows as visible
            if (transactionIDCell.rowSpan > 1) {
                for (let j = i; j < i + transactionIDCell.rowSpan; j++) {
                    visibleRows.add(j);
                }
            } else {
                // Mark the current row as visible
                visibleRows.add(i); 
            }
        }
    }

    // Show or hide rows based on visibility set
    for (let i = 0; i < tableRows.length; i++) {
        if (visibleRows.has(i)) {
            tableRows[i].style.display = "table-row";
        } else {
            tableRows[i].style.display = "none";
        }
    }
}


// Let 'enter' key function as search button
document.addEventListener("keypress", function (event) {
    if (event.key === 'Enter') {
        search();
    }
});

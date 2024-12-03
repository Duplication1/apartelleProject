
      $(document).ready(function () {
    $('#stockLevelTable').DataTable({
        columnDefs: [
            {
                targets: '_all', // Apply to all columns
                className: 'text-center align-middle ellipsis', // Center-align and truncate text
                width: '150px' // Fixed width for columns
            }
        ],
        rowCallback: function (row, data, index) {
            var fullText = data[2]; // Assuming 3rd column has the full text
            if (fullText && fullText.length > 50) { // Limit to 100 characters
                // Truncate the content in the 3rd column (index 2)
                $('td:eq(2)', row).text(fullText.substring(0, 50) + '...'); 
            }
        },
        order: [[0, 'desc']], // Sort by the first column in descending order
        language: {
            search: "<i class='bi bi-search'></i>", // Custom search field
       
        }
    });
});


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Manage Customers</h2>

    <table id="customersTable" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Customer rows will be inserted here by JavaScript -->
        </tbody>
    </table>

    <script>
        // Fetch the customer data from the server
        function fetchCustomers() {
            $.ajax({
                url: 'get_customers.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert('Error: ' + response.error);
                        return;
                    }
                    // Populate the table with customer data
                    const tableBody = $('#customersTable tbody');
                    tableBody.empty();
                    response.forEach(customer => {
                        tableBody.append(`
                            <tr id="customer_${customer.id}">
                                <td>${customer.id}</td>
                                <td>${customer.name}</td>
                                <td>${customer.email}</td>
                                <td>${customer.contact}</td>
                                <td><button class="deleteBtn" data-id="${customer.id}">Delete</button></td>
                            </tr>
                        `);
                    });
                },
                error: function() {
                    alert('Failed to fetch customers.');
                }
            });
        }


// Delete customer using AJAX
function deleteCustomer(customerId) {
    if (confirm('Are you sure you want to deactivate this customer?')) {
        $.ajax({
            url: 'delete_customer.php',
            type: 'POST',
            data: { id: customerId },
            success: function(response) {
                
                console.log(response)
                
                if (response === 204) {
                    alert('Customer deactivated successfully.');
                    $(`#customer_${customerId}`).remove();  // Remove the row from the table
                } else {
                    alert('Failed to deactivate customer.');
                }
            },
            error: function() {
                alert('Error deactivating customer.');
            }
        });
    }
}

        // When a delete button is clicked
        $(document).on('click', '.deleteBtn', function() {
            const customerId = $(this).data('id');
            deleteCustomer(customerId);
        });

        // Fetch customers when the page loads
        $(document).ready(function() {
            fetchCustomers();
        });
    </script>
</body>
</html>

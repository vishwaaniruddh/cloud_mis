<? session_start();
include('config.php');

if ($_SESSION['username']) { 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        
                            <div class="card-header">
                                                        <h5>Fund Request Data</h5>
                                                    </div>
                        <div class="card-block" style="overflow-x:scroll">
                            <div id="fund-data-container">
                                <!-- Table to display fetched data -->
                                <table id="fund-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>ATM ID</th>
                                            <th>Fund Component</th>
                                            <th>Requested Amount</th>
                                            <th>Approved Amount</th>
                                            <th>Request Status</th>
                                            <th>Created At</th>
                                            <th>Image</th>
                                            <th>Payment Processed</th>
                                            <th>Final Utilized Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be appended here dynamically -->
                                    </tbody>
                                </table>

                                <!-- Pagination Buttons -->
                                <div id="pagination-buttons" style="margin-top: 20px; text-align: center;">
                                    <!-- Buttons will be dynamically created -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const limit = 20; // Number of records per page
    let currentPage = 1; // Track the current page

    // Fetch data for the current page
    function fetchFundData(page = 1) {
        $.ajax({
            url: 'api/fund/getfundRequest.php',
            method: 'GET',
            data: { page: page },
            dataType: 'json',
            success: function(response) {
                
                
                console.log(response)
                
                if (response.data && response.data.length > 0) {
                    populateTable(response.data);
                    createPaginationButtons(response.pagination);
                } else {
                    $('#fund-data-table tbody').html('<tr><td colspan="11">No data available</td></tr>');
                }
            },
            error: function() {
                $('#fund-data-table tbody').html('<tr><td colspan="11">Failed to fetch data</td></tr>');
            }
        });
    }

    // Populate the table with data
    function populateTable(data) {
        let rows = '';
        data.forEach(item => {
            rows += `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.atmid}</td>
                    <td>${item.fund_component}</td>
                    <td>${item.requested_amount}</td>
                    <td>${item.approved_amount}</td>
                    <td>${item.req_status}</td>
                    <td>${item.created_at}</td>
                    <td>${item.img ? `<img src="${item.img}" alt="Image" style="width: 50px;">` : 'N/A'}</td>
                    <td>${item.isPaymentProcessed==1 ? 'Yes' : 'No'}</td>
                    <td>${item.finalUtilisedAmount || 'N/A'}</td>
                    <td><a href="./fund_status.php?id=${item.id}" class="btn btn-primary btn-sm">View Status</a></td>
                </tr>
            `;
        });
        $('#fund-data-table tbody').html(rows);
    }

    // Create pagination buttons
    function createPaginationButtons(pagination) {
        let buttons = '';
        for (let i = 1; i <= pagination.total_pages; i++) {
            buttons += `
                <button 
                    class="btn ${i === pagination.current_page ? 'btn-primary' : 'btn-light'} btn-sm"
                    onclick="fetchFundData(${i})">
                    ${i}
                </button>
            `;
        }
        $('#pagination-buttons').html(buttons);
    }

    // Fetch initial data
    fetchFundData();

    // Expose fetchFundData globally for pagination buttons
    window.fetchFundData = fetchFundData;
});
</script>

<? include('footer.php');
} else { ?>
    <script>
        window.location.href = "login.php";
    </script>
<? } ?>

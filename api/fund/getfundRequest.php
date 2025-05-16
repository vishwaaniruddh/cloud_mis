<?php
include 'config.php';
header('Content-Type: application/json');

// Database connection check
if (!$con) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Default parameters for pagination
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

// SQL query to fetch data with pagination
$query = "SELECT id, atmid, fund_component, requested_amount, approved_amount, req_status, created_at, img, isPaymentProcessed, finalUtilisedAmount 
          FROM eng_fund_request 
          order by id desc 
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($con, $query);

if ($result) {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Count total records to calculate total pages
    $countQuery = "SELECT COUNT(*) as total FROM eng_fund_request";
    $countResult = mysqli_query($con, $countQuery);
    $totalRecords = $countResult ? mysqli_fetch_assoc($countResult)['total'] : 0;
    $totalPages = ceil($totalRecords / $limit);

    // Response
    echo json_encode([
        'data' => $data,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_records' => $totalRecords,
            'records_per_page' => $limit,
        ],
    ]);
} else {
    echo json_encode(['error' => 'Failed to fetch data']);
}
?>

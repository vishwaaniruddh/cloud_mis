<?php
include('./config.php');

$raisedFundId = $_REQUEST['raisedFundId'];

// Fetch main fund details
$sql = mysqli_query($con, "SELECT * FROM raisedFund WHERE id='" . $raisedFundId . "'");
if ($sql_result = mysqli_fetch_assoc($sql)) {
    
    $detailssql = mysqli_query($con, "SELECT * FROM raisedFundComponent WHERE raisedFundId = '" . $raisedFundId . "'");
$grandTotalAmount = 0 ;


    while ($detailssql_result = mysqli_fetch_assoc($detailssql)) {
        $component = $detailssql_result['component'];
        echo "<h5>$component</h5>";

        if ($component == 'Travelling') {
            echo "<table class='table' border='1' width='100%'>
                    <thead>
                    <tr>
                        <th>Travel Type</th>
                        <th>From Site</th>
                        <th>To Site</th>
                        <th>Travel Distance (KM)</th>
                        <th>Calculated Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    ";
            $totalAmount = 0;
            $trave_sql = mysqli_query($con, "SELECT * FROM travelling_funds WHERE raisedFundId='" . $raisedFundId . "'");
            while ($trave_sql_result = mysqli_fetch_assoc($trave_sql)) {
                
                $travel_distance = (int)$trave_sql_result['travel_distance'] . 'KM' ; 
                echo "<tr>
                        <td>{$trave_sql_result['travel_type']}</td>
                        <td>{$trave_sql_result['from_site']}</td>
                        <td>{$trave_sql_result['to_site']}</td>
                        <td>{$travel_distance}</td>
                        <td>₹{$trave_sql_result['calculated_amount']}</td>
                      </tr>";
                $totalAmount += $trave_sql_result['calculated_amount'];
            }
            echo "
            
            <tr>
                    <td colspan='4'><strong>Total Amount:</strong></td>
                    <td><strong>₹$totalAmount</strong></td>
                  </tr>
            </tbody>      
                  ";
            echo "</table><br />";
            
            $grandTotalAmount = $grandTotalAmount + $totalAmount ; 
        }

        if ($component == 'Spares') {
            echo "<table class='table' border='1' width='100%'>
                    <thead>
                    <tr>
                        <th>Spare Required Reason</th>
                        <th>Spare Component</th>
                        <th>Spare Subcomponent</th>
                        <th>Spare Cost</th>
                        <th>Our Cost</th>
                        <th>Media</th>
                    </tr>
                    </thead>
                    <tbody>
                    ";
            $totalCost = 0;
          $spare_sql = mysqli_query($con, "SELECT s.*, sc.cost FROM spare_funds s INNER JOIN sparesComponent sc ON s.spares_subcomponent = sc.spareComponentName WHERE s.raisedFundId='" . $raisedFundId . "'");
$totalCost = 0; // Initialize total cost

while ($spare_sql_result = mysqli_fetch_assoc($spare_sql)) {
    $spareFundId = $spare_sql_result['id'];

  
    // Output table row with attachments
    echo "<tr>
            <td>{$spare_sql_result['spare_required_reason']}</td>
            <td>{$spare_sql_result['spares_component']}</td>
            <td>{$spare_sql_result['spares_subcomponent']}</td>
            <td>₹{$spare_sql_result['spares_cost']}</td>
            <td>₹{$spare_sql_result['cost']}</td>
            <td>
                <a href='view_fund_reuqired_images.php?spare_id={$spareFundId}' target='_blank'>View Media</a>
            </td>
          </tr>";

    $totalCost += $spare_sql_result['spares_cost'];
}

echo "<tr><td colspan='5'><strong>Total Cost:</strong></td><td>₹$totalCost</td></tr>";
            echo "<tr>
                    <td colspan='2'><strong>Total Cost:</strong></td>
                    <td><strong>₹$totalCost</strong></td>
                    <td></td>
                  </tr>

                    </tbody>
                  ";
            echo "</table><br />";
            $grandTotalAmount = $grandTotalAmount + $totalCost ; 
        }

        if ($component == 'Vendor') {
            echo "<table border='1' width='100%' class='table'>
            <thead>
                    <tr>
                        <th>Vendor Name</th>
                        <th>Vendor Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    ";
            $totalVendorAmount = 0;
            $vendor_sql = mysqli_query($con, "SELECT * FROM vendor_funds WHERE raisedFundId='" . $raisedFundId . "'");
            while ($vendor_sql_result = mysqli_fetch_assoc($vendor_sql)) {
                echo "<tr>
                        <td>{$vendor_sql_result['vendor_name']}</td>
                        <td>₹{$vendor_sql_result['vendor_amount']}</td>
                      </tr>";
                $totalVendorAmount += $vendor_sql_result['vendor_amount'];
            }
            echo "<tr>
                    <td><strong>Total Vendor Amount:</strong></td>
                    <td><strong>₹$totalVendorAmount</strong></td>
                  </tr>
                  </tbody>
                  ";
            echo "</table><br />";
            
            $grandTotalAmount = $grandTotalAmount + $totalVendorAmount ;
        }
    }
    
    
    echo '<h4 style="text-align:right;">Total : ' . $grandTotalAmount . '</h4>'; 
    
}
?>

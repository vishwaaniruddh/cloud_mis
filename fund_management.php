<?php include('config.php'); ?>

<!--<link rel="stylesheet" type="text/css" href="../files/bower_components/bootstrap/dist/css/bootstrap.min.css">-->


<!--<link rel="stylesheet" type="text/css" href="../files/assets/icon/feather/css/feather.css">-->
<!-- Style.css -->
<!--<link rel="stylesheet" type="text/css" href="../files/assets/css/jquery.mCustomScrollbar.css">-->
<!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->

<!--<link href="select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">-->
<!--<script src="select2/dist/js/select2.min.js" defer></script>-->

<?php
$enguserid = $userid;
// $enguserid = 193;
$sql1 = mysqli_query($con, "SELECT * FROM spares WHERE status=1");
$result1 = [];
while ($row1 = mysqli_fetch_assoc($sql1)) {
    $name1 = $row1["spareName"];
    $id1 = $row1["id"];
    $result1[] = ['id' => $id1, 'name' => $name1];
}
$data = json_encode($result1);

// Fetch subcomponents
$sql2 = mysqli_query($con, "SELECT * FROM sparesComponent WHERE status=1 ORDER BY id DESC");
$result2 = [];
while ($row2 = mysqli_fetch_assoc($sql2)) {
    $model2 = $row2["spareComponentName"];
    $component_id = $row2["spareid"];
    $id = $row2['id'];
    $result2[] = ['id' => $id, 'fk' => $component_id, 'name' => $model2];
}
$data2 = json_encode($result2);


$fundTypes = [
    "Project",
    "Service"
];



// Define fund components for the dropdown
$fundComponents = [

    "Spares",
    "Travelling",
    "Vendor"
];

// Define spare components and their subcomponents
$spareOptions = [
    "Engine" => ["Filter", "Oil", "Gasket"],
    "Tires" => ["Alloy Rim", "Tube", "Tread"],
    "Electrical" => ["Battery", "Wiring", "Bulb"]
];
?>


<style>
    /* Tooltip Icon Styling */
    .tooltip-icon {
        color: #007bff;
        /* Bootstrap primary color */
        cursor: pointer;
        margin-left: 5px;
        font-size: 18px;
        /* Adjust icon size */
        transition: color 0.3s ease;
    }

    .tooltip-icon:hover {
        color: #0056b3;
        /* Darker shade on hover */
    }

    /* Tooltip Styling */
    .tooltip {
        font-size: 14px;
        background-color: #333;
        /* Dark background for the tooltip */
        color: #fff;
        /* White text */
        border-radius: 5px;
        padding: 8px 12px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 300px;
        /* Limit tooltip width */
        text-align: center;
    }

    /* Tooltip Arrow Styling */
    .tooltip .arrow::before {
        border-top-color: #333 !important;
        /* Match tooltip background color */
    }


    @media (min-width: 1200px) {
        .modal-xl {
            max-width: 1440px;
        }
    }

    #travel_type_section select,
    #travel_type_section input[type="text"],
    #travel_type_section input[type="number"] {
        /*padding: 8px;*/
        /*border: 1px solid #ccc;*/
        /*border-radius: 4px;*/
        width: 100%;
    }

    .spare-row select,
    .spare-row input[type="text"],
    .spare-row input[type="number"] {
        /*padding: 8px;*/
        /*border: 1px solid #ccc;*/
        /*border-radius: 4px;*/
        /*width:100%;*/
    }

    .checkbox-group {
        display: flex;
        flex-direction: column;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .hidden {
        display: none;
    }

    .spare-row {

        gap: 10px;
        margin-bottom: 10px;
        align-items: center;
    }

    .remove-spare {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    .remove-spare:hover {
        background-color: #a71d2a;
    }


    #travelling_km_section {
        display: flex;
        flex-direction: column;
        margin: 10px 0;
    }

    .travel-info,
    .amount-info {
        margin-bottom: 5px;
    }

    .label {
        font-weight: bold;
        font-size: 16px;
    }

    #total_distance {
        font-size: 18px;
        font-weight: bold;
    }

    #site_calculated_amount {
        font-size: 18px;
        font-weight: bold;
    }

    .spare-row .col-sm-2 {
        padding: 0;
    }

    .spare-row select,
    .spare-row label {
        width: 100%;
    }
</style>




<div class="col-sm-12">

    <!--<select name="fund_type" id="fund_type" required style="width:100%;">-->
    <!--    <option>Select</option>-->
    <!--    <?php foreach ($fundTypes as $types): ?>-->
    <!--        <option value="<?php echo htmlspecialchars($types); ?>"><?php echo htmlspecialchars($types); ?></option>-->
    <!--    <?php endforeach; ?>-->
    <!--</select>    -->

    <input type="hidden" name="fund_type" value="Service">



</div>


<!-- Button to Open Modal -->
<!--<a href="#" class="btn btn-primary waves-effect" id="historybtn" data-toggle="modal" data-target="#fundHistoryModal">-->
<!--    View Complete Fund Distribution History-->
<!--</a>-->

<!-- Updated Modal -->
<div class="modal fade" id="fundHistoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document"> <!-- Removed extra modal -->
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">📜 Fund Distribution History</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Spinner Loader -->
                <div id="fundHistoryLoader" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="text-muted mt-2">Fetching fund history...</p>
                </div>

                <!-- Fund Data -->
                <div id="fundHistoryContent" class="p-3 d-none"></div> <!-- Initially Hidden -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#fundHistoryModal').on('show.bs.modal', function() {
            let atmid = $("#atmid_fund").text().trim(); // Fetch ATM ID
            $("#fundHistoryLoader").removeClass("d-none"); // Show Spinner
            $("#fundHistoryContent").addClass("d-none"); // Hide Data Section

            $.ajax({
                url: 'getFundHistory.php',
                type: 'POST',
                data: {
                    atmid: atmid
                },
                success: function(response) {
                    $("#fundHistoryContent").html(response).removeClass("d-none"); // Show Data
                    $("#fundHistoryLoader").addClass("d-none"); // Hide Spinner
                },
                error: function() {
                    $("#fundHistoryLoader").html("<p class='text-danger'>❌ Failed to fetch data. Try again.</p>");
                }
            });
        });
    });
</script>




<div class="col-sm-12" style="text-align:center;">
    <label for="fund_component">Fund Component</label>

    <?php foreach ($fundComponents as $component): ?>
        <input type="checkbox" name="fund_component[]" class="fund_component" value="<?php echo htmlspecialchars($component); ?>">&nbsp;&nbsp;<?php echo htmlspecialchars($component); ?>
        &nbsp;&nbsp;&nbsp;&nbsp;
    <?php endforeach; ?>


</div>



<?php

$travelTypes = [
    "Resident To Site",
    "Site To Site",
    "Site To Resident"
];

?>

<input type="hidden" name="status" value="fund_required" />
<!-- Travel Type Section -->
<div id="travel_type_section" class="col-sm-12 card hidden">
    <label for="travel_type">Travel Type</label>

    <table class="table">
        <thead>
            <tr>
                <th>Travel Type</th>
                <th>From</th>
                <th>To</th>
                <th>Distance Up & Down</th>
                <th>Calculated Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="travel_type_container">
            <tr class="travel-row">
                <input type="hidden" name="isEligibleForFund[]" class="isEligibleForFund" value="" />
                <td>
                    <select name="travel_type[]" id="travel_type" class="travel_type">
                        <option value="">Select Travel Type</option>
                        <?php foreach ($travelTypes as $type): ?>
                            <option value="<?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($type); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="from_site[]" class="first_from from_site">
                        <option value="">From Site</option>
                    </select>
                </td>
                <td>
                    <select name="to_site[]" class="first_to to_site">
                        <option value="">To Site</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="travel_distance" name="travel_distance[]" placeholder="Distance in KM" required>
                </td>
                <td>
                    <input type="number" class="calculated_amount" name="calculated_amount[]" placeholder="calculated Amount" required readonly>
                </td>
                <td></td>
            </tr>
        </tbody>
        <tfooter>
            <th></th>
            <th></th>
            <th></th>
            <th><span id="total_distance">0</span> km</th>
            <th><span id="site_calculated_amount">0</span> INR</th>
            <th></th>
        </tfooter>
    </table>


    <!--<div id="travel_type_container">-->
    <!--    <div class="travel-row">-->
    <!--        <select name="travel_type[]" id="travel_type" class="travel_type" >-->
    <!--            <option value="">Select Travel Type</option>-->
    <!--            <?php foreach ($travelTypes as $type): ?>-->
    <!--                <option value="<?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($type); ?></option>-->
    <!--            <?php endforeach; ?>-->
    <!--        </select>-->
    <!--        <select name="from_site[]" class="first_from from_site">-->
    <!--            <option value="">From Site</option>-->
    <!--        </select>-->
    <!--        <select name="to_site[]" class="first_to to_site">-->
    <!--            <option value="">To Site</option>-->
    <!--        </select>-->
    <!--        <input type="number" class="travel_distance" name="travel_distance[]" placeholder="Distance in KM" required>-->
    <!--        <input type="number" class="calculated_amount" name="calculated_amount[]" placeholder="calculated Amount" required readonly>-->
    <!--    </div>-->
    <!--</div>-->
    <button type="button" id="add_travel_type">Add More Travel</button>

    <hr />


    <div class="row">
        <div class="col-sm-12">
            <label for="travel_mode">Select Travel Mode:</label>
            <select class="form-control travel_mode" name="travel_mode" id="travel_mode">
                <option value="">-- Select Travel Mode --</option>
                <option value="private">Private 2/4 Wheeler</option>
                <option value="Bus">Bus</option>
                <option value="Train">Train</option>
                <option value="Auto-rickshaw">Auto-rickshaw</option>
                <option value="Ship">Ship</option>
                <option value="Aeroplane">Aeroplane</option>
            </select>
        </div>
    </div>


    <!--<div id="travelling_km_section" class="hidden">-->
    <!--    <label for="travelling_km">-->
    <!--        <div class="travel-info">-->
    <!--            <p>Total Travelling Kilometers: <span id="total_distance">0</span> km </p>-->
    <!--            <p>-->
    <!--                <strong>Travel Cost Calculation:</strong>-->
    <!--                <span class="tooltip-icon" data-bs-toggle="tooltip" title="Only the cumulative distance exceeding 200 km contributes to the travel cost. For each km beyond 200, the cost is calculated at ₹3/km.">-->
    <!--                    <i class="fa fa-info-circle"></i>-->
    <!--                </span>-->
    <!--            </p>-->
    <!--        </div>-->
    <!--        <div class="amount-info">-->
    <!--            <p>Total Amount: <span id="site_calculated_amount">0</span> INR </p>-->

    <!--        </div>-->
    <!--    </label>-->
    <!--</div>-->
</div>



<!-- Spares Section -->
<div id="spares_section" class="col-sm-12 hidden card">
    <label>Spares</label>
    <div id="spares_container" style="overflow-x:scroll;">


    <table class="table">
        <thead>
            <tr>
                <th>Spare Required Reason</th>
                <th>Spare Component</th>
                <th>Spare SubComponent</th>
                <th width="150px">Cost</th>
                <th>Spare Images</th>
                <th>Spare Videos</th>
                <th>Actions</th>
            </tr>
        </thead>
                <tbody id="spare_container">
            <tr class="spare-row">
                <td>
                  <select name="spare_required_reason[]" class="spare_required_reason">
                        <option value="">Select</option>
                        <option>Faulty</option>
                        <option>Missing</option>
                        <option>New Requirement</option>
                        <option>Not Installed</option>
                    </select>
                </td>
                <td>
                  <select name="spares_component[]" class="spares_component">
                        <option value="">Select Component</option>
                        <?php foreach ($spareOptions as $component => $subcomponents): ?>
                            <option value="<?php echo htmlspecialchars($component); ?>"><?php echo htmlspecialchars($component); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="spares_subcomponent[]" class="spares_subcomponent" style="width: 250px;">
                        <option value="">Select Subcomponent</option>
                    </select>
                </td>
                <td width="150px">
                    <input type="number" style="width:110px" name="spares_cost[]" placeholder="Enter Cost" min="0">
                </td>
                <td>
                    <input type="file" name="spares_image[]" class="form-control" multiple accept="image/*" />
                </td>
                <td>
                    <input type="file" name="spares_video[]" class="form-control" multiple accept="video/*" />
                </td>
                <td></td>
            </tr>
        </tbody>
        
<tfooter>
            <th></th>
            <th></th>
            <th></th>
            <th width="150px"><span id="spares_calculated_amount">0</span> INR</th>
            <th></th>
            <th></th>
            <th></th>
        </tfooter>
    </table>
        </div>
            <button type="button" id="add_spare">Add More Spares</button>
    </div>


    <hr />


<!-- Vendor Section -->
<div id="vendors_section" class="col-sm-12 hidden card">
    <div class="row">
        <div class="col-sm-12">
            <label>Vendor Name</label>
            <input type="text" name="vendor_name" class="form-control" placeholder="Enter Vendor Name required ..." />
        </div>
        <div class="col-sm-12">
            <label>Vendor Amount</label>
            <input type="number" name="vendor_amount" class="form-control" placeholder="Enter Vendor Amount required ..." />
        </div>

    </div>

</div>

<div class="col-sm-12 ">

    <label for="fund_amount">Fund Amount (In Rupees)</label>
    <input type="text" class="form-control" name="fund_amount" id="fund_amount" placeholder="Enter fund amount" readonly required>

</div>

<div class="col-sm-12 ">
    <!-- Remark -->
    <label for="remark">Remark</label>
    <input type="text" class="form-control" name="remark" id="remark" placeholder="Enter remark">
</div>


<div class="col-sm-12 ">
    <br />
    <button type="submit">Submit</button>
</div>






<script>
    $(document).ready(function() {


        // Pass the PHP data to JavaScript
        const components = <?php echo $data; ?>;
        const subcomponents = <?php echo $data2; ?>;



        // Function to populate component dropdown
        function populateComponents() {
            const componentDropdown = $('.spares_component');
            componentDropdown.empty(); // Clear any existing options
            componentDropdown.append('<option value="">Select Component</option>'); // Add default option
            components.forEach(component => {
                componentDropdown.append(`<option value="${component.name}">${component.name}</option>`);
            });
        }

        // Function to populate subcomponent dropdown based on selected component
        function populateSubcomponents(componentId, subcomponentDropdown) {
            subcomponentDropdown.empty(); // Clear any existing options
            subcomponentDropdown.append('<option value="">Select Subcomponent</option>'); // Add default option
            subcomponents.forEach(subcomponent => {
                if (subcomponent.fk == componentId) {
                    subcomponentDropdown.append(`<option value="${subcomponent.name}">${subcomponent.name}</option>`);
                }
            });
        }

        populateComponents();
        $(document).on('change', '.spares_component', function() {
            const selectedComponent = $(this).val();

            const subcomponentDropdown = $(this).closest('.spare-row').find('.spares_subcomponent');
            populateSubcomponents(selectedComponent, subcomponentDropdown);
        });

        // Handle the add spare button to add new rows dynamically
        $('#add_spare').on('click', function() {
            addSpareRow();
        });


        function addSpareRow() {
            const spareRow = `
            <tr class="spare-row">
            <td>
                <select name="spare_required_reason[]" class="spare_required_reason">
                    <option value="">Select</option>
                    <option>Faulty</option>
                    <option>Missing</option>
                    <option>New Requirement</option>
                    <option>Not Installed</option>
                </select>

        </td>

        <td>
                <select name="spares_component[]" class="spares_component">
                    <option value="">Select Component</option>
                </select>
            </td>

        <td>
                <select name="spares_subcomponent[]" class="spares_subcomponent" style="width: 250px;">
                    <option value="">Select Subcomponent</option>
                </select>
            </td>

        <td>
                <input type="number" style="width:110px" name="spares_cost[]" placeholder="Enter Cost" min="0">
                
                        </td>

        <td>
            <input type="file" name="spares_image[]" accept="image/*" multiple class="form-control" /> <!-- Added name for images -->
                    </td>

        <td>
            <input type="file" name="spares_video[]" accept="video/*" multiple class="form-control" /> <!-- Added name for videos -->
        </td>
        <td>
            <button type="button" class="remove-spare">Remove</button>
        </td>
        
    </tr>
        `;
            $('#spare_container').append(spareRow);

            // Populate component dropdown dynamically for the new row
            const componentDropdown = $('#spares_container').find('.spare-row:last-child').find('.spares_component');
            components.forEach(component => {
                componentDropdown.append(`<option value="${component.name}">${component.name}</option>`);
            });

            const newRowSubcomponentDropdown = $('#spares_container').find('.spare-row:last-child').find('.spares_subcomponent');
            populateSubcomponents("", newRowSubcomponentDropdown); // Empty initial subcomponent options
        }

        // Remove spare row
        $(document).on('click', '.remove-spare', function() {
            $(this).closest('.spare-row').remove();
            refreshCalculations();
        });

        // Show/Hide Sections Based on Fund Component
        $('.fund_component').on('change', function() {
            // Travelling Section
            const selectedComponents = $(this).val();

            if ($('.fund_component[value="Travelling"]').is(':checked')) {
                $('#travel_type_section').removeClass('hidden');
                console.log('selected components = ' + selectedComponents)
                $('#travel_type_section').find("select, input").prop("required", true);
            } else {
                $('#travel_type_section').addClass('hidden');
                $('#travelling_km').val('');
                $('#calculated_amount').text('0');
                console.log('unselected components = ' + selectedComponents)
                $('#travel_type_section').find("select, input").prop("required", false);
            }

            // Spares Section
            if ($('.fund_component[value="Spares"]').is(':checked')) {
                $('#spares_section').removeClass('hidden');
                $('#spares_container').find("select, input").prop("required", true);
            } else {
                $('#spares_section').addClass('hidden');
                $('#spares_container').empty();
                addSpareRow(); // Assuming this function exists to reset spares
                $('#spares_container').find("select, input").prop("required", false);
            }

            // Vendor Section
            if ($('.fund_component[value="Vendor"]').is(':checked')) {
                $('#vendors_section').removeClass('hidden');
            } else {
                $('#vendors_section').addClass('hidden');
            }
        });


    });






    function populateSitesFromAPI(selectElement, engineerUserId) {
        // Clear existing options
        selectElement.empty();

        // Add a placeholder option
        selectElement.append('<option value="">Select Site</option>');

        // Fetch data from the API with the engineer_user_id parameter
        $.ajax({
            url: './getmappedatms.php',
            method: 'GET',
            data: {
                engineer_user_id: engineerUserId
            }, // Pass engineer_user_id as a parameter
            dataType: 'json',
            success: function(response) {
                if (response.status === "success" && Array.isArray(response.data)) {
                    response.data.forEach(function(site) {
                        // Assuming the API returns an array of objects with 'atmid' property
                        selectElement.append(`<option value="${site.atmid}">${site.atmid}</option>`);
                    });
                } else {
                    console.error('Error: No valid data received from the API');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Engineer user ID to be passed to the API
    var engineerUserId = '<?php echo $enguserid;  ?>'; // Replace this with the actual ID from your application context

    // Apply the function to populate both dropdowns
    populateSitesFromAPI($('#travel_type_container').find('.first_from'), engineerUserId);
    populateSitesFromAPI($('#travel_type_container').find('.first_to'), engineerUserId);







    function addTravelRow() {
        const travelRow = `
        <tr class="travel-row">
        <input type="hidden" name="isEligibleForFund[]" class="isEligibleForFund" value="" />
            <td>
            <select name="travel_type[]" class="travel_type" required>
                <option value="">Select Travel Type</option>
                <option value="Resident to Site">Resident to Site</option>
                <option value="Site to Site">Site to Site</option>
                <option value="Site to Resident">Site to Resident</option>
            </select>
            </td>
            <td>
            <select name="from_site[]" class="from_site" required>
                <option value="">From Site</option>
            </select>
            </td>
            <td>
            <select name="to_site[]" class="to_site" required>
                <option value="">To Site</option>
            </select>
            </td>
            <td>
                <input type="number" class="travel_distance" name="travel_distance[]" placeholder="Distance in KM" required>
            </td>
            <td>
            <input type="number" class="calculated_amount" name="calculated_amount[]" placeholder="calculated Amount" required readonly>
            </td>
            <td>
            <button type="button" class="remove-travel">Remove</button>
            </td>
        </tr>
    `;
        $('#travel_type_container').append(travelRow);
        const newRow = $('#travel_type_container').find('.travel-row:last-child');

        populateSitesFromAPI(newRow.find('td .from_site'), engineerUserId);
        populateSitesFromAPI(newRow.find('td .to_site'), engineerUserId);
    }

    // Add new travel row when "Add More Travel Type" button is clicked
    $('#add_travel_type').on('click', function() {
        addTravelRow();
    });

    // Remove a travel row
    $(document).on('click', '.remove-travel', function() {
        $(this).closest('.travel-row').remove();
        refreshCalculations();
    });

    // Show/Hide Travel Type Section Based on Fund Component Selection
    
    $('.fund_component').on('change', function() {
            const selectedComponents = $(this).val(); // Get current selected values
            let atmid = $("#atmid_fund").html();
            let fund_type = 'Travelling';

            // console.log("ATM ID:", atmid);
            // console.log("Selected Components:", selectedComponents);
            // console.log("Fund Type:", fund_type);

            if (selectedComponents && selectedComponents.includes('Travelling')) {


                    $('#travel_type_section').removeClass('hidden');
            } else {
                    $('#travel_type_section').addClass('hidden');
                    $('#travel_type_container').empty();
                    addTravelRow();
                    $('#travel_type_section').find("select, input").prop("required", false);
            }

            if (selectedComponents && selectedComponents.includes('Spares')) {
                    $('#spares_section').removeClass('hidden');
                    $('#spares_container').find("select, input").prop("required", true);
            } else {
                    $('#spares_section').addClass('hidden');
                    $('#spares_container').find("select, input").prop("required", false);
            }
    });







    $(document).ready(function() {
        $(document).on("change", ".spares_subcomponent", function() {
            let atmid = $("#atmid_fund").text().trim(); // Ensure trimmed text is retrieved
            var $row = $(this).closest(".spare-row");
            var component = $row.find(".spares_component").val();
            var subcomponent = $(this).val();
            var $subcomponentDropdown = $(this); // Store reference

            if (!atmid) {
                alert("ATM ID is missing. Please check and try again.");
                return;
            }

            if (!component) {
                alert("Please select a component before choosing a subcomponent.");
                return;
            }

            if (!subcomponent) {
                alert("Please select a valid subcomponent.");
                return;
            }

            $.ajax({
                url: "validate_spares_request.php",
                type: "POST",
                data: {
                    atmid: atmid,
                    spares_component: component,
                    spares_subcomponent: subcomponent
                },
                dataType: "json", // Expect JSON response
                success: function(response) {
                    if (response.status === "error") {
                        swal("Request Already Found !", response.message, "error");
                        // alert("Error: " + );
                        $subcomponentDropdown.val(''); // Reset dropdown
                    } else if (response.status === "warning") {
                        swal("Warning !", response.message, "warning");
                        // alert("Warning: " + response.message);
                    } else if (response.status === "success") {
                        // alert("Success: " + response.message);
                    } else {
                        alert("Unexpected response. Please try again.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    alert("An error occurred while validating the data. Please try again.");
                    $subcomponentDropdown.val(''); // Reset dropdown on AJAX error
                }
            });
        });
    });



    // Function to update the total fund amount
    function updateFundAmount() {
        var sparesAmount = parseFloat($("#spares_calculated_amount").text()) || 0; // spares cost
        var siteAmount = parseFloat($("#site_calculated_amount").text()) || 0; // travelling cost
        var vendor_amount = $("input[name='vendor_amount']").val() ? $("input[name='vendor_amount']").val() : 0; // vendor cost


        var totalAmount = parseFloat(sparesAmount) + parseFloat(siteAmount) + parseFloat(vendor_amount);

        $("#fund_amount").val(totalAmount);

    }


    $(document).on('input', 'input[name="spares_cost[]"]', function() {
        var totalSparesCost = 0;

        $("input[name='spares_cost[]']").each(function() {
            var cost = parseFloat($(this).val()) || 0; // Use 0 if the value is not a valid number
            totalSparesCost += cost;
        });

        $("#spares_calculated_amount").text(totalSparesCost);
        updateFundAmount();
    });


    $(document).on('input', 'input[name="vendor_amount"]', function() {
        updateFundAmount();
    });

    function refreshCalculations() {
        setTimeout(function() {
            var totalDistance = total_calculated_travel_amount = 0;

            $(".travel_distance").each(function() {
                var distance = parseFloat($(this).val()) || 0;
                totalDistance += distance;
            });
            $(".calculated_amount").each(function() {
                var this_calculated_amount = parseFloat($(this).val()) || 0;
                total_calculated_travel_amount += this_calculated_amount;
            });

            console.log(total_calculated_travel_amount);


            $("#total_distance").text(totalDistance);
            $("#site_calculated_amount").text(total_calculated_travel_amount);

            var totalSparesCost = 0;
            $("input[name='spares_cost[]']").each(function() {
                var cost = parseFloat($(this).val()) || 0; // Default to 0 if empty or invalid
                totalSparesCost += cost;
            });
            $("#spares_calculated_amount").text(totalSparesCost); // Update spare cost total

            var vendor_amount = parseFloat($("input[name='vendor_amount']").val()) || 0;

            // Calculate the total fund amount
            var totalFundAmount = totalSparesCost + total_calculated_travel_amount + vendor_amount;

            console.log(totalFundAmount);
            $("#fund_amount").val(totalFundAmount);

        }, 300); // Adding 300ms delay to ensure AJAX values update first
    }

    $(document).on('change', '.travel_type', function() {
        var $row = $(this).closest(".travel-row");
        var selectedTravelType = $(this).val().trim().toLowerCase(); // Normalize input

        console.log("Selected Travel Type:", selectedTravelType);

        $row.find(".travel_distance").val('0');
        $row.find(".calculated_amount").val('0');

        if (selectedTravelType === 'resident to site') {
            console.log(1);
            $('#resident_to_site_section').removeClass('hidden');
            $('#site_to_site_section').addClass('hidden');
            $row.find(".from_site").val('Resident').trigger('change');

        } else if (selectedTravelType === 'site to site') {
            console.log(2);
            $('#site_to_site_section').removeClass('hidden');
            $('#resident_to_site_section').addClass('hidden');
            $row.find(".from_site").val('');
            $row.find(".to_site").val('');

        } else if (selectedTravelType === 'site to resident') {
            console.log(3);
            $('#resident_to_site_section').addClass('hidden');
            $('#site_to_site_section').addClass('hidden');

            // Ensure correct selection of 'Resident' in the to_site dropdown
            $row.find(".to_site option").each(function() {
                if ($(this).val().trim().toLowerCase() === 'resident') {
                    $(this).prop("selected", true).trigger('change');
                }
            });

        } else {
            console.log(4);
        }
    });

    $(document).on('change', '.from_site', function() {
        var $row = $(this).closest(".travel-row");

        var selectedTravelType = $row.find('td .travel_type').val();
        if (selectedTravelType === 'Site to Resident') {
            $row.find("td .to_site").val('Resident').trigger('change');
        }

    });

    $(document).on('change', '.to_site', function() {
        let toatmid = $(this).val();
        let fund_type = 'Travelling';

        var $row = $(this).closest(".travel-row");
        let travel_type = $row.find('td .travel_type').val();

        if (travel_type == 'Site to Resident') {
            let fromToResident = $row.find('td .from_site').val();
            toatmid = fromToResident; // ✅ Corrected
            console.log("Updated toatmid:", toatmid);
        }

        $.ajax({
            url: 'validateFundRequest2.php',
            type: 'POST',
            data: {
                atmid: toatmid, // ✅ Correct value is now sent
                fund_type: fund_type
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                $('#travel_type_container').find("select, input").prop("required", true);
                if (response.isEligible == 1 || response.isEligible == 0) {

                    $row.find(".isEligibleForFund").val(response.isEligible);
                    $row.find(".travel_distance").val(response.distance);
                    $row.find(".calculated_amount").val(response.amount);
                } else if (response.isEligible == 2) {
                    $row.find(".isEligibleForFund").val(2);
                    $row.find(".travel_distance").val('0');
                    $row.find(".calculated_amount").val('0');
                    // alert('No Mapping Found For the selected ATM Address');
                }

                setTimeout(refreshCalculations, 300); // Delay refresh after AJAX success
            },
            error: function(xhr, status, error) {
                console.error("❌ AJAX Error:", error);
            }
        });
    });


    $(document).on('input', '.travel_distance', function() {

        var travel_distance = $(this).val();
        var $row = $(this).closest(".travel-row");

        var isEligibletoChangeAmount = $row.find(".isEligibleForFund").val();

        if (isEligibletoChangeAmount == 1) {
            let new_travel_distance = travel_distance;
            let new_cal_amount = new_travel_distance * 3;
            $row.find('.calculated_amount').val(new_cal_amount);

        }


    });


    $(document).on('input', 'input[name="spares_cost[]"] , .travel_distance', function() {
        refreshCalculations();
    });
    $(document).on('change', '.to_site , .from_site', function() {
        refreshCalculations();
    });

    $(document).on('click', '.remove-spare , .remove-travel', function() {
        refreshCalculations();

    });
</script>
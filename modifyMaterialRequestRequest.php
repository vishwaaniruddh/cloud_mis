<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formData = $_POST["formData"];
    $action = $_POST["action"];
    $misid = $_POST["misid"];

    parse_str($formData, $formFields);

    $material = $formFields["material"];
    $oldRemark = $formFields["oldRemark"];
    $newRemark = $formFields["newRemark"];
    $approveID = $formFields["pre_material_inventoryID"];



    $getsqlmis = mysqli_query($con,"select * from mis_details where id='".$misid."'");
    $getsqlmis_result = mysqli_fetch_assoc($getsqlmis);
    
    $parentmis_id = $getsqlmis_result['mis_id']; // mis table
    
    if ($action == "approve") {

        $hissql = mysqli_query($con,"select * from mis_history where mis_id='".$misid."' and type='material_requirement' order by id desc");
        $hissqlResult = mysqli_fetch_assoc($hissql) ; 
        
        
        $material_condition = $hissqlResult['material_condition'];
        $datetime = $hissqlResult['created_at'];
        $address = $hissqlResult['delivery_address'];
        $contact_name = $hissqlResult['contact_person_name'];
        $contact_mob = $hissqlResult['contact_person_mob'];
        $emailAttachment_MaterialRequirementLink = $hissqlResult['emailAttachment_MaterialRequirement'];
        $imageUrlsString = $hissqlResult['images_MaterialRequirement'];
        
        
        $query =
            "INSERT INTO mis_history (mis_id, type, remark, material,material_condition, status, created_at, created_by,delivery_address,contact_person_name,
            contact_person_mob,emailAttachment_MaterialRequirement,images_MaterialRequirement)
            VALUES ($misid, 'Material Request Approved', '$newRemark', '$material','".$material_condition."', 1, '" .$datetime ."', '" .$userid ."',
            '".$address."','".$contact_name."','".$contact_mob."','".$emailAttachment_MaterialRequirementLink."','".$imageUrlsString."')";
                  
        if (mysqli_query($con, $query)) {
            
            
            mysqli_query($con,"UPDATE mis_details set status='material_request_approved' where id = '".$misid."' ");

            $getsql = mysqli_query($con, "select * from pre_material_inventory where id='" . $approveID . "'");
            $getsql_result = mysqli_fetch_assoc($getsql);



            $mis_id = $getsql_result["mis_id"];
            $material = $getsql_result["material"];
            $material_condition = $getsql_result["material_condition"];
            $remark = $getsql_result["remark"];
            $status = $getsql_result["status"];
            $created_at = $getsql_result["created_at"];
            $created_by = $getsql_result["created_by"];
            $delivery_address = $getsql_result["delivery_address"];
            $cancel_remarks = $getsql_result["cancel_remarks"];

            $sql =
                "INSERT INTO material_inventory (mis_id, material, material_condition, remark, status, created_at, created_by, delivery_address, cancel_remarks) 
                VALUES ('$mis_id', '$material', '$material_condition', '$remark', '$status', '$created_at', '$created_by', '$delivery_address', '$cancel_remarks')";

            if (mysqli_query($con, $sql)) {
                mysqli_query($con, "UPDATE pre_material_inventory SET is_approved=1,actionDate='".$datetime."' WHERE id='" . $approveID . "'");
            }
        }
    } elseif ($action == "reject") {

        $query =
            "INSERT INTO mis_history (mis_id, type, remark, material, status, created_at, created_by)
                  VALUES ('$misid', 'Material Request Rejected', '$newRemark', '$material', 1, '" .
            $datetime .
            "', '" .
            $userid .
            "')";

        if (mysqli_query($con, $query)) {
            
                                mysqli_query($con,"UPDATE mis_details set status='material_request_rejected' where id = '".$misid."' ");


            $getsql = mysqli_query($con, "select * from pre_material_inventory where id='" . $approveID . "'");
            $getsql_result = mysqli_fetch_assoc($getsql);

            $mis_id = $getsql_result["mis_id"];
            $material = $getsql_result["material"];
            $material_condition = $getsql_result["material_condition"];
            $remark = $getsql_result["remark"];
            $status = $getsql_result["status"];
            $created_at = $getsql_result["created_at"];
            $created_by = $getsql_result["created_by"];
            $delivery_address = $getsql_result["delivery_address"];
            $cancel_remarks = $getsql_result["cancel_remarks"];

            $sql = "INSERT INTO material_inventory (mis_id, material, material_condition, remark, status, created_at, created_by, delivery_address, cancel_remarks) 
            VALUES ('$mis_id', '$material', '$material_condition', '$remark', '$status', '$created_at', '$created_by', '$delivery_address', '$cancel_remarks')";

            if (mysqli_query($con, $sql)) {
                mysqli_query($con, "UPDATE pre_material_inventory SET is_approved=2,actionDate='".$datetime."' WHERE id='" . $approveID . "'");
            }
        }
    }

    if ($query) {
        echo json_encode([
            "status" => "success",
            "message" => "Data saved successfully",
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Error saving data",
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method",
    ]);
}
?>

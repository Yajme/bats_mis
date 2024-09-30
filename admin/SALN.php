<?php include("../model/conne.php"); ?>
<!DOCTYPE html>



<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>BATS MIS | Manage Files</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/logo.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>


    <script src="../assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->



    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $id = $_GET['eid'];
    $date= new DateTime($_POST['saln_date']);
        $saln_date = $date->format('Y-m-d')?? '';

        // Get Declarant Details
        $declarant_first_name = $_POST['declarant_first_name'] ?? '';
        $declarant_last_name = $_POST['declarant_last_name'] ?? '';
        $declarant_address = $_POST['declarant_address'] ?? '';
        $declarant_position = $_POST['declarant_position'] ?? '';
        $declarant_agency = $_POST['declarant_agency'] ?? '';
        $declarant_office_address = $_POST['declarant_office_address'] ?? '';

        // Get Spouse Details
        $spouse_first_name = $_POST['spouse_first_name'] ?? '';
        $spouse_last_name = $_POST['spouse_last_name'] ?? '';
        $spouse_address = $_POST['spouse_address'] ?? '';
        $spouse_position = $_POST['spouse_position'] ?? '';
        $spouse_agency = $_POST['spouse_agency'] ?? '';
        $spouse_office_address = $_POST['spouse_office_address'] ?? '';

        // Get Children Details
        $child_name = $_POST['child_name'] ?? '';
        $child_dob = $_POST['child_dob'] ?? '';
        $child_age = $_POST['child_age'] ?? '';

        // Get Asset Details
        $asset_description = $_POST['asset_description'] ?? '';
        $asset_kind = $_POST['asset_kind'] ?? '';
        $asset_location = $_POST['asset_location'] ?? '';
        $asset_assessed_value = $_POST['asset_assessed_value'] ?? '';
        $asset_market_value = $_POST['asset_market_value'] ?? '';
        $asset_acquisition_date = $_POST['asset_acquisition_date'] ?? '';
        $asset_acquisition_cost = $_POST['asset_acquisition_cost'] ?? '';

        // Get Liability Details
        $liability_nature = $_POST['liability_nature'] ?? '';
        $liability_name = $_POST['liability_name'] ?? '';
        $liability_balance = $_POST['liability_balance'] ?? '';

        $personal_property_description = $_POST['personal_property_description'];
        $personal_property_year_acquired = $_POST['personal_property_year_acquired'];
        $personal_property_cost = $_POST['personal_property_cost'];


        // Get Business Details
        $business_name = $_POST['business_name'] ?? '';
        $business_address = $_POST['business_address'] ?? '';
        $business_nature = $_POST['business_nature'] ?? '';
        $business_date_of_acquisition = $_POST['business_date_of_acquisition'] ?? '';

        // Get Relative Details
        $relative_name = $_POST['relative_name'] ?? '';
        $relative_relationship = $_POST['relative_relationship'] ?? '';
        $relative_position = $_POST['relative_position'] ?? '';
        $relative_agency_and_address = $_POST['relative_agency_and_address'] ?? '';

        $no_business = isset($_POST['no_business']) ? $_POST['no_business'] : 0;
        $no_relatives = isset($_POST['no_relatives']) ? $_POST['no_relatives'] : 0;

    if (isset($_POST['Register'])) {
        
        
        
        // Insert to SALN table
        $sql = "INSERT INTO SALN (date, declarant_first_name, declarant_last_name, declarant_address, declarant_position, declarant_agency, declarant_office_address, spouse_first_name, spouse_last_name, spouse_address, spouse_position, spouse_agency, spouse_office_address, employee_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssssssssssi', $saln_date, $declarant_first_name, $declarant_last_name, $declarant_address, $declarant_position, $declarant_agency, $declarant_office_address, $spouse_first_name, $spouse_last_name, $spouse_address, $spouse_position, $spouse_agency, $spouse_office_address, $id);

        if ($stmt->execute()) {
            // Get the last inserted saln_id
            $saln_id = $conn->insert_id;

            $sql = "INSERT INTO SALN_Children (saln_id, child_name, child_dob, child_age) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param('issi', $saln_id, $child_name, $child_dob, $child_age);
            $stmt->execute();

            $sql = "INSERT INTO SALN_Assets (saln_id, asset_description, asset_kind, asset_location, asset_assessed_value, asset_market_value, asset_acquisition_date, asset_acquisition_cost) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param('isssdssd', $saln_id, $asset_description, $asset_kind, $asset_location, $asset_assessed_value, $asset_market_value, $asset_acquisition_date, $asset_acquisition_cost);
            $stmt->execute();

            $sql = "INSERT INTO SALN_PersonalProperty (saln_id, personal_property_description, personal_property_year_acquired, personal_property_cost) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param('isid', $saln_id, $personal_property_description, $personal_property_year_acquired, $personal_property_cost);
            $stmt->execute();


            $sql = "INSERT INTO SALN_Liabilities (saln_id, liability_nature, liability_name, liability_balance) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('isid', $saln_id, $liability_nature, $liability_name, $liability_balance);
            $stmt->execute();

            if ($no_business != 'on') {
                $sql = "INSERT INTO SALN_Businesses (saln_id, business_name, business_address, business_nature, business_date_of_acquisition) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);

                $stmt->bind_param('issss', $saln_id, $business_name, $business_address, $business_nature, $business_date_of_acquisition);
                $stmt->execute();
            }

            if ($no_relatives!= 'on') {
                $sql = "INSERT INTO SALN_Relatives (saln_id, relative_name, relative_relationship, relative_position, relative_agency_and_address) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);

                $stmt->bind_param('issss', $saln_id, $relative_name, $relative_relationship, $relative_position, $relative_agency_and_address);
                $stmt->execute();
            }
                
        }
        
        echo '<script> 
        alert("Register File Information Successful!");
        window.location.href = "manage-files.php?saln='.$saln_id.'";
        </script>';
    }
    if (isset($_POST['Update'])) {
        $saln_id = $_SESSION['saln_id'];

        $id = $_GET['eid'];
        $saln_date = $_POST['saln_date'] ?? '';

        // Update SALN table
        $sql = "UPDATE SALN SET date=?, declarant_first_name=?, declarant_last_name=?, declarant_address=?, declarant_position=?, declarant_agency=?, declarant_office_address=?, spouse_first_name=?, spouse_last_name=?,spouse_address=?, spouse_position=?, spouse_agency=?, spouse_office_address=? WHERE employee_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssssssssssi', $saln_date, $declarant_first_name, $declarant_last_name,$declarant_address, $declarant_position, $declarant_agency, $declarant_office_address, $spouse_first_name,$spouse_last_name, $spouse_address, $spouse_position, $spouse_agency, $spouse_office_address, $id);
        $stmt->execute();


        // Update SALN_Children table
        $sql = "UPDATE SALN_Children SET child_name=?, child_dob=?, child_age=? WHERE saln_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssii', $child_name, $child_dob, $child_age, $saln_id);
        $stmt->execute();

        // Update SALN_Assets table
        $sql = "UPDATE SALN_Assets SET asset_description=?, asset_kind=?, asset_location=?, asset_assessed_value=?, asset_market_value=?, asset_acquisition_date=?, asset_acquisition_cost=? WHERE saln_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssdssdi', $asset_description, $asset_kind, $asset_location, $asset_assessed_value, $asset_market_value, $asset_acquisition_date, $asset_acquisition_cost, $saln_id);
        $stmt->execute();

        // Update SALN_PersonalProperty table
        $sql = "UPDATE SALN_PersonalProperty SET personal_property_description=?, personal_property_year_acquired=?, personal_property_cost=? WHERE saln_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sidi', $personal_property_description, $personal_property_year_acquired, $personal_property_cost, $saln_id);
        $stmt->execute();

        // Update SALN_Liabilities table
        $sql = "UPDATE SALN_Liabilities SET liability_nature=?, liability_name=?, liability_balance=? WHERE saln_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdi', $liability_nature, $liability_name, $liability_balance, $saln_id);
        $stmt->execute();

        if ($no_business != 'on') {
            $sql = "UPDATE SALN_Businesses SET business_name=?, business_address=?, business_nature=?, business_date_of_acquisition=? WHERE saln_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssi', $business_name, $business_address, $business_nature, $business_date_of_acquisition, $saln_id);
            $stmt->execute();
        }

        if ($no_relatives != 'on') {
            $sql = "UPDATE SALN_Relatives SET relative_name=?, relative_relationship=?, relative_position=?, relative_agency_and_address=? WHERE saln_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssi', $relative_name, $relative_relationship, $relative_position, $relative_agency_and_address, $saln_id);
            $stmt->execute();
        }

echo '<script> 
alert("Edit File Information Successful!");
window.location.href = "manage-files.php?saln='.$saln_id.'";
</script>';
    }
 } 
    if (isset($_GET['eid'])) {
        $id= $_GET['eid'];
       $query = 'SELECT * from view_saln WHERE employee_id = '.$id;
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            // Output data of each row
            $row = $result->fetch_assoc();
            $_SESSION['saln_id'] = $row['saln_id'];
        }
    } 
    ?>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?php include("./nav.php"); ?>

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><?php if (isset($_GET['user_id'])) {
                                                                                        echo "Edit";
                                                                                    } else {
                                                                                        echo "Register";
                                                                                    }; ?> File/</span> Administrator</h4>

                    <!-- Basic Layout & Basic with Icons -->
                    <div class="row">
                        <!-- Basic Layout -->
                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Input Information</h5>
                                </div>
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <!-- SALN Main Form -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="saln_date">Date</label>
                                            <div class="col-sm-10">
                                                <input type="date" required class="form-control" name="saln_date" id="saln_date" placeholder="Enter date" value="" />
                                            </div>
                                        </div>

                                        <!-- Declarant Details -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="declarant_first_name">Declarant Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" required class="form-control" name="declarant_first_name" id="declarant_first_name" placeholder="Enter declarant first name" value="<?php echo $row['declarant_first_name'] ?? ''; ?>" />
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text" required class="form-control" name="declarant_last_name" id="declarant_last_name" placeholder="Enter declarant last name" value="<?php echo $row['declarant_last_name'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="declarant_address">Declarant Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" required class="form-control" name="declarant_address" id="declarant_address" placeholder="Enter declarant address" value="<?php echo $row['declarant_address'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="declarant_position">Declarant Position</label>
                                            <div class="col-sm-10">
                                                <input type="text" required class="form-control" name="declarant_position" id="declarant_position" placeholder="Enter declarant position" value="<?php echo $row['declarant_position'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="declarant_agency">Declarant Agency</label>
                                            <div class="col-sm-10">
                                                <input type="text" required class="form-control" name="declarant_agency" id="declarant_agency" placeholder="Enter declarant agency" value="<?php echo $row['declarant_agency'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="declarant_office_address">Declarant Office Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" required class="form-control" name="declarant_office_address" id="declarant_office_address" placeholder="Enter declarant office address" value="<?php echo $row['declarant_office_address'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <!-- Spouse Details -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="spouse_first_name">Spouse Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="spouse_first_name" id="spouse_first_name" placeholder="Enter spouse first name" value="<?php echo $row['spouse_first_name'] ?? ''; ?>" />
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="spouse_last_name" id="spouse_last_name" placeholder="Enter spouse last name" value="<?php echo $row['spouse_last_name'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="spouse_address">Spouse Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="spouse_address" id="spouse_address" placeholder="Enter spouse address" value="<?php echo $row['spouse_address'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="spouse_position">Spouse Position</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="spouse_position" id="spouse_position" placeholder="Enter spouse position" value="<?php echo $row['spouse_position'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="spouse_agency">Spouse Agency</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="spouse_agency" id="spouse_agency" placeholder="Enter spouse agency" value="<?php echo $row['spouse_agency'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="spouse_office_address">Spouse Office Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="spouse_office_address" id="spouse_office_address" placeholder="Enter spouse office address" value="<?php echo $row['spouse_office_address'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <!-- Children Details -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="child_name">Child Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="child_name" id="child_name" placeholder="Enter child name" value="<?php echo $row['child_name'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="child_dob">Child Date of Birth</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" name="child_dob" id="child_dob" placeholder="Enter child date of birth" value="<?php echo $row['child_dob'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="child_age">Child Age</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="child_age" id="child_age" placeholder="Enter child age" value="<?php echo $row['child_age'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <!-- Asset Details -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="asset_description">Asset Description</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="asset_description" id="asset_description" placeholder="Enter asset description" value="<?php echo $row['asset_description'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="asset_kind">Asset Kind</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="asset_kind" id="asset_kind" placeholder="Enter asset kind" value="<?php echo $row['asset_kind'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="asset_location">Asset Location</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="asset_location" id="asset_location" placeholder="Enter asset location" value="<?php echo $row['asset_location'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="asset_assessed_value">Asset Assessed Value</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="asset_assessed_value" id="asset_assessed_value" placeholder="Enter asset assessed value" value="<?php echo $row['asset_assessed_value'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="asset_market_value">Asset Market Value</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="asset_market_value" id="asset_market_value" placeholder="Enter asset market value" value="<?php echo $row['asset_market_value'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="asset_acquisition_date">Asset Acquisition Date</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" name="asset_acquisition_date" id="asset_acquisition_date" placeholder="Enter acquisition date" value="<?php echo $row['asset_acquisition_date'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="asset_acquisition_cost">Asset Acquisition Cost</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="asset_acquisition_cost" id="asset_acquisition_cost" placeholder="Enter acquisition cost" value="<?php echo $row['asset_acquisition_cost'] ?? ''; ?>" />
                                            </div>
                                        </div>
                                        <!--Personal Assets -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="personal_property_description">Personal Property Description</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="personal_property_description" id="personal_property_description" placeholder="Enter personal property description" value="<?php echo $row['personal_property_description'] ?? ''; ?>"required />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="personal_property_year_acquired">Year Acquired</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="personal_property_year_acquired" id="personal_property_year_acquired" placeholder="Enter year acquired" value="<?php echo $row['personal_property_year_acquired'] ?? ''; ?>" required />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="personal_property_cost">Cost</label>
                                            <div class="col-sm-10">
                                                <input type="number" step="0.01" class="form-control" name="personal_property_cost" id="personal_property_cost" placeholder="Enter cost" value="<?php echo $row['personal_property_cost'] ?? ''; ?>"required />
                                            </div>
                                        </div>
                                        <!-- Liability Details -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="liability_nature">Liability Nature</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="liability_nature" id="liability_nature" placeholder="Enter liability nature" value="<?php echo $row['liability_nature'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="liability_name">Liability Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="liability_name" id="liability_name" placeholder="Enter liability name" value="<?php echo $row['liability_name'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="liability_balance">Liability Balance</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="liability_balance" id="liability_balance" placeholder="Enter liability balance" value="<?php echo $row['liability_balance'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <!-- No Business Checkbox -->
                                        <div class="row mb-3">
                                            <div class="col-sm-10 offset-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="no_business" name="no_business">
                                                    <label class="form-check-label" for="no_business">
                                                        I have no business
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Business Details -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="business_name">Business Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="business_name" id="business_name" placeholder="Enter business name" value="<?php echo $row['business_name'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="business_address">Business Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="business_address" id="business_address" placeholder="Enter business address" value="<?php echo $row['business_address'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="business_nature">Business Nature</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="business_nature" id="business_nature" placeholder="Enter business nature" value="<?php echo $row['business_nature'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="business_date_of_acquisition">Business Date of Acquisition</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" name="business_date_of_acquisition" id="business_date_of_acquisition" placeholder="Enter date of acquisition" value="<?php echo $row['business_date_of_acquisition'] ?? ''; ?>" />
                                            </div>
                                        </div>
                                        <!-- No Relatives Checkbox -->
                                        <div class="row mb-3">
                                            <div class="col-sm-10 offset-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="no_relatives" name="no_relatives">
                                                    <label class="form-check-label" for="no_relatives">
                                                        I have no relatives
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Relative Details -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="relative_name">Relative Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="relative_name" id="relative_name" placeholder="Enter relative name" value="<?php echo $row['relative_name'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="relative_relationship">Relative Relationship</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="relative_relationship" id="relative_relationship" placeholder="Enter relative relationship" value="<?php echo $row['relative_relationship'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="relative_position">Relative Position</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="relative_position" id="relative_position" placeholder="Enter relative position" value="<?php echo $row['relative_position'] ?? ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="relative_agency_and_address">Relative Agency and Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="relative_agency_and_address" id="relative_agency_and_address" placeholder="Enter relative agency and address" value="<?php echo $row['relative_agency_and_address'] ?? ''; ?>" />
                                            </div>
                                        </div>





                                        <div class="row justify-content-end">
                                            <div class="col-sm-10">
                                                <button type="submit" name="<?php echo isset($_GET['eid']) ? "Update" : "Register"; ?>" class="btn btn-primary"><?php echo isset($_GET['eid']) ? "Update" : "Register"; ?> File</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Basic with Icons -->

                    </div>
                </div>
                <!-- / Content -->
                <script>
                    document.getElementById('no_business').addEventListener('change', function() {
                        const businessFields = [
                            'business_name',
                            'business_address',
                            'business_nature',
                            'business_date_of_acquisition'
                        ];

                        businessFields.forEach(field => {
                            document.getElementById(field).disabled = this.checked;
                        });
                    });
                    document.getElementById('no_relatives').addEventListener('change', function() {
                        const relativeFields = [
                            'relative_name',
                            'relative_relationship',
                            'relative_position',
                            'relative_agency_and_address'
                        ];

                        relativeFields.forEach(field => {
                            document.getElementById(field).disabled = this.checked;
                        });
                    });
                </script>
                <!-- Footer -->
                <?php include("./footer.php"); ?>
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
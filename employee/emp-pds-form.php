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

        //var_dump($_POST);
        
        //Information
        $surname = $_POST['surname'];
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $name_extension = $_POST['name_extension'];
        $date_of_birth = $_POST['date_of_birth'];
        $place_of_birth = $_POST['place_of_birth'];
        $sex = $_POST['sex'];
        $civil_status = $_POST['civil_status'];
        $height = $_POST['height'];
        $weight = $_POST['weight'];
        $blood_type = $_POST['blood_type'];
        $gsis_id_no = $_POST['gsis_id_no'];
        $philhealth_no = $_POST['philhealth_no'];
        $sss_no = $_POST['sss_no'];
        $tin_no = $_POST['tin_no'];
        $citizenship = $_POST['citizenship'];
        $dual_citizenship_country = $_POST['dual_citizenship_country'];
        //Address
        $residential_address = $_POST['residential_address'];
        $permanent_zip_code = $_POST['permanent_zip_code'];
        //Contact
        $telephone_no = $_POST['telephone_no'];
        $mobile_no = $_POST['mobile_no'];
        $email_address = $_POST['email_address'];
        //
        $spouse_surname = $_POST['spouse_surname'];
        $spouse_first_name = $_POST['spouse_first_name'];
        $spouse_middle_name = $_POST['spouse_middle_name'];
        $spouse_name_extension = $_POST['spouse_name_extension'];
        $spouse_occupation = $_POST['spouse_occupation'];
        $spouse_employer = $_POST['spouse_employer'];
        $spouse_business_address = $_POST['spouse_business_address'];
        $spouse_telephone = $_POST['spouse_telephone'];
        //children
        $children_name = $_POST['children_name'];
        $children_dob = $_POST['children_dob'];
        //
        $father_surname = $_POST['father_surname'];
        $father_first_name = $_POST['father_first_name'];
        $father_middle_name = $_POST['father_middle_name'];
        $father_name_extension = $_POST['father_name_extension'];
        $mother_surname = $_POST['mother_surname'];
        $mother_first_name = $_POST['mother_first_name'];
        $mother_middle_name = $_POST['mother_middle_name'];
        //Educational Background

        $education_info = [
            'elementary' => [
                'school' => $_POST['elementary_school'] ?? '',
                'degree' => $_POST['elementary_degree'] ?? '',
                'period_from' => $_POST['elementary_period_from'] ?? '',
                'period_to' => $_POST['elementary_period_to'] ?? '',
                'honors' => $_POST['elementary_honors'] ?? ''
            ],
            'secondary' => [
                'school' => $_POST['secondary_school'] ?? '',
                'degree' => $_POST['secondary_degree'] ?? '',
                'period_from' => $_POST['secondary_period_from'] ?? '',
                'period_to' => $_POST['secondary_period_to'] ?? '',
                'honors' => $_POST['secondary_honors'] ?? ''
            ],
            'vocational' => [
                'school' => $_POST['vocational_school'] ?? '',
                'degree' => $_POST['vocational_degree'] ?? '',
                'period_from' => $_POST['vocational_period_from'] ?? '',
                'period_to' => $_POST['vocational_period_to'] ?? '',
                'honors' => $_POST['vocational_honors'] ?? ''
            ],
            'college' => [
                'school' => $_POST['college_school'] ?? '',
                'degree' => $_POST['college_degree'] ?? '',
                'period_from' => $_POST['college_period_from'] ?? '',
                'period_to' => $_POST['college_period_to'] ?? '',
                'honors' => $_POST['college_honors'] ?? ''
            ],
            'graduate' => [
                'school' => $_POST['graduate_school'] ?? '',
                'degree' => $_POST['graduate_degree'] ?? '',
                'period_from' => $_POST['graduate_period_from'] ?? '',
                'period_to' => $_POST['graduate_period_to'] ?? '',
                'honors' => $_POST['graduate_honors'] ?? ''
            ]
        ];


        if (isset($_POST['Register'])) {
            $emp_id = $_SESSION['employee_id'];


            //Add Personal Information
            $sql = "INSERT INTO pds_personal_information (surname, first_name, middle_name, name_extension, date_of_birth, place_of_birth, sex, civil_status, height, weight, blood_type, gsis_id_no, pagibig_id_no, philhealth_no, sss_no, tin_no, agency_employee_no, citizenship, dual_citizenship_country,employee_id)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssddsssssssssi", $surname, $first_name, $middle_name, $name_extension, $date_of_birth, $place_of_birth, $sex, $civil_status, $height, $weight, $blood_type, $gsis_id_no, $pagibig_id_no, $philhealth_no, $sss_no, $tin_no, $agency_employee_no, $citizenship, $dual_citizenship_country,$emp_id);

            if ($stmt->execute()) {
                $personal_info_id = $conn->insert_id;
                $sql = "INSERT INTO pds_addresses (personal_info_id, residential_address, residential_zip_code, permanent_address, permanent_zip_code)
                VALUES (?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issss", $personal_info_id, $residential_address, $residential_zip_code, $permanent_address, $permanent_zip_code);
                $stmt->execute();

                $sql = "INSERT INTO pds_contact_information (personal_info_id, telephone_no, mobile_no, email_address)
                VALUES (?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isss", $personal_info_id, $telephone_no, $mobile_no, $email_address);
                $stmt->execute();
                $sql = "INSERT INTO pds_family_information (personal_info_id, spouse_surname, spouse_first_name, spouse_middle_name, spouse_name_extension, spouse_occupation, spouse_employer_name, spouse_business_address, spouse_telephone_no, father_surname, father_first_name, father_middle_name, father_name_extension, mother_maiden_name, mother_first_name, mother_middle_name)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isssssssssssssss", $personal_info_id, $spouse_surname, $spouse_first_name, $spouse_middle_name, $spouse_name_extension, $spouse_occupation, $spouse_employer_name, $spouse_business_address, $spouse_telephone_no, $father_surname, $father_first_name, $father_middle_name, $father_name_extension, $mother_maiden_name, $mother_first_name, $mother_middle_name);
                if ($stmt->execute()) {
                    $family_id = $conn->insert_id;
                    $sql = "INSERT INTO pds_children (family_id, child_name, child_date_of_birth)
                VALUES (?, ?, ?)";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iss", $family_id, $child_name, $child_date_of_birth);
                    $stmt->execute();
                }


                $sql = "INSERT INTO pds_educational_background (personal_info_id, level, school_name, degree_or_course, period_of_attendance_from, period_of_attendance_to, highest_level_units_earned, year_graduated, scholarships_academic_honors)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                foreach ($education_info as $school => $value) {
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("issssssss", $personal_info_id, $school, $value['school'], $value['degree'], $value['period_from'], $value['period_to'], $highest_level_units_earned, $value['period_to'], $value['honors']);
                    $stmt->execute();
                }
            }
            echo '<script> 
            alert("Register File Information Successful!");
            window.location.href = "manage-files.php?pds='.$personal_info_id.'";
            </script>';
        }
        if (isset($_POST['Update'])) {
            $emp_id = $_SESSION['employee_id'];

            // Update Personal Information
            $sql = "UPDATE pds_personal_information SET surname=?, first_name=?, middle_name=?, name_extension=?, date_of_birth=?, place_of_birth=?, sex=?, civil_status=?, height=?, weight=?, blood_type=?, gsis_id_no=?, pagibig_id_no=?, philhealth_no=?, sss_no=?, tin_no=?, agency_employee_no=?, citizenship=?, dual_citizenship_country=? WHERE employee_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssddsssssssssi", $surname, $first_name, $middle_name, $name_extension, $date_of_birth, $place_of_birth, $sex, $civil_status, $height, $weight, $blood_type, $gsis_id_no, $pagibig_id_no, $philhealth_no, $sss_no, $tin_no, $agency_employee_no, $citizenship, $dual_citizenship_country, $emp_id);
            $stmt->execute();

            // Update Address Information
            $sql = "UPDATE pds_addresses SET residential_address=?, residential_zip_code=?, permanent_address=?, permanent_zip_code=? WHERE personal_info_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $residential_address, $residential_zip_code, $permanent_address, $permanent_zip_code, $_SESSION['personal_id']);
            $stmt->execute();

            // Update Contact Information
            $sql = "UPDATE pds_contact_information SET telephone_no=?, mobile_no=?, email_address=? WHERE personal_info_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $telephone_no, $mobile_no, $email_address, $_SESSION['personal_id']);
            $stmt->execute();

            // Update Family Information
            $sql = "UPDATE pds_family_information SET spouse_surname=?, spouse_first_name=?, spouse_middle_name=?, spouse_name_extension=?, spouse_occupation=?, spouse_employer_name=?, spouse_business_address=?, spouse_telephone_no=?, father_surname=?, father_first_name=?, father_middle_name=?, father_name_extension=?, mother_maiden_name=?, mother_first_name=?, mother_middle_name=? WHERE personal_info_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssssssss", $spouse_surname, $spouse_first_name, $spouse_middle_name, $spouse_name_extension, $spouse_occupation, $spouse_employer_name, $spouse_business_address, $spouse_telephone_no, $father_surname, $father_first_name, $father_middle_name, $father_name_extension, $mother_maiden_name, $mother_first_name, $mother_middle_name, $_SESSION['personal_id']);
            $stmt->execute();

            // Update Children Information
            $sql = "DELETE FROM pds_children WHERE family_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION['family_id']);
            $stmt->execute();

            $sql = "INSERT INTO pds_children (family_id, child_name, child_date_of_birth) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $_SESSION['family_id'], $children_name, $children_dob);
            $stmt->execute();

            // Update Educational Background
            $sql = "DELETE FROM pds_educational_background WHERE personal_info_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION['personal_id']);
            $stmt->execute();

            $sql = "INSERT INTO pds_educational_background (personal_info_id, level, school_name, degree_or_course, period_of_attendance_from, period_of_attendance_to, highest_level_units_earned, year_graduated, scholarships_academic_honors) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            foreach ($education_info as $school => $value) {
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issssssss", $_SESSION['personal_id'], $school, $value['school'], $value['degree'], $value['period_from'], $value['period_to'], $highest_level_units_earned, $value['period_to'], $value['honors']);
                $stmt->execute();
            }

            echo '<script> 
            alert("Update File Information Successful!");
            window.location.href = "manage-files.php?pds='.$_SESSION['personal_id'].'";
            </script>';
        }
    }

    if(isset($_GET['eid'])){
        $id= $_GET['eid'];
        $query = 'SELECT * from view_pds WHERE employee_id = '.$id.' LIMIT 1';
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            // Output data of each row
            $row = $result->fetch_assoc();
            $_SESSION['personal_id'] = $row['personal_id'];
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
                                                                                    }; ?> File/</span> Employee</h4>

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


                                        <!-- Personal Details -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="surname">Surname</label>
                                            <div class="col-sm-5">
                                                <input type="text" required class="form-control" name="surname" id="surname" placeholder="Enter surname" value="<?php echo $row['surname'] ?? '';?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="first_name">First Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" required class="form-control" name="first_name" id="first_name" placeholder="Enter first name" value ="<?php echo $row['first_name'] ?? '';?>"/>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="middle_name">Middle Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Enter middle name" value="<?php echo $row['middle_name'] ?? '';?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="name_extension">Name Extension</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="name_extension" id="name_extension" placeholder="Enter name extension (Jr, Sr, etc.)"value="<?php echo $row['name_extension'] ?? '';?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="date_of_birth">Date of Birth</label>
                                            <div class="col-sm-5">
                                                <input type="date" required class="form-control" name="date_of_birth" id="date_of_birth"value="<?php echo $row['date_of_birth'] ?? '';?>" />
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="place_of_birth">Place of Birth</label>
                                            <div class="col-sm-5">
                                                <input type="text" required class="form-control" name="place_of_birth" id="place_of_birth" placeholder="Enter place of birth" value="<?php echo $row['place_of_birth'] ?? '';?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="sex">Sex</label>
                                            <div class="col-sm-5">
                                                <select required class="form-control" name="sex" id="sex">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="civil_status">Civil Status</label>
                                            <div class="col-sm-5">
                                                <select required class="form-control" name="civil_status" id="civil_status">
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Widowed">Widowed</option>
                                                    <option value="Separated">Separated</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Height and Weight -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="height">Height (m)</label>
                                            <div class="col-sm-5">
                                                <input type="number" step="0.01" required class="form-control" name="height" id="height" placeholder="Enter height in meters"value="<?php echo $row['height'] ?? '';?>" />
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="weight">Weight (kg)</label>
                                            <div class="col-sm-5">
                                                <input type="number" step="0.1" required class="form-control" name="weight" id="weight" placeholder="Enter weight in kilograms" value="<?php echo $row['weight'] ?? '';?>"/>
                                            </div>
                                        </div>
                                        <!-- Blood Type and Identification Numbers -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="blood_type">Blood Type</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="blood_type" id="blood_type" placeholder="Enter blood type"value="<?php echo $row['blood_type'] ?? '';?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="gsis_id_no">GSIS ID No.</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="gsis_id_no" id="gsis_id_no" placeholder="Enter GSIS ID No."value="<?php echo $row['gsis_id_no'] ?? '';?>" />
                                            </div>
                                        </div>

                                        <!-- Additional IDs -->
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="philhealth_no">PhilHealth No.</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="philhealth_no" id="philhealth_no" placeholder="Enter PhilHealth No."value="<?php echo $row['philhealth_no'] ?? '';?>" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="sss_no">SSS No.</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="sss_no" id="sss_no" placeholder="Enter SSS No." value="<?php echo $row['sss_no'] ?? '';?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="tin_no">TIN No.</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="tin_no" id="tin_no" placeholder="Enter TIN No."value="<?php echo $row['tin_no'] ?? '';?>" />
                                            </div>
                                        </div>
                                        <!-- Citizenship -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="citizenship">Citizenship</label>
                                            <div class="col-sm-5">
                                                <select required class="form-control" name="citizenship" id="citizenship">
                                                    <option value="Filipino">Filipino</option>
                                                    <option value="Dual Citizenship">Dual Citizenship</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="dual_citizenship_country">If Dual, Country</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="dual_citizenship_country" id="dual_citizenship_country" placeholder="Enter country if dual citizenship"value="<?php echo $row['dual_citizenship_country'] ?? '';?>" />
                                            </div>
                                        </div>
                                        <!-- Address Section -->
                                        <h4>Address</h4>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="residential_address">Residential Address</label>
                                            <div class="col-sm-5">
                                                <input type="text" required class="form-control" name="residential_address" id="residential_address" placeholder="Enter residential address"value="<?php echo $row['residential_address'] ?? '';?>" />
                                            </div>

                                        </div>


                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="permanent_zip_code">ZIP Code</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="permanent_zip_code" id="permanent_zip_code" placeholder="Enter ZIP Code" value="<?php echo $row['permanent_zip_code'] ?? '';?>"/>
                                            </div>
                                        </div>

                                        <!-- Contact Information -->
                                        <h4>Contact Information</h4>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="telephone_no">Telephone No.</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="telephone_no" id="telephone_no" placeholder="Enter telephone number" value="<?php echo $row['telephone_no'] ?? '';?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="mobile_no">Mobile No.</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Enter mobile number"value="<?php echo $row['mobile_no'] ?? ''; ?>" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="email_address">Email Address</label>
                                            <div class="col-sm-5">
                                                <input type="email" class="form-control" name="email_address" id="email_address" placeholder="Enter email address" value="<?php echo $row['email_address'] ?? ''; ?>"/>
                                            </div>
                                        </div>

                                        <!-- Family Information -->
                                        <h4>Family Information</h4>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="spouse_surname">Spouse's Surname</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="spouse_surname" id="spouse_surname" placeholder="Enter spouse's surname" value="<?php echo $row['spouse_surname'] ?? '';?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="spouse_first_name">Spouse's First Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="spouse_first_name" id="spouse_first_name" placeholder="Enter spouse's first name" value="<?php echo $row['spouse_first_name'] ?? ''; ?>"/>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="spouse_middle_name">Spouse's Middle Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="spouse_middle_name" id="spouse_middle_name" placeholder="Enter spouse's middle name" value="<?php echo $row['spouse_middle_name'] ?? '';?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="spouse_name_extension">Spouse's Name Extension</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="spouse_name_extension" id="spouse_name_extension" placeholder="Enter spouse's name extension (Jr, Sr)" value="<?php echo $row['spouse_name_extension'] ?? '';?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="spouse_occupation">Spouse's Occupation</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="spouse_occupation" id="spouse_occupation" placeholder="Enter spouse's occupation" value="<?php echo $row['spouse_occupation'] ?? ''; ?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="spouse_employer">Employer/Business Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="spouse_employer" id="spouse_employer" placeholder="Enter employer or business name" value="<?php echo $row['spouse_employer'] ?? '';?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="spouse_business_address">Business Address</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="spouse_business_address" id="spouse_business_address" placeholder="Enter business address" value="<?php echo $row['spouse_business_address'] ?? ''; ?>" />
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="spouse_telephone">Telephone No.</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="spouse_telephone" id="spouse_telephone" placeholder="Enter telephone number" value="<?php echo $row['spouse_telephone'] ?? '';?>"/>
                                            </div>
                                        </div>
                                        <!-- Children Information -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="children_name">Name of Children</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="children_name" id="children_name" placeholder="Enter full name of children" value="<?php  echo $row['children_name'] ?? '';?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="children_dob">Date of Birth</label>
                                            <div class="col-sm-5">
                                                <input type="date" class="form-control" name="children_dob" id="children_dob" value="<?php echo $row['children_dob'] ?? '';?>"/>
                                            </div>
                                        </div>
                                        <!-- Father's Information -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="father_surname">Father's Surname</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="father_surname" id="father_surname" placeholder="Enter father's surname" value="<?php echo $row['father_surname'] ?? '';?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="father_first_name">Father's First Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="father_first_name" id="father_first_name" placeholder="Enter father's first name" value="<?php echo $row['father_first_name'] ?? '';?>" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="father_middle_name">Father's Middle Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="father_middle_name" id="father_middle_name" placeholder="Enter father's middle name" value="<?php echo $row['father_middle_name'] ?? '';?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="father_name_extension">Father's Name Extension</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="father_name_extension" id="father_name_extension" placeholder="Enter father's name extension (Jr, Sr)" value="<?php echo $row['father_name_extension'] ?? '';?>"/>
                                            </div>
                                        </div>
                                        <!-- Mother's Information -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="mother_surname">Mother's Maiden Surname</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="mother_surname" id="mother_surname" placeholder="Enter mother's maiden surname" value="<?php echo $row['mother_maiden_name'] ?? '';?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="mother_first_name">Mother's First Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="mother_first_name" id="mother_first_name" placeholder="Enter mother's first name"value="<?php echo $row['mother_first_name'] ?? '';?>" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="mother_middle_name">Mother's Middle Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="mother_middle_name" id="mother_middle_name" placeholder="Enter mother's middle name" value="<?php echo $row['mother_middle_name'] ?? '';?>"/>
                                            </div>
                                        </div>

                                        <!-- Educational Background Section -->
                                        <h4>Educational Background</h4>

                                        <!-- Elementary School -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="elementary_school">Elementary School</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="elementary_school" id="elementary_school" placeholder="Enter elementary school name" value="<?php ?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="elementary_degree">Degree/Basic Education</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="elementary_degree" id="elementary_degree" placeholder="Enter degree or education received" value="<?php ?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="elementary_period_from">Period of Attendance (From)</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="elementary_period_from" id="elementary_period_from" placeholder="Enter start year" value="<?php ?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="elementary_period_to">Period of Attendance (To)</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="elementary_period_to" id="elementary_period_to" placeholder="Enter end year" value="<?php ?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="elementary_honors">Scholarships/Honors Received</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="elementary_honors" id="elementary_honors" placeholder="Enter honors or scholarships received" value="<?php ?>"/>
                                            </div>
                                        </div>

                                        <!-- Secondary School -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="secondary_school">Secondary School</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="secondary_school" id="secondary_school" placeholder="Enter secondary school name" value="<?php ?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="secondary_degree">Degree/Basic Education</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="secondary_degree" id="secondary_degree" placeholder="Enter degree or education received" value="<?php ?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="secondary_period_from">Period of Attendance (From)</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="secondary_period_from" id="secondary_period_from" placeholder="Enter start year" value="<?php ?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="secondary_period_to">Period of Attendance (To)</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="secondary_period_to" id="secondary_period_to" placeholder="Enter end year" value="<?php ?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="secondary_honors">Scholarships/Honors Received</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="secondary_honors" id="secondary_honors" placeholder="Enter honors or scholarships received" value="<?php ?>"/>
                                            </div>
                                        </div>

                                        <!-- Vocational/Trade -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="vocational_school">Vocational/Trade Course</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="vocational_school" id="vocational_school" placeholder="Enter vocational school name" value="<?php ?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="vocational_degree">Degree/Basic Education</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="vocational_degree" id="vocational_degree" placeholder="Enter degree or education received" value="<?php ?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="vocational_period_from">Period of Attendance (From)</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="vocational_period_from" id="vocational_period_from" placeholder="Enter start year" value="<?php ?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="vocational_period_to">Period of Attendance (To)</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="vocational_period_to" id="vocational_period_to" placeholder="Enter end year" value="<?php ?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="vocational_honors">Scholarships/Honors Received</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="vocational_honors" id="vocational_honors" placeholder="Enter honors or scholarships received" value="<?php ?>"/>
                                            </div>
                                        </div>

                                        <!-- College -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="college_school">College</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="college_school" id="college_school" placeholder="Enter college name" value="<?php ?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="college_degree">Degree/Course</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="college_degree" id="college_degree" placeholder="Enter degree or course received" value="<?php ?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="college_period_from">Period of Attendance (From)</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="college_period_from" id="college_period_from" placeholder="Enter start year" value="<?php ?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="college_period_to">Period of Attendance (To)</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="college_period_to" id="college_period_to" placeholder="Enter end year" value="<?php ?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="college_honors">Scholarships/Honors Received</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="college_honors" id="college_honors" placeholder="Enter honors or scholarships received" value="<?php ?>"/>
                                            </div>
                                        </div>

                                        <!-- Graduate Studies -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="graduate_school">Graduate Studies</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="graduate_school" id="graduate_school" placeholder="Enter graduate school name" value="<?php ?>"/>
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="graduate_degree">Degree/Course</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="graduate_degree" id="graduate_degree" placeholder="Enter degree or course received" value="<?php ?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="graduate_period_from">Period of Attendance (From)</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="graduate_period_from" id="graduate_period_from" placeholder="Enter start year" value="<?php ?>" />
                                            </div>

                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="graduate_period_to">Period of Attendance (To)</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="graduate_period_to" id="graduate_period_to" placeholder="Enter end year" value="<?php ?>"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="graduate_honors">Scholarships/Honors Received</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="graduate_honors" id="graduate_honors" placeholder="Enter honors or scholarships received" value="<?php ?>"/>
                                            </div>
                                        </div>





                                        <div class="row justify-content-end">
                                            <div class="col-sm-10">
                                                <button type="submit" name="<?php echo isset($_SESSION['personal_id']) ? "Update" : "Register"; ?>" class="btn btn-primary"><?php echo isset($_SESSION['personal_id']) ? "Update" : "Register"; ?> File</button>
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
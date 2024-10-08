<?php include("../model/conn.php"); ?>
<!DOCTYPE html>


<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Login as Administrator</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/img/logo.png" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
  <!-- Helpers -->
  <script src="../assets/vendor/js/helpers.js"></script>


  <script src="../assets/js/config.js"></script>
</head>

<body>
  <!-- Content -->

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="index.php" class="app-brand-link gap-2">
                <img src="../assets/img/logo.png" style="height: 100px;" alt="">
              </a>
            </div>
            <!-- /Logo -->
            <div class="text-center">
              <h4 class="mb-2">Welcome to Batangaas MIS</h4>
              <p class="mb-4">Please enter your credentials below</p>
            </div>
            <?php

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              $emailOrUsername = $_POST['email-username'];
              $password = $_POST['password'];

              // Check if user exists
              $stmt = $conn->prepare("SELECT user_id, username, email, password, role FROM users WHERE (username = ? OR email = ?) AND password = ? and a_status='Active'");
              $stmt->bind_param("sss", $emailOrUsername, $emailOrUsername, $password);
              $stmt->execute();
              $stmt->store_result();

              if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_id, $username, $email, $hashedPassword, $role);
                $stmt->fetch();

                if ($stmt->num_rows > 0) {
                  $_SESSION['admin_id'] = $user_id;
                  echo "<script>alert('Login successful'); window.location.href = 'index.php';</script>";
                } else {
                  echo "<script>alert('Invalid credentials');</script>";
                }
              } else {
                echo "<script>alert('Invalid credentials');</script>";
              }
              $stmt->close();
            }
            $conn->close();
            ?>

            <!-- Your HTML form goes here -->
            <form id="formAuthentication" class="mb-3"  method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">Email or Username</label>
                <input type="text" class="form-control" id="email" name="email-username" placeholder="Enter your email or username" autofocus />
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-4 text-center" style="font-size: 12px;" >
                <button type="button"  style="font-size: 12px;" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalScrollable">
                  View Terms and conditions
                </button>
                <br>
                <input type="checkbox" name="option" value="option1" required> Accept Terms and Conditions
              </div>
              <div class="mb-3">
                <button class="btn btn-success d-grid w-100" type="submit">SIGN IN</button>
              </div>
            </form>



          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>

  <!-- / Content -->
  <div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalScrollableTitle">Administrator Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    <strong>General Use</strong>
                </p>
                <p>
                    1. <strong>Account Responsibility</strong>: Administrators are responsible for maintaining the confidentiality of their account information and for all activities that occur under their account.
                </p>
                <p>
                    2. <strong>System Management</strong>: Administrators must manage system access, ensuring only authorized personnel have access to the system.
                </p>
                <p>
                    3. <strong>Data Integrity</strong>: Administrators are responsible for ensuring the integrity and security of the data within the system.
                </p>
                <p>
                    4. <strong>System Updates</strong>: Administrators must ensure that the system is regularly updated and maintained to prevent any security breaches.
                </p>
                <p>
                    5. <strong>Compliance</strong>: Administrators must ensure that the system complies with all applicable laws, regulations, and company policies.
                </p>
                <p>
                    <strong>Prohibited Activities</strong>
                </p>
                <p>
                    1. <strong>Unauthorized Access</strong>: Administrators must not grant access to unauthorized personnel or access restricted areas without proper authorization.
                </p>
                <p>
                    2. <strong>Data Misuse</strong>: Administrators must not misuse or mishandle employee data stored within the system.
                </p>
                <p>
                    3. <strong>Negligence</strong>: Administrators must not neglect their responsibilities in managing the system, including regular updates, backups, and security checks.
                </p>
                <p>
                    By using the Management Information System with Attendance Monitoring, administrators agree to adhere to the above terms and conditions. Violation of these terms may result in disciplinary action, up to and including termination of employment.
                </p>
                <p>
                    <strong>Acknowledgment</strong>
                </p>
                <p>
                    I have read and understood the terms and conditions outlined above and agree to abide by them.
                </p>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
             
            </div>
        </div>
    </div>
</div>



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
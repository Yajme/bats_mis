<?php include("../model/conn.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAILY TIME RECORD</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../assets/img/logo.png" />
    <script type="text/javascript">
        function autoPrint() {
            window.print();
        }

        window.onload = autoPrint; // Trigger print when the page loads
    </script>
    <style>
        table {
            font-size: 22px;
            width: 100%;
            border-collapse: collapse;

        }

        th,
        td {
            border: 1px solid black;
            padding: 7px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
        }

        .signature {
            text-align: left;
        }

        .row-content {

            padding: 10px;

            margin-left: -200px;

        }

        .container {
            width: 1000px;
            margin-right: 200px;
        }

        @media print {

            .row {
                display: flex;


            }

            .col-md-6 {
                width: 50%;
                float: left;
                box-sizing: border-box;
            }

            table {
                margin-left: 10px;

            }



        }
    </style>
</head>
<?php

// Initialize an array to hold attendance data for each month
$monthlyAttendanceData = [];

// Loop through each month from 1 to 12
for ($month = 1; $month <= 12; $month++) {
    // Query to fetch attendance data for the current month
    $sql = "SELECT * FROM attendance WHERE MONTH(date) = $month and user_id= {$_GET['e_id']} ORDER BY date";
    $result = $conn->query($sql);

    // Initialize an array to group attendance records by date for the current month
    $attendanceData = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $date = $row["date"];
            $timeIn = $row["time_in"];
            $timeOut = $row["time_out"];
            $status = $row["status"];

            // Group by date
            if (!isset($attendanceData[$date])) {
                $attendanceData[$date] = [
                    'morningIn' => '',
                    'morningOut' => '',
                    'afternoonIn' => '',
                    'afternoonOut' => '',
                    'overtimeIn' => '',
                    'overtimeOut' => ''
                ];
            }

            if ($status === 'present') {
                if ($timeIn <= '12:00:00') {
                    $attendanceData[$date]['morningIn'] = $timeIn;
                } else {
                    $attendanceData[$date]['afternoonIn'] = $timeIn;
                }

                if ($timeOut <= '12:00:00') {
                    $attendanceData[$date]['morningOut'] = $timeOut;
                } else {
                    $attendanceData[$date]['afternoonOut'] = $timeOut;
                }
            }
        }
    }

    // Store the attendance data for the current month in the array
    $monthlyAttendanceData[$month] = $attendanceData;
    
}




?>

<body>
    <?php

    function displayAttendance()
    {
        global $monthlyAttendanceData;
        $months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ];
        $rowStartTag = '<div class="row">';
        $rowContentTag = '<div class="col-12 row-content">';
        $divCloseTag = '</div>';
        $table = '<table>';
        $tableClose = '</table>';
        $tr = '<tr>';
        $trClose = '</tr>';
        for ($month = 1; $month <= 12; $month++) {
            $data = [];
            $attendance = '';
            $currentYear = date('Y'); // Get the current year

            // Retrieve attendance data for the specified month
            $attendanceData = isset($monthlyAttendanceData[$month]) ? $monthlyAttendanceData[$month] : [];

            // Get the number of days in the specified month
            $daysInMonth = date('t', mktime(0, 0, 0, $month, 1, $currentYear));

            for ($day = 1; $day <= $daysInMonth; $day++) {
                // Format the date to match the format in $attendanceData
                $date = $currentYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);

                // Check if data for the date exists
                if (isset($attendanceData[$date])) {
                    $data = $attendanceData[$date];
                } else {
                    $data = [
                        'morningIn' => '',
                        'morningOut' => '',
                        'afternoonIn' => '',
                        'afternoonOut' => '',
                        'overtimeIn' => '',
                        'overtimeOut' => ''
                    ];
                }

                // Output table row
                $attendance = $attendance .
                    "<tr>" .
                        "<td>{$day}</td>" . 
                        "<td>" . htmlspecialchars($data['morningIn']) . "</td>" .
                        "<td>" . htmlspecialchars($data['morningOut']) . "</td>" .
                        "<td>" . htmlspecialchars($data['afternoonIn']) . "</td>" .
                        "<td>" . htmlspecialchars($data['afternoonOut']) . "</td>" .
                        "<td>" . htmlspecialchars($data['overtimeIn']) . "</td>" .
                        "<td>" . htmlspecialchars($data['overtimeOut']) . "</td>" .
                    "</tr>";
                    //echo $attendance;
            }



            echo
            $rowStartTag .
                $rowContentTag .

                $table .
                $tr .
                '<th colspan="7" class="header">
                Civil Service Form No. 48<br>
                DAILY TIME RECORD<br>
                 <hr>
                Provincial Form No. ___<br>
                For the month of: ' . $months[$month - 1] . '<br>
                Official hours for arrival (Regular days): __________<br>
                and departure (Saturdays): ___________
             </th>' .
                $trClose .
                $tr .
                '<th>Day</th>
                                <th colspan="2">Morning</th>
                                <th colspan="2">Afternoon</th>
                                <th colspan="2">Overtime</th>' .
                $trClose .
                $tr .
                '<th></th>
                                <th>In</th>
                                <th>Out</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>In</th>
                                <th>Out</th>' .
                $trClose .
                $attendance .
                $tr .
                '<td colspan="7" class="signature">
                                    I certify on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival and departure from office.
                                </td>' .
                $trClose .
                $tr .
                '<td colspan="7" class="signature">
                                    _______________________<br>
                                    In Charge
                                </td>' .
                $trClose .
                $tableClose .

                $divCloseTag . //RowContent
                $divCloseTag // Row 
            ;
           // $attendance = '';
        }
    }

    function displayBasedOnMonth($month){

        global $monthlyAttendanceData;
        $months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ];
        $rowStartTag = '<div class="row">';
        $rowContentTag = '<div class="col-12 row-content">';
        $divCloseTag = '</div>';
        $table = '<table>';
        $tableClose = '</table>';
        $tr = '<tr>';
        $trClose = '</tr>';
        $data = [];
            $attendance = '';
            $currentYear = date('Y'); // Get the current year

            // Retrieve attendance data for the specified month
            $attendanceData = isset($monthlyAttendanceData[$month]) ? $monthlyAttendanceData[$month] : [];

            // Get the number of days in the specified month
            $daysInMonth = date('t', mktime(0, 0, 0, $month, 1, $currentYear));

            for ($day = 1; $day <= $daysInMonth; $day++) {
                // Format the date to match the format in $attendanceData
                $date = $currentYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);

                // Check if data for the date exists
                if (isset($attendanceData[$date])) {
                    $data = $attendanceData[$date];
                } else {
                    $data = [
                        'morningIn' => '',
                        'morningOut' => '',
                        'afternoonIn' => '',
                        'afternoonOut' => '',
                        'overtimeIn' => '',
                        'overtimeOut' => ''
                    ];
                }

                // Output table row
                $attendance = $attendance .
                    "<tr>" .
                        "<td>{$day}</td>" . 
                        "<td>" . htmlspecialchars($data['morningIn']) . "</td>" .
                        "<td>" . htmlspecialchars($data['morningOut']) . "</td>" .
                        "<td>" . htmlspecialchars($data['afternoonIn']) . "</td>" .
                        "<td>" . htmlspecialchars($data['afternoonOut']) . "</td>" .
                        "<td>" . htmlspecialchars($data['overtimeIn']) . "</td>" .
                        "<td>" . htmlspecialchars($data['overtimeOut']) . "</td>" .
                    "</tr>";
                    //echo $attendance;
            }



            echo
            $rowStartTag .
                $rowContentTag .

                $table .
                $tr .
                '<th colspan="7" class="header">
                Civil Service Form No. 48<br>
                DAILY TIME RECORD<br>
                 <hr>
                Provincial Form No. ___<br>
                For the month of: ' . $months[$month - 1] . '<br>
                Official hours for arrival (Regular days): __________<br>
                and departure (Saturdays): ___________
             </th>' .
                $trClose .
                $tr .
                '<th>Day</th>
                                <th colspan="2">Morning</th>
                                <th colspan="2">Afternoon</th>
                                <th colspan="2">Overtime</th>' .
                $trClose .
                $tr .
                '<th></th>
                                <th>In</th>
                                <th>Out</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>In</th>
                                <th>Out</th>' .
                $trClose .
                $attendance .
                $tr .
                '<td colspan="7" class="signature">
                                    I certify on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival and departure from office.
                                </td>' .
                $trClose .
                $tr .
                '<td colspan="7" class="signature">
                                    _______________________<br>
                                    In Charge
                                </td>' .
                $trClose .
                $tableClose .

                $divCloseTag . //RowContent
                $divCloseTag // Row 
            ;

    }
    ?>
    <div class="container">
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-6">
                <?php 
                $month = $_GET['month'];
                if($month == 'All'){
                    displayAttendance(); 
                }else if($month > 0 && $month < 13){
                    displayBasedOnMonth($month);
                }else{
                    echo $month . 'invalid parameter';
                }
                
                ?>
                <!--TODO: Display per month -->
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>


<?php





?>
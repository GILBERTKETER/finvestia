<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require('./db_conn.php');
$type = 'finVestAdminLoggedInAccept';
if (!isset($_SESSION['LOGGED_IN_EMAIL']) || $_SESSION['LOGGED_IN_ACCTYPE'] != $type) {
    header("Location:./login.php");
    exit();
}
$email = $_SESSION['LOGGED_IN_EMAIL'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/site.webmanifest">
    <link rel="stylesheet" href="./Clientstyle.css">
    <link rel="stylesheet" href="./admin.css">
    <title>finvestia.co.ke</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">


    <style>
        label {
            color: var(--dark);
        }

        /* ========================== */
    </style>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2736930210041886" crossorigin="anonymous"></script>


</head>

<body>
    <?php
    $total_user_counts = 0;
    $allUsers = "SELECT COUNT(*) AS USERCOUNTS FROM profitedge_users";
    $users_stmt = $mysqli->prepare($allUsers);
    $users_stmt->execute();
    $user_result = $users_stmt->get_result();
    $rowUsers = $user_result->fetch_assoc();
    $total_user_counts = intval($rowUsers['USERCOUNTS']) - 1;


    ?>
    <?php
    $total_Withdrawals = 0;
    //withdrawals query
    $withdrawals_Query = "SELECT SUM(Amount) AS WITHDRAWALS FROM withdrawals";
    $withdraw_stmt = $mysqli->prepare($withdrawals_Query);
    // $withdraw_stmt->bind_param('s', $email);
    $withdraw_stmt->execute();
    $withdraw_results = $withdraw_stmt->get_result();
    if ($withdraw_results->num_rows > 0) {
        $rowWithdrawals = $withdraw_results->fetch_assoc();
        $total_Withdrawals = intval($rowWithdrawals['WITHDRAWALS']);
    } else {
        $total_Withdrawals = 0;
    }
    // ===========withdrawals done
    $total_Investments = 0;
    $total_ProfitsInvested = 0;
    $invetsmentsDone = "SELECT SUM(Amount) AS INVESTMENTS FROM investments ";
    $investment_stmt = $mysqli->prepare($invetsmentsDone);
    // $investment_stmt->bind_param('s', $email);
    $investment_stmt->execute();
    $investmentResults = $investment_stmt->get_result();
    if ($investmentResults->num_rows > 0) {
        $rowInvestmentsDone = $investmentResults->fetch_assoc();
        $total_Investments = intval($rowInvestmentsDone['INVESTMENTS']);
    } else {
        $total_Investments = 0;
        $total_ProfitsInvested = 0;
    }

    ?>
    <?php
    $admin = 'ADMIN';
    // $refferesNumber = "SELECT COUNT(Email_Address) AS REFFERAL_COUNTS FROM profitedge_users WHERE Refferer != '$admin'";
    $refferesNumber = "SELECT COUNT(*) AS REFFERAL_COUNTS FROM profitedge_users AS refferer JOIN profitedge_users AS reffered_users ON refferer.User_Name = reffered_users.Refferer JOIN investments ON reffered_users.User_Name = investments.User_Name WHERE refferer.User_Name != '$admin'";
    $refferalsCount_stmt = $mysqli->prepare($refferesNumber);
    $refferalsCount_stmt->execute();
    $refferal_count_results = $refferalsCount_stmt->get_result();
    $rowRefferalCount = $refferal_count_results->fetch_assoc();
    $Total_refferal_Earnings = intval($rowRefferalCount['REFFERAL_COUNTS']) * 50;



    ?>

    <?php
    // PROCESSING INVESTMENTS
    $status22 = 'processing';
    $investments_approved12 = "SELECT SUM(Amount) AS PROCESSINGINVESTMENTS FROM investments WHERE Status = ?";
    $stmt_investments12 = $mysqli->prepare($investments_approved12);
    $stmt_investments12->bind_param('s', $status22);
    $stmt_investments12->execute();
    $resulting_investments12 = $stmt_investments12->get_result()->fetch_assoc();
    $Approved_investments12 = intval($resulting_investments12['PROCESSINGINVESTMENTS']);

    $queryAccountBalance = "SELECT SUM(Balance_Available) AS MYACCOUNTBALANCE FROM balance_account_users_profitedge";
    $queryBalance_stmt = $mysqli->prepare($queryAccountBalance);
    $queryBalance_stmt->execute();
    $resultQueryBalance = $queryBalance_stmt->get_result();
    $Admin_Account = $resultQueryBalance->fetch_assoc();
    $Total_Account_Balance_For_Admin = floatval($Admin_Account['MYACCOUNTBALANCE'] - $Total_refferal_Earnings + $Approved_investments12); //add the investments in processing

    ?>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <!-- <i class='bx bx-code-alt'></i> -->
            <img src="./images/logo.png" alt="">
            <div class="logo-name"><span>fin</span>Vestia </div>
        </a>
        <ul class="side-menu">
            <li class="active"><a href="#"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
            <li><a href="#"><i class='bx bx-wallet-alt'></i>Account</a></li>
            <li><a href="#"><i class='bx bx-group'></i>Users</a></li>
            <!-- <li><a href="#"><i class='bx bx-group'></i>Set Notifications</a></li> -->
            <li><a href="#"><i class='bx bx-package'></i>Analytics</a></li>
            <li><a href="#"><i class='bx bx-cog'></i>Settings</a></li>
            <li><a href="#"><i class='bx bx-paper-plane'></i>Suspend A User</a></li>
            <li><a href="#"><i class='bx bx-dollar'></i>Transact a User</a></li>
            <li><a href="#"><i class='bx bx-credit-card'></i>Transactors</a></li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="./logout.php" class="logout">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search..." hidden>
                    <button class="search-btn" type="submit" hidden>
                        <!-- <i class='bx bx-search' hidden></i> -->
                    </button>
                </div>
            </form>
            <input type="checkbox" id="theme-toggle" hidden>
            <label for="theme-toggle" class="theme-toggle"></label>
            <a href="#" class="notif" id="bell">
                <i class='bx bx-bell'></i>
                <span class="count" id="notificationCount"></span>

                <div class="notifsNow">

                </div>
            </a>
            <a href="#" class="profile">
                <i class='bx bx-user' id="userTab"></i>
                <div class="userdetails">
                    <div class="contains">
                        <h1><?php echo $_SESSION['LOGGED_IN_USERNAME']; ?></h1>
                    </div>
                </div>
            </a>
        </nav>


        <!-- End of Navbar -->

        <main style="height: fit-content;">

            <div class="header">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Analytics
                            </a></li>
                        /
                        <li><a href="#" class="active">Shop</a></li>
                    </ul>
                </div>
                <a href="mailto:finvestiateam@gmail.com" class="report">
                    <i class='bx bx-envelope'></i>
                    <span>Send a Message</span>
                </a>
            </div>

            <!-- Insights -->
            <ul class="insights">
                <li>
                    <i class='bx bxs-user-account'></i>
                    <span class="info">
                        <h3>
                            <?php echo "Ksh. " . $total_Investments; ?>
                        </h3>
                        <p>Total Investments</p>
                    </span>
                </li>
                <li><i class='bx bx-dollar-circle'></i>
                    <span class="info">
                        <h3>
                            <?php echo $total_user_counts; ?>
                        </h3>
                        <p>Total Users</p>
                    </span>
                </li>
                <li><i class='bx bx-transfer'></i>
                    <span class="info">
                        <h3>
                            <?php echo "Ksh. " . $total_Withdrawals; ?>
                        </h3>
                        <p>Total Withdrawals</p>
                    </span>
                </li>
                <li><i class='bx bx-credit-card'></i>
                    <span class="info">
                        <h3>
                            <?php echo 'Ksh. ' . $Total_refferal_Earnings; ?>
                        </h3>
                        <p>Refferal Earnings</p>
                    </span>
                </li>
            </ul>
            <!-- End of Insights -->

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Recent Users</h3>

                    </div>
                    <?php

                    $recordsPerPage = 5;
                    $acctype = 'finVestAdminLoggedInAccept';

                    // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                    // Calculate the offset for pagination
                    $offset = ($current_page - 1) * $recordsPerPage;

                    $invests1 = "SELECT * FROM profitedge_users WHERE Joiner_Account_Type <> ? ORDER BY Joining_Day DESC LIMIT ? OFFSET ?";
                    $stmt8 = $mysqli->prepare($invests1);
                    $stmt8->bind_param('sii', $acctype, $recordsPerPage, $offset);
                    $stmt8->execute();
                    $resultingDetails2 = $stmt8->get_result();


                    // Get the total number of records for pagination
                    $countInvests = "SELECT COUNT(*) as total FROM profitedge_users";
                    $stmtCount = $mysqli->prepare($countInvests);
                    // $stmtCount->bind_param('s', $email);
                    $stmtCount->execute();
                    $resultCount = $stmtCount->get_result();
                    $row = $resultCount->fetch_assoc();
                    $totalRecords = $row['total'];

                    // Calculate the total number of pages
                    $totalPages = ceil($totalRecords / $recordsPerPage);

                    // Output the pagination links
                    // for ($i = 1; $i <= $totalPages; $i++) {
                    //     echo '<a href="#" onclick="handlePaginationClick(' . $i . ')">' . $i . '</a>';
                    // }

                    ?>
                    <!-- <div class="tableContainer"> -->
                    <table>
                        <thead>

                            <tr>
                                <th>Email Address</th>

                                <th>UserName</th>
                                <th>Phone No</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody id="paginationContent">
                            <?php

                            $recordsPerPage = 5;

                            // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                            $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                            // Calculate the offset for pagination
                            $offset = ($current_page - 1) * $recordsPerPage;
                            $invests1 = "SELECT * FROM profitedge_users WHERE Joiner_Account_Type <> ? ORDER BY Joining_Day DESC LIMIT ? OFFSET ?";
                            $stmt8 = $mysqli->prepare($invests1);
                            $stmt8->bind_param('sii', $acctype,  $recordsPerPage, $offset);
                            $stmt8->execute();
                            $resultingDetails2 = $stmt8->get_result();

                            if ($resultingDetails2->num_rows > 0) {
                                while ($rowDetails = $resultingDetails2->fetch_assoc()) {
                                    // Generate the table rows here
                                    echo '<tr>';
                                    echo '<td>' . $rowDetails['Email_Address'] . '</td>';
                                    echo '<td>' . $rowDetails['User_Name'] . '</td>';
                                    echo '<td>' . $rowDetails['Phone_No'] . '</td>';
                                    echo '<td>' . $rowDetails['Joining_Day'] . '</td>';



                                    echo '</tr>';
                                }
                            } else {
                                // If there are no records, display a single row with "No records"
                                echo '<tr><td colspan="5">No records</td></tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                    <?php
                    if ($totalPages > 0) {
                        // Add navigation arrows
                        $prevPage = $current_page - 1;
                        $nextPage = $current_page + 1;
                        if ($prevPage >= 1) {
                    ?>
                            <a href="?page=<?php echo $prevPage; ?>">
                                << <!-- Previous page arrow -->
                            </a>
                        <?php
                        }
                        if ($nextPage <= $totalPages) {
                        ?>
                            <a href="?page=<?php echo $nextPage; ?>">
                                >> <!-- Next page arrow -->
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>
                <!-- ======================================== -->
                <div class="bottom-data">
                    <div class="orders">
                        <div class="header">
                            <i class='bx bx-receipt'></i>
                            <h3>Investments Requesting Approvals</h3>
                            <?php
                            $current_date_str = date("Y-m-d H:i:s");

                            $countApprovals = "SELECT COUNT(*) AS APPROVALSCOUNT FROM investments WHERE End_Date<=?";
                            $countApprovals_stmt = $mysqli->prepare($countApprovals);
                            $countApprovals_stmt->bind_param('s', $current_date_str);
                            $countApprovals_stmt->execute();
                            $resultApproval = $countApprovals_stmt->get_result()->fetch_assoc();
                            $approvalCounts = $resultApproval['APPROVALSCOUNT'];

                            echo $approvalCounts;

                            ?>
                            <form method="post" id="approve">
                                <button type="submit" class="suspendbtn" name="approveallbtn">Approve All</button>
                            </form>
                            <?php
                            if (isset($_POST['approveallbtn'])) {

                                $current_date_str = date("Y-m-d H:i:s");

                                // Update the status to "approved" for records where the end date has passed or is zero days remaining
                                $queryApprove = "UPDATE investments SET Status = 'Approved' WHERE End_Date <= ?";

                                // Prepare the query
                                $stmt_approve = $mysqli->prepare($queryApprove);

                                // Bind the parameter for the current date
                                $stmt_approve->bind_param('s', $current_date_str);

                                // Execute the query
                                $stmt_approve->execute();

                                // Check if the query was successful
                                if ($stmt_approve->affected_rows > 0) {
                                    echo "Approval successful for records with end date passed or zero days remaining.";
                                } else {
                                    echo "No records found or already approved.";
                                }

                                // Close the statement
                                $stmt_approve->close();
                            }
                            ?>

                        </div>
                        <?php
                        $recordsPerPage = 5;

                        // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                        // Calculate the offset for pagination
                        $offset = ($current_page - 1) * $recordsPerPage;

                        $invests11 = "SELECT * FROM investments ORDER BY Amount DESC LIMIT ? OFFSET ?";
                        $stmt81 = $mysqli->prepare($invests11);
                        $stmt81->bind_param('ii', $recordsPerPage, $offset);
                        $stmt81->execute();
                        $resultingDetails21 = $stmt81->get_result();

                        if ($resultingDetails21->num_rows > 0) {
                            echo '<table>';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Email Address</th>';
                            echo '<th>UserName</th>';
                            echo '<th>Phone No</th>';
                            echo '<th>To Approve</th>';
                            echo '<th>End Date</th>';
                            echo '<th>Days Remaining</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            while ($rowDetails1 = $resultingDetails21->fetch_assoc()) {
                                // Get the end date as a DateTime object
                                $end_date1 = new DateTime($rowDetails1['End_Date']);
                                $invest_status = $rowDetails1['Status'];
                                // Get the current date as a DateTime object
                                $current_date1 = new DateTime();

                                // Check if the end date has passed
                                if ($current_date1 > $end_date1  && $invest_status == 'processing') {
                                    // Calculate the interval between the current date and the end date

                                    $interval1 = $current_date1->diff($end_date1);
                                    $time_remaining_str1 = $interval1->format('%r%a days, %H hours, %I minutes, %S seconds');

                                    // Output the table rows for records where the time is up
                                    echo '<tr>';
                                    echo '<td>' . $rowDetails1['Email_Address'] . '</td>';
                                    echo '<td>' . $rowDetails1['User_Name'] . '</td>';
                                    echo '<td>' . $rowDetails1['Phone_No'] . '</td>';
                                    echo '<td>' . $rowDetails1['Total_Amount_To_Earn'] . '</td>';
                                    echo '<td>' . $rowDetails1['End_Date'] . '</td>';
                                    echo '<td>' . $time_remaining_str1 . '</td>';
                                    echo '</tr>';
                                }
                            }

                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            // If there are no records, display a message
                            echo '<p>No records</p>';
                        }
                        ?>
                    </div>
                    <?php
                    if ($totalPages > 0) {
                        // Add navigation arrows
                        $prevPage = $current_page - 1;
                        $nextPage = $current_page + 1;
                        if ($prevPage >= 1) {
                    ?>
                            <a href="?page=<?php echo $prevPage; ?>">
                                << <!-- Previous page arrow -->
                            </a>
                        <?php
                        }
                        if ($nextPage <= $totalPages) {
                        ?>
                            <a href="?page=<?php echo $nextPage; ?>">
                                >> <!-- Next page arrow -->
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>



                <!-- ======================================== -->
                <!-- Reminders -->
                <div class="reminders">
                    <div class="header">
                        <i class='bx bx-note'></i>
                        <h3>Performance</h3>
                        <!-- <i class='bx bx-filter'></i>
                        <i class='bx bx-plus'></i> -->
                    </div>
                    <?php
                    // Count for Gold Package
                    $TotalGoldCounts = 0;
                    $packageTest_Gold = 'Gold Package';
                    $countPackagesGold = "SELECT COUNT(Package) AS GOLDCOUNTS FROM investments WHERE Package = ?";
                    $countPackage_stmtGold = $mysqli->prepare($countPackagesGold);
                    $countPackage_stmtGold->bind_param('s', $packageTest_Gold);
                    $countPackage_stmtGold->execute();
                    $resulting_countGold_package = $countPackage_stmtGold->get_result();
                    if ($resulting_countGold_package->num_rows > 0) {
                        $rowPackage_count = $resulting_countGold_package->fetch_assoc();
                        $TotalGoldCounts = intval($rowPackage_count['GOLDCOUNTS']);
                    }

                    // Count for Silver Package
                    $TotalSilverCounts = 0;
                    $packageTest_Silver = 'Silver Package';
                    $countPackagesSilver = "SELECT COUNT(Package) AS SILVERCOUNTS FROM investments WHERE Package = ?";
                    $countPackage_stmtSilver = $mysqli->prepare($countPackagesSilver);
                    $countPackage_stmtSilver->bind_param('s', $packageTest_Silver);
                    $countPackage_stmtSilver->execute();
                    $resulting_countSilver_package = $countPackage_stmtSilver->get_result();
                    if ($resulting_countSilver_package->num_rows > 0) {
                        $rowPackage_count = $resulting_countSilver_package->fetch_assoc();
                        $TotalSilverCounts = intval($rowPackage_count['SILVERCOUNTS']);
                    }

                    // Count for Bronze Package
                    $TotalBronzeCounts = 0;
                    $packageTest_Bronze = 'Bronze Package';
                    $countPackagesBronze = "SELECT COUNT(Package) AS BRONZECOUNTS FROM investments WHERE Package = ?";
                    $countPackage_stmtBronze = $mysqli->prepare($countPackagesBronze);
                    $countPackage_stmtBronze->bind_param('s', $packageTest_Bronze);
                    $countPackage_stmtBronze->execute();
                    $resulting_countBronze_package = $countPackage_stmtBronze->get_result();
                    if ($resulting_countBronze_package->num_rows > 0) {
                        $rowPackage_count = $resulting_countBronze_package->fetch_assoc();
                        $TotalBronzeCounts = intval($rowPackage_count['BRONZECOUNTS']);
                    }

                    // Calculate the total number of investments
                    $totalInvestments = $TotalGoldCounts + $TotalSilverCounts + $TotalBronzeCounts;

                    // Calculate the percentages (check if $totalInvestments is not zero)
                    if ($totalInvestments > 0) {
                        $goldPercentage = ($TotalGoldCounts / $totalInvestments) * 100;
                        $silverPercentage = ($TotalSilverCounts / $totalInvestments) * 100;
                        $bronzePercentage = ($TotalBronzeCounts / $totalInvestments) * 100;
                    } else {
                        // Set percentages to zero or handle the situation as needed
                        $goldPercentage = 0;
                        $silverPercentage = 0;
                        $bronzePercentage = 0;
                    }
                    ?>

                    <!-- Add additional HTML for progress bars -->
                    <ul class="task-list">
                        <p>Gold </p>
                        <li class="completed">
                            <div class="task-title">
                                <!-- <i class='bx bx-check-circle'></i> -->
                            </div>
                            <div class="progress-bar">
                                <div class="progress" style="width: <?php echo $goldPercentage; ?>%;"></div>
                            </div>
                            <i class='bx bx-dots-vertical-rounded' onclick="toggleGraph('gold', <?php echo $TotalGoldCounts; ?>, <?php echo $goldPercentage; ?>)"></i>
                        </li>
                        <p>Silver</p>
                        <li class="completed">
                            <div class="task-title">
                                <!-- <i class='bx bx-check-circle'></i> -->
                            </div>
                            <div class="progress-bar">
                                <div class="progress" style="width: <?php echo $silverPercentage; ?>%;"></div>
                            </div>
                            <i class='bx bx-dots-vertical-rounded' onclick="toggleGraph('silver', <?php echo $TotalSilverCounts; ?>, <?php echo $silverPercentage; ?>)"></i>
                        </li>
                        <p>Bronze</p>
                        <li class="not-completed">
                            <div class="task-title">
                                <!-- <i class='bx bx-x-circle'></i> -->
                            </div>
                            <div class="progress-bar">
                                <div class="progress" style="width: <?php echo $bronzePercentage; ?>%;"></div>
                            </div>
                            <i class='bx bx-dots-vertical-rounded' onclick="toggleGraph('bronze', <?php echo $TotalBronzeCounts; ?>, <?php echo $bronzePercentage; ?>)"></i>
                        </li>
                    </ul>
                </div>

                <!-- End of Reminders-->

            </div>
            <!-- Add a container for displaying the graph -->
            <div id="graphContainer" class="hidden">
                <canvas id="packageGraph"></canvas>
            </div>



        </main>

    </div>
    <script>
        let packageGraphChart;

        function toggleGraph(packageType, totalCount, percentage) {

            const graphContainer = document.getElementById('graphContainer');

            // If the graph container is currently hidden, show it
            if (graphContainer.classList.contains('hidden')) {
                graphContainer.classList.remove('hidden');

                // Destroy the existing chart if it exists
                if (packageGraphChart) {
                    packageGraphChart.destroy();
                }

                const ctx = document.getElementById('packageGraph').getContext('2d');

                const data = {
                    labels: [packageType, 'Percentage'],
                    datasets: [{
                            label: 'Total Count',
                            data: [totalCount, 0],
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                        },
                        {
                            label: 'Percentage',
                            data: [0, percentage],
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                        },
                    ],
                };

                const options = {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                    },
                };

                // Create a new chart instance and store it in the packageGraphChart variable
                packageGraphChart = new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: options,
                });
            } else {
                // If the graph container is currently shown, hide it
                graphContainer.classList.add('hidden');
            }
        }
    </script>
    <script>
        // Function to update the table content based on the requested page number
        function updateTable(page) {
            // Create a new XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Set up the AJAX request
            xhr.open('GET', 'index?page=' + page, true);

            // Set up the callback function to handle the server response
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Update the table container with the new table content
                    document.getElementById('tableContainer').innerHTML = xhr.responseText;
                } else if (xhr.status !== 200) {
                    // Handle errors if any
                    alert('An error occurred while fetching the data.');
                }
            };

            // Send the AJAX request
            xhr.send();
        }

        // Function to handle pagination link clicks
        function handlePaginationClick(page) {
            // Update the table with the data for the clicked page
            updateTable(page);
        }
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2736930210041886" crossorigin="anonymous"></script>

    <script>
        // Get the "Change plan" list item
        const dashboardItem = document.querySelector('.side-menu li:nth-child(1)');

        // Add a click event listener to the "Change plan" list item
        dashboardItem.addEventListener('click', function(event) {
            // Prevent the default link behavior
            event.preventDefault();

            // Replace the main content with the new code
            const Dashboard = `
           

    <div class="header">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Analytics
                            </a></li>
                        /
                        <li><a href="#" class="active">Shop</a></li>
                    </ul>
                </div>
                <a href="mailto:finvestiateam@gmail.com" class="report">
                    <i class='bx bx-envelope'></i>
                    <span>Send a Message</span>
                </a>
            </div>

            <!-- Insights -->
            <ul class="insights">
                <li>
                <i class='bx bxs-user-account'></i>
                    <span class="info">
                        <h3>
                            <?php echo "Ksh. " . $total_Investments; ?>
                        </h3>
                        <p>Total Investments</p>
                    </span>
                </li>
                <li><i class='bx bx-dollar-circle'></i>
                    <span class="info">
                        <h3>
                           <?php echo $total_user_counts; ?>
                        </h3>
                        <p>Total Users</p>
                    </span>
                </li>
                <li><i class='bx bx-transfer'></i>
                    <span class="info">
                        <h3>
                        <?php echo "Ksh. " . $total_Withdrawals; ?>
                        </h3>
                        <p>Total Withdrawals</p>
                    </span>
                </li>
                <li><i class='bx bx-credit-card'></i>
                    <span class="info">
                        <h3>
                        <?php echo 'Ksh. ' . $Total_refferal_Earnings; ?>
                        </h3>
                        <p>Refferal Earnings</p>
                    </span>
                </li>
            </ul>
            <!-- End of Insights -->

           
            <div class="bottom-data">
            <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Recent Users</h3>
                        
                    </div>
                    
                    <!-- <div class="tableContainer"> -->
                    <table>
                        <thead>

                            <tr>
                                <th>Email Address</th>

                                <th>UserName</th>
                                <th>Phone No</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody id="paginationContent">
                            <?php

                            $recordsPerPage = 5;

                            // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                            $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                            // Calculate the offset for pagination
                            $offset = ($current_page - 1) * $recordsPerPage;

                            $invests1 = "SELECT * FROM profitedge_users WHERE Joiner_Account_Type <> ?  ORDER BY Joining_Day DESC LIMIT ? OFFSET ?";
                            $stmt8 = $mysqli->prepare($invests1);
                            $stmt8->bind_param('sii', $acctype, $recordsPerPage, $offset);
                            $stmt8->execute();
                            $resultingDetails2 = $stmt8->get_result();

                            if ($resultingDetails2->num_rows > 0) {
                                while ($rowDetails = $resultingDetails2->fetch_assoc()) {
                                    // Generate the table rows here
                                    echo '<tr>';
                                    echo '<td>' . $rowDetails['Email_Address'] . '</td>';
                                    echo '<td>' . $rowDetails['User_Name'] . '</td>';
                                    echo '<td>' . $rowDetails['Phone_No'] . '</td>';
                                    echo '<td>' . $rowDetails['Joining_Day'] . '</td>';



                                    echo '</tr>';
                                }
                            } else {
                                // If there are no records, display a single row with "No records"
                                echo '<tr><td colspan="5">No records</td></tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                    <?php
                    if ($totalPages > 0) {
                        // Add navigation arrows
                        $prevPage = $current_page - 1;
                        $nextPage = $current_page + 1;
                        if ($prevPage >= 1) {
                    ?>
                            <a href="?page=<?php echo $prevPage; ?>">
                                << <!-- Previous page arrow -->
                            </a>
                        <?php
                        }
                        if ($nextPage <= $totalPages) {
                        ?>
                            <a href="?page=<?php echo $nextPage; ?>">
                                >> <!-- Next page arrow -->
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>
                <!-- ======================================== -->
                <div class="bottom-data">
                    <div class="orders">
                        <div class="header">
                            <i class='bx bx-receipt'></i>
                            <h3>Investments Requesting Approvals</h3>
                            <?php echo $approvalCounts; ?>
                            <form method="post" id="approve">
                                <button type="submit" class="suspendbtn" name="approveallbtn">Approve All</button>
                            </form>
                            <?php
                            if (isset($_POST['approveallbtn'])) {
                                // Assuming you have established the database connection and created the $mysqli variable

                                // Get the current date as a string in MySQL date format
                                $current_date_str = date("Y-m-d H:i:s");

                                // Update the status to "approved" for records where the end date has passed or is zero days remaining
                                $queryApprove = "UPDATE investments SET Status = 'Approved' WHERE End_Date <= ?";

                                // Prepare the query
                                $stmt_approve = $mysqli->prepare($queryApprove);

                                // Bind the parameter for the current date
                                $stmt_approve->bind_param('s', $current_date_str);

                                // Execute the query
                                $stmt_approve->execute();

                                // Check if the query was successful
                                if ($stmt_approve->affected_rows > 0) {
                                    echo "Approval successful for records with end date passed or zero days remaining.";
                                } else {
                                    echo "No records found or already approved.";
                                }

                                // Close the statement
                                $stmt_approve->close();
                            }
                            ?>

                        </div>
                        <?php
                        $recordsPerPage = 5;

                        // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                        // Calculate the offset for pagination
                        $offset = ($current_page - 1) * $recordsPerPage;

                        $invests11 = "SELECT * FROM investments ORDER BY Amount DESC LIMIT ? OFFSET ?";
                        $stmt81 = $mysqli->prepare($invests11);
                        $stmt81->bind_param('ii', $recordsPerPage, $offset);
                        $stmt81->execute();
                        $resultingDetails21 = $stmt81->get_result();

                        if ($resultingDetails21->num_rows > 0) {
                            echo '<table>';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Email Address</th>';
                            echo '<th>UserName</th>';
                            echo '<th>Phone No</th>';
                            echo '<th>To Approve</th>';
                            echo '<th>End Date</th>';
                            echo '<th>Days Remaining</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            while ($rowDetails1 = $resultingDetails21->fetch_assoc()) {
                                // Get the end date as a DateTime object
                                $end_date1 = new DateTime($rowDetails1['End_Date']);
                                $invest_status = $rowDetails1['Status'];
                                // Get the current date as a DateTime object
                                $current_date1 = new DateTime();

                                // Check if the end date has passed
                                if ($current_date1 > $end_date1  && $invest_status == 'processing') {
                                    // Calculate the interval between the current date and the end date

                                    $interval1 = $current_date1->diff($end_date1);
                                    $time_remaining_str1 = $interval1->format('%r%a days, %H hours, %I minutes, %S seconds');

                                    // Output the table rows for records where the time is up
                                    echo '<tr>';
                                    echo '<td>' . $rowDetails1['Email_Address'] . '</td>';
                                    echo '<td>' . $rowDetails1['User_Name'] . '</td>';
                                    echo '<td>' . $rowDetails1['Phone_No'] . '</td>';
                                    echo '<td>' . $rowDetails1['Total_Amount_To_Earn'] . '</td>';
                                    echo '<td>' . $rowDetails1['End_Date'] . '</td>';
                                    echo '<td>' . $time_remaining_str1 . '</td>';
                                    echo '</tr>';
                                }
                            }

                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            // If there are no records, display a message
                            echo '<p>No records</p>';
                        }
                        ?>
                    </div>
                </div>

                <?php
                if ($totalPages > 0) {
                    // Add navigation arrows
                    $prevPage = $current_page - 1;
                    $nextPage = $current_page + 1;
                    if ($prevPage >= 1) {
                ?>
                        <a href="?page=<?php echo $prevPage; ?>">
                            << <!-- Previous page arrow -->
                        </a>
                    <?php
                    }
                    if ($nextPage <= $totalPages) {
                    ?>
                        <a href="?page=<?php echo $nextPage; ?>">
                            >> <!-- Next page arrow -->
                        </a>
                <?php
                    }
                }
                ?>

                <!-- ======================================== -->
                
                <!-- Reminders -->
                <div class="reminders">
                    <div class="header">
                        <i class='bx bx-note'></i>
                        <h3>Performance</h3>
                        <!-- <i class='bx bx-filter'></i>
                        <i class='bx bx-plus'></i> -->
                    </div>
                    
                    <!-- Add additional HTML for progress bars -->
                    <ul class="task-list">
                        <p>Gold </p>
                        <li class="completed">
                            <div class="task-title">
                                <!-- <i class='bx bx-check-circle'></i> -->
                            </div>
                            <div class="progress-bar">
                                <div class="progress" style="width: <?php echo $goldPercentage; ?>%;"></div>
                            </div>
                            <i class='bx bx-dots-vertical-rounded' onclick="toggleGraph('gold', <?php echo $TotalGoldCounts; ?>, <?php echo $goldPercentage; ?>)"></i>
                        </li>
                        <p>Silver</p>
                        <li class="completed">
                            <div class="task-title">
                                <!-- <i class='bx bx-check-circle'></i> -->
                            </div>
                            <div class="progress-bar">
                                <div class="progress" style="width: <?php echo $silverPercentage; ?>%;"></div>
                            </div>
                            <i class='bx bx-dots-vertical-rounded' onclick="toggleGraph('silver', <?php echo $TotalSilverCounts; ?>, <?php echo $silverPercentage; ?>)"></i>
                        </li>
                        <p>Bronze</p>
                        <li class="not-completed">
                            <div class="task-title">
                                <!-- <i class='bx bx-x-circle'></i> -->
                            </div>
                            <div class="progress-bar">
                                <div class="progress" style="width: <?php echo $bronzePercentage; ?>%;"></div>
                            </div>
                            <i class='bx bx-dots-vertical-rounded' onclick="toggleGraph('bronze', <?php echo $TotalBronzeCounts; ?>, <?php echo $bronzePercentage; ?>)"></i>
                        </li>
                    </ul>
                </div>

                <!-- End of Reminders-->

            </div>
            <!-- Add a container for displaying the graph -->
            <div id="graphContainer" class="hidden">
                <canvas id="packageGraph"></canvas>
            </div>

    
    `;
            const mainContent = document.querySelector('main');
            mainContent.innerHTML = Dashboard;
        });
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2736930210041886" crossorigin="anonymous"></script>

    <script>
        // Get the "Change plan" list item
        const settingsItem = document.querySelector('.side-menu li:nth-child(5)');

        // Add a click event listener to the "Change plan" list item
        settingsItem.addEventListener('click', function(event) {
            // Prevent the default link behavior
            event.preventDefault();

            // Replace the main content with the new code
            const settings = `
            <?php

            //lets fetch user data
            $UserData = "SELECT * FROM profitedge_users WHERE Email_Address = ?";
            $stmt = $mysqli->prepare($UserData);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $results = $stmt->get_result();
            if ($results->num_rows === 1) {
                $rowUserData = $results->fetch_assoc();
                $userName = $rowUserData['User_Name'];
                $phone = $rowUserData['Phone_No'];
                $Refferer = $rowUserData['Refferer'];
                $joined = $rowUserData['Joining_Day'];
            }

            ?>
        <div class="header">
                <div class="left">
                    <h1>Settings </h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Account
                            </a></li>
                        /
                        <li><a href="#" class="active">Settings</a></li>
                    </ul>
                </div>
                <a href="mailto:finvestiateam@gmail.com" class="report">
                    <i class='bx bx-envelope'></i>
                    <span>Send a Message</span>
                </a>
            </div>
        <div class="profile_">

<div class="my-profile" id="my-profile1">
    <h2>my profile</h2>



    <div class="details">
        <div class="flex">
            <h4>Username</h4>
            <h4>
<?php
echo $userName;
?>
            </h4>
        </div>

        <div class="flex">
            <h4>Email</h4>
            <h4>
            <?php
            echo $email;
            ?>
            </h4>
        </div>


        <div class="flex">
            <h4>Phone no</h4>
            <h4>
            <?php
            echo $phone;
            ?>
            </h4>
        </div>

    </div>

</div>

<div class="my-profile" id="my-profile2">
    <h2>Change Password</h2>

    <div class="password-manager">
        <p id="passwordresponse" style="font-size:.8rem; font-weight:bolder; text-align:center;"></p>
        <form action="" method="POST" id="passwordForm">

            <div class="flex" id="flex1">
                <label for="old">Old Password</label>
                <input type="password" placeholder="Enter Old Password" id="oldER" name="old" required>

            </div>

            <div class="flex" id="flex2">
                <label for="new">New Password</label>
                <input type="password" placeholder="Enter New Password" id="new" name="new" required>

            </div>

            <div class="flex" id="flex3">
                <label for="conf_new">Confirm Password</label>
                <input type="password" placeholder="Confirm New Password" id="conf_new" name="conf_new" required>

            </div>
            <div class="change_password_area">
                <button type="submit" name="changePass">Change Password</button>
            </div>
        </form>

    </div>
</div>
</div>`;
            const mainContent = document.querySelector('main');
            mainContent.innerHTML = settings;

            function handleChangePassword(event) {
                event.preventDefault();
                const form = event.target;
                const formData = new FormData(form);
                formData.append('changePass', true);
                const passwordResponse = document.getElementById('passwordresponse');

                const xhr = new XMLHttpRequest();
                xhr.open('POST', './settings.php', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            passwordResponse.textContent = xhr.responseText;
                            passwordResponse.style.color = "green";
                            setTimeout(() => {
                                window.location.href = './logout.php';
                            }, 2000);
                        } else {
                            passwordResponse.textContent = "Something went wrong.";
                            passwordResponse.style.color = "red";
                        }
                    }
                };
                xhr.send(formData);
                console.log("sent");
            }
            passwordForm = document.querySelector("#passwordForm");
            passwordForm.addEventListener('submit', handleChangePassword);
        });
    </script>
    <script>
        // Get the "Change plan" list item
        const transactionItem = document.querySelector('.side-menu li:nth-child(3)');

        // Add a click event listener to the "Change plan" list item
        transactionItem.addEventListener('click', function(event) {
            // Prevent the default link behavior
            event.preventDefault();

            const transactions = `
            <div class="header">
                <div class="left">
                    <h1>Users List</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Users
                            </a></li>
                        /
                        <li><a href="#" class="active">Records</a></li>
                    </ul>
                </div>
                <a href="mailto:finvestiateam@gmail.com" class="report">
                    <i class='bx bx-envelope'></i>
                    <span>Send a Message</span>
                </a>
            </div>
        <div class="transactions">
        <div class="bottom-data">
        <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Recent users</h3>

                        <div id="gradient"></div>
                        <form class="searchbox" action="./search.php">
                                <input type="search" placeholder="Search" />
                                <button class="button" type="submit" value="search">&nbsp;</button>
                        </form>

                        <div>
                        <form method="post" id="suspend" class="suspendButtons">
                        <button class="suspendbtn" type="submit" name="suspendAll">suspend all users</button>
                        <button class="suspendbtn" type="submit" name="ActivateAll">Approve all users</button>
                        </form>
                        
                        </div>

                    </div>
                    <?php
                    // Check if the form was submitted
                    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["suspendAll"])) {
                        // Place your database connection code here
                        // Assuming you have established a database connection using $mysqli

                        // Write your SQL query to perform the desired action (e.g., update the database)
                        $query = "UPDATE profitedge_users SET Status = 'Suspended'";

                        // Execute the query
                        if ($mysqli->query($query) === TRUE) {
                            // The query executed successfully, perform any necessary actions or display a success message
                            echo "All users have been suspended successfully!";
                        } else {
                            // An error occurred while executing the query, display an error message
                            echo "Error: " . $mysqli->error;
                        }
                    }
                    ?>
<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["ActivateAll"])) {
    // Place your database connection code here
    // Assuming you have established a database connection using $mysqli

    // Write your SQL query to perform the desired action (e.g., update the database)
    $query = "UPDATE profitedge_users SET Status = 'Active'";

    // Execute the query
    if ($mysqli->query($query) === TRUE) {
        // The query executed successfully, perform any necessary actions or display a success message
        echo "All users have been Activated successfully!";
    } else {
        // An error occurred while executing the query, display an error message
        echo "Error: " . $mysqli->error;
    }
}
?>
                    
                    <?php

                    $recordsPerPage = 5;

                    // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                    // Calculate the offset for pagination
                    $offset = ($current_page - 1) * $recordsPerPage;

                    $invests1 = "SELECT * FROM investments WHERE Email_Address = ? ORDER BY Date DESC LIMIT ? OFFSET ?";
                    $stmt8 = $mysqli->prepare($invests1);
                    $stmt8->bind_param('sii', $email, $recordsPerPage, $offset);
                    $stmt8->execute();
                    $resultingDetails2 = $stmt8->get_result();


                    // Get the total number of records for pagination
                    $countInvests = "SELECT COUNT(*) as total FROM investments WHERE Email_Address = ?";
                    $stmtCount = $mysqli->prepare($countInvests);
                    $stmtCount->bind_param('s', $email);
                    $stmtCount->execute();
                    $resultCount = $stmtCount->get_result();
                    $row = $resultCount->fetch_assoc();
                    $totalRecords = $row['total'];

                    // Calculate the total number of pages
                    $totalPages = ceil($totalRecords / $recordsPerPage);

                    // Output the pagination links
                    // for ($i = 1; $i <= $totalPages; $i++) {
                    //     echo '<a href="#" onclick="handlePaginationClick(' . $i . ')">' . $i . '</a>';
                    // }

                    ?>
                     <div class="tableContainer"> 
                    <table>
                        <thead>
                            <tr>
                                <th>Email_Address</th>
                                <th>User_Name</th>
                                <th>Phone No</th>
                                <th>Refferer</th>
                            
                                <th>Date Joined</th>

                            </tr>
                        </thead>

                        <tbody id="paginationContent">
                            <?php

                            $recordsPerPage = 5;

                            // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                            $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                            // Calculate the offset for pagination
                            $offset = ($current_page - 1) * $recordsPerPage;

                            $invests1 = "SELECT * FROM profitedge_users WHERE Joiner_Account_Type <> ? ";
                            $stmt8 = $mysqli->prepare($invests1);
                            $stmt8->bind_param('s', $acctype);
                            $stmt8->execute();
                            $resultingDetails2 = $stmt8->get_result();

                            if ($resultingDetails2->num_rows > 0) {
                                while ($rowDetails = $resultingDetails2->fetch_assoc()) {
                                    // Generate the table rows here
                                    echo '<tr class="clickable-row">';
                                    echo '<td>' . $rowDetails['Email_Address'] . '</td>';
                                    echo '<td>' . $rowDetails['User_Name'] . '</td>';
                                    echo '<td>' . $rowDetails['Phone_No'] . '</td>';
                                    echo '<td>' . $rowDetails['Refferer'] . '</td>';
                                    echo '<td>' . $rowDetails['Joining_Day'] . '</td>';
                                    $user__email = $rowDetails['Email_Address'];
                                    $usernam__eAvailable = $rowDetails['User_Name'];

                                    echo '<td>' . "<input type='hidden' class='user__email' value='$user__email'>" . '</td>';
                                    echo '<td>' . "<input type='hidden' class='user__name' value='$usernam__eAvailable'>" . '</td>';

                                    echo '</tr>';
                                }
                            } else {
                                // If there are no records, display a single row with "No records"
                                echo '<tr><td colspan="5">No records</td></tr>';
                            }
                            ?>
                            

                        </tbody>
                    </table>
                    <?php
                    if ($totalPages > 0) {
                        // Add navigation arrows
                        $prevPage = $current_page - 1;
                        $nextPage = $current_page + 1;
                        if ($prevPage >= 1) {
                    ?>
                            <a href="?page=<?php echo $prevPage; ?>">
                                << <!-- Previous page arrow -->
                            </a>
                        <?php
                        }
                        if ($nextPage <= $totalPages) {
                        ?>
                            <a href="?page=<?php echo $nextPage; ?>">
                                >> <!-- Next page arrow -->
                            </a>
                    <?php
                        }
                    }
                    ?>
                   
                </div>
                </div>

              
    <div class="showUserDetails">
    <div class="closebtn">
    <i class='bx bx-window-close' id="close"></i>
    </div>

    <h4>Basic User Details</h4>
    <div class="basics">
    <form method="POST">
        <div class="userFields">
            <label for="emailId">Email Address</label>
            <input type="email" id="emailId" name="emailId" class="readonly" readonly>

        </div>

        <div class="userFields">
            <label for="user">User Name</label>
            <input type="text" id="user" name="user" class="readonly" readonly>
        </div>

        <div class="userFields">
            <label for="userphonenumber">Phone Number</label>
            <input type="text" id="userphonenumber" name="userphonenumber" class="readonly" readonly>
        </div>

        <div class="userFields">
            <label for="accountType">Account Type</label>
            <input type="text" id="accountType2" name="accountType">
        </div>
        <div class="userFields">
            <label for="accBalance">Account Balance</label>
            <input type="number" id="accBalance" name="accBalance" class="readonly" readonly>
        </div>
        <div class="userFields">
            <label for="userPlan">Active Package</label>
            <input type="text" id="userPlan" name="userPlan" class="readonly" readonly>
        </div>
        <div class="userFields">
            <label for="Userstatus">Satus</label>
            <input type="text" id="Userstatus2" name="Userstatus">
        </div>
        <div class="userFields">
            <label for=""></label>
            <p id="updateBasicsRes"></p>
            <input type="submit" id="updateBasics" name="updateBasics">
        </div>

    </form>
       
        
    </div>
    <hr>

    <h4>Requested Withdrawals</h4>
    <div class="basics">
    <form method="POST">
        <div class="userFields">
            <label for="requestedFrom">user Recieve From</label>
            <input type="number" id="requestedFrom" name="requestedFrom">
        </div>

        <div class="userFields">
            <label for="mpesaCode">Mpesa Code</label>
            <input type="text" id="mpesaCode" name="mpesaCode">
        </div>

        <div class="userFields">
            <label for="userRequestedwithdrawalAmount">Withdraw Amount</label>
            <input type="number" id="userRequestedwithdrawalAmount" name="userRequestedwithdrawalAmount">
        </div>

        <div class="userFields">
            <label for="UserwithdrawDate">Withdraw Date</label>
            <input type="text" id="UserwithdrawDate" name="UserwithdrawDate" class="readonly" readonly>
        </div>
        <div class="userFields">
            <label for=""></label>
            <p id="updatewithdrawalRequestsRes"></p>
            <input type="submit" id="updatewithdrawalRequests4" name="updatewithdrawalRequests4">
        </div>
    </form>
    </div>
    <hr>
    
    <h4>Requested Deposits</h4>
    <div class="basics">
    <form method="POST">
        <div class="userFields">
            <label for="transactionId">Mpesa Code</label>
            <input type="text" id="transactionId231" name="transactionId23">
        </div>

        <div class="userFields">
            <label for="TransactorName">Transactor</label>
            <input type="text" id="TransactorName1" name="TransactorName" class="readonly" readonly>
        </div>

        <div class="userFields">
            <label for="userphoneTosend">Recieve From/user's</label>
            <input type="number" id="userphoneTosend1" name="userphoneTosend" class="readonly" readonly>
        </div>

        <div class="userFields">
            <label for="myphoneRecieveing">Recieve At</label>
            <input type="number" id="myphoneRecieveing123" name="myphoneRecieveing1">
        </div>

        <div class="userFields">
            <label for="amountToDeposit">Deposit</label>
            <input type="number" id="amountToDeposit1" name="amountToDeposit1" class="readonly" readonly>
        </div>
        <div class="userFields">
            <label for=""></label>
            <p id="updateDepositsRequestsRes"></p>
            
            <input type="submit" id="updateDepositsRequests" name="updateDepositsRequests" >
        </div>
    </form>
    </div>



    </div>

    </div>
    
    
    `;
            const mainContent = document.querySelector('main');
            mainContent.innerHTML = transactions;


            const rows = document.querySelectorAll('.clickable-row');
            const hiddenContainer = document.querySelector('.showUserDetails');
            const close = document.getElementById('close');
            close.addEventListener('click', () => {
                hiddenContainer.style.height = '0px';
            });

            var emailId = document.getElementById('emailId');
            var user = document.getElementById('user');
            var userphoneid = document.getElementById('userphonenumber');
            var useraccounttype = document.getElementById('accountType2');
            var userstatus = document.getElementById('Userstatus2');
            var useraccountBalance = document.getElementById('accBalance');
            var userPackage = document.getElementById('userPlan');

            var userRequestedwithdrawalAmount = document.getElementById('userRequestedwithdrawalAmount');
            var requestedFrom = document.getElementById('requestedFrom');
            var mpesaCode = document.getElementById('mpesaCode');
            var UserwithdrawDate = document.getElementById('UserwithdrawDate');

            var transactionId2 = document.getElementById('transactionId231');
            var TransactorName = document.getElementById('TransactorName1');
            var userphoneTosend = document.getElementById('userphoneTosend1');
            var myphoneRecieveing = document.getElementById('myphoneRecieveing123');
            var amountToDeposit = document.getElementById('amountToDeposit1');


            rows.forEach(row => {
                row.addEventListener('click', function() {
                    var row = this.closest('tr');
                    var userEmailInput = row.querySelector('.user__email');
                    var usernameInput = row.querySelector('.user__name');

                    var userEmailValue = userEmailInput ? userEmailInput.value : '';
                    var usernameValue = usernameInput ? usernameInput.value : '';

                    var formData = new FormData();
                    formData.append('userEmail', userEmailValue);
                    formData.append('username', usernameValue);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', './update_user_info.php', true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                // Handle the response
                                emailId.value = response.updatedEmailValue;
                                user.value = response.updatedUserNameValue;
                                userphoneid.value = response.updatedPhoneValue;
                                useraccounttype.value = response.updatedAccountValue;
                                userstatus.value = response.updatedStatusValue;
                                useraccountBalance.value = response.updatedUserAccountBalanceValue;
                                userPackage.value = response.updatedUserPackageValue;

                                userRequestedwithdrawalAmount.value = response.updatedUserWithdrawamountValue;
                                requestedFrom.value = response.updateUserRecievefromValue;
                                mpesaCode.value = response.updateUserWithdrawIdValue;
                                UserwithdrawDate.value = response.updateUserWithdrawdateValue;

                                transactionId2.value = response.updateUserwithdrawMpesaid;
                                TransactorName.value = response.updateUserTransactor;
                                userphoneTosend.value = response.updateUserSendingAcc;
                                myphoneRecieveing.value = response.updateUserToPayTo;
                                amountToDeposit.value = response.updatedUserdepositAmount;

                                console.log(response);
                            } else {
                                console.error('Error:', xhr.status, xhr.statusText);
                            }
                        }
                    };

                    xhr.send(formData);
                    hiddenContainer.style.height = '60vh'; // Set the desired height
                });
            });

            // ===============
            const updateBasics = document.getElementById('updateBasics');
            let updateBasicsRes = document.getElementById('updateBasicsRes');

            updateBasics.addEventListener('click', function(e) {
                // Get the form data
                e.preventDefault();
                const formData = new FormData();
                formData.append('updateBasics', true);
                formData.append('useremail', document.getElementById('emailId').value);
                formData.append('username', document.getElementById('user').value);
                formData.append('UserStatus', document.getElementById('Userstatus2').value);
                formData.append('UserAccType', document.getElementById('accountType2').value);

                // Create an XMLHttpRequest object
                const xhr = new XMLHttpRequest();

                // Configure the AJAX request
                xhr.open('POST', './AffectUserRecords.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                // Set up the event listener to handle the response
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Request successful, handle the response here
                            const response = JSON.parse(xhr.responseText);
                            updateBasicsRes.innerHTML = response.message; // Access the 'message' property

                        } else {
                            // Request failed, handle errors here
                            // console.error('Error:', xhr.status, xhr.statusText);
                            updateBasicsRes.innerHTML = "Error occurred while processing the request.";
                        }
                    }
                };

                // Send the AJAX request with the form data
                xhr.send(formData);
            });

            // ============
            const updatewithdrawalRequests4 = document.getElementById('updatewithdrawalRequests4');
            let updatewithdrawalRequestsRes = document.getElementById('updatewithdrawalRequestsRes');

            updatewithdrawalRequests4.addEventListener('click', function(e) {
                // Get the form data
                e.preventDefault();
                const formData = new FormData();
                formData.append('updatewithdrawalRequests4', true);
                formData.append('useremail', document.getElementById('emailId').value);
                formData.append('username', document.getElementById('user').value);
                formData.append('recieveFrom', document.getElementById('requestedFrom').value);
                formData.append('mpesaCode', document.getElementById('mpesaCode').value);
                formData.append('userRequestedwithdrawalAmount', document.getElementById('userRequestedwithdrawalAmount').value);
                // Create an XMLHttpRequest object
                const xhr = new XMLHttpRequest();

                // Configure the AJAX request
                xhr.open('POST', './updateuserrequestWithdrawals.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                // Set up the event listener to handle the response
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // console.log("sent");
                            // Request successful, handle the response here
                            const response = JSON.parse(xhr.responseText);
                            updatewithdrawalRequestsRes.innerHTML = response.message; // Access the 'message' property

                        } else {
                            // Request failed, handle errors here
                            console.error('Error:', xhr.status, xhr.statusText);
                            updatewithdrawalRequestsRes.innerHTML = "Error occurred while processing the request.";
                        }
                    }
                };

                // Send the AJAX request with the form data
                xhr.send(formData);
            });

            // ============
            const updateDepositsRequests = document.getElementById('updateDepositsRequests');
            let updateDepositsRequestsRes = document.getElementById('updateDepositsRequestsRes');

            updateDepositsRequests.addEventListener('click', function(e) {
                // Get the form data
                e.preventDefault();
                const formData = new FormData();
                formData.append('updateDepositsRequests', true);
                formData.append('useremail', document.getElementById('emailId').value);
                formData.append('username', document.getElementById('user').value);
                formData.append('transactionId23', document.getElementById('transactionId231').value);
                formData.append('myphoneRecieveing1', document.getElementById('myphoneRecieveing123').value);
                // Create an XMLHttpRequest object
                const xhr = new XMLHttpRequest();

                // Configure the AJAX request
                xhr.open('POST', './updateuserrequestWithdrawals.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                // Set up the event listener to handle the response
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // console.log("sent");
                            // Request successful, handle the response here
                            const response = JSON.parse(xhr.responseText);
                            updateDepositsRequestsRes.innerHTML = response.message; // Access the 'message' property

                        } else {
                            // Request failed, handle errors here
                            console.error('Error:', xhr.status, xhr.statusText);
                            updateDepositsRequestsRes.innerHTML = "Error occurred while processing the request.";
                        }
                    }
                };

                // Send the AJAX request with the form data
                xhr.send(formData);
            });
        });
    </script>
    <script>
        // Get the "Change plan" list item
        const walletItem = document.querySelector('.side-menu li:nth-child(2)');

        // Add a click event listener to the "Change plan" list item
        walletItem.addEventListener('click', function(event) {
            // Prevent the default link behavior
            event.preventDefault();
            const wallet = `
            

            <?php
            $Total_Deopsits = "SELECT SUM(Amount) AS DEPOSITS FROM deposits;";
            $deposits_stmt = $mysqli->prepare($Total_Deopsits);
            $deps = $deposits_stmt->execute();
            $deposits_results = $deposits_stmt->get_result();
            $rowDepost_results = $deposits_results->fetch_assoc();
            $totaDeposits;
            $totaDeposits2 = $rowDepost_results['DEPOSITS'];
            if ($totaDeposits2 > 0) {
                $totaDeposits = $rowDepost_results['DEPOSITS'];
            } else {
                $totaDeposits = 0;
            }
            $investstatus = 'Approved';

            $amount_Users_need = "SELECT SUM(Total_Amount_To_Earn) AS OWED FROM investments WHERE Status != ?";
            $owed_amount_stmt = $mysqli->prepare($amount_Users_need);
            $owed_amount_stmt->bind_param('s', $investstatus);
            $owed_amount_stmt->execute();
            $owed_result = $owed_amount_stmt->get_result();
            $rowOwed_result = $owed_result->fetch_assoc();
            $Amount_Users_owe = intval($rowOwed_result['OWED']) + $Total_refferal_Earnings;
            ?>
            <div class="header">
                <div class="left">
                    <h1>Wallet</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Account
                            </a></li>
                        /
                        <li><a href="#" class="active">Balance</a></li>
                    </ul>
                </div>
                <a href="mailto:finvestiateam@gmail.com" class="report">
                    <i class='bx bx-envelope'></i>
                    <span>Send a Message</span>
                </a>
            </div>
            <div class = "wallet-container">
                <div class = "left-wallet">
                <ul class="insights">
                <li>
                    <i class='bx bx-group'></i>
                    <span class="info">
                        <h3>
                        <?php echo "Ksh. " . $totaDeposits; ?>
                        </h3>
                        <p>Total Deposits</p>
                    </span>
                </li>
                <li><i class='bx bx-medal'></i>
                    <span class="info">
                        <h3>
                        <?php echo 'Ksh. ' . $Amount_Users_owe; ?>
                        </h3>
                        <p>Amount Users Need</p>
                    </span>
                </li>
                <li><i class='bx bx-transfer'></i>
                    <span class="info">
                        <h3>
                        <?php echo 'Ksh. ' . $total_Withdrawals; ?>
                        </h3>
                        <p>Total Withdrawals</p>
                    </span>
                </li>
                <li><i class='bx bx-credit-card'></i>
                    <span class="info">
                        <h3>
                           
                            <?php echo "Ksh. " . $Total_Account_Balance_For_Admin;
                            ?>
                        </h3>
                        <p>My Account Balance</p>
                    </span>
                </li>
            </ul>
            <div class="transact">
            <h2>send</h2>
            <h2>Recieve</h2>
            <h2>plan</h2>
            </div>
                </div>
                <div class = "right-wallet">
                <h2>Withdraw From PayBill</h2>
                <p>Be sure to begin with 254... for a succesfull transaction.</p>
                <form method="post" class="wallet_form">
                <img src="./images/mpesa.png" alt="not found">
                <p id="setphone_response" style="font-size:.8rem; font-weight:bolder; text-align:center;"></p>
                <input type="number" name="oldotp" placeholder="Enter old OTP" class="inputs" autocomplete="off" required>
                <input type="number" name="newotp" placeholder="Enter new OTP" class="inputs" autocomplete="off" required>
                <input type="number" name="confotp" placeholder="Confirm OTP" class="inputs" autocomplete="off" required>
                <input type="password" placeholder="Password" name="password" class="inputs" required>
                <input type="submit" value="Withdraw" name="changephoneno">
                </form>


                </div>
            </div>
          

            `;




            const mainContent = document.querySelector('main');
            mainContent.innerHTML = wallet;



            function walletFunc(event) {
                event.preventDefault(); // Prevent default form submission
                responseFromserver = document.getElementById("setphone_response");
                const form = event.target; // Get the form element
                const formData = new FormData(form); // Create a FormData object to collect form data
                formData.append('changephoneno', true);

                // Make an AJAX request
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "./setOTP.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Handle the response from "wallet.php" if needed
                        console.log(xhr.responseText);
                        responseFromserver.innerHTML = xhr.responseText;
                        // Delay the logout action for two seconds
                        setTimeout(function() {
                            // Implement your logout action here, like redirecting to the logout page or clearing session/cookie.
                            // For example, you can redirect to the logout page like this:
                            window.location.href = './logout.php';
                        }, 2000);
                    }
                };
                xhr.send(formData);
            }

            // Add an event listener to the form submission
            const walletForm = document.querySelector(".wallet_form");
            walletForm.addEventListener("submit", walletFunc);



        });
    </script>
    <script>
        const suspend = document.querySelector('.side-menu li:nth-child(6)');

        // Add a click event listener to the "Change plan" list item
        suspend.addEventListener('click', function(event) {
            // Prevent the default link behavior
            event.preventDefault();
            const suspendItem = `
            <div class="header">
                <div class="left">
                    <h1>Suspension</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Suspend
                            </a></li>
                        /
                        <li><a href="#" class="active">User</a></li>
                    </ul>
                </div>
                <a href="mailto:finvestiateam@gmail.com" class="report">
                    <i class='bx bx-envelope'></i>
                    <span>Send a Message</span>
                </a>
            </div>
            <div class="suspension">
            <div class="main-block">
  <h1 style="font-size: 1rem !important; text-align: center; color: var(--secondary);">Suspend A user with Email</h1>
  <form id="suspendForm" method="POST">
    <hr>
    <input type="email" name="email" id="email" placeholder="Email" required />
    <input type="text" name="username" id="username" placeholder="User Name" required />
    <input type="password" name="pass" id="pass" placeholder="Password" required />
    <hr>

    <div class="btn-block">
      <p style="color: var(--dark);">By clicking Suspend, you agree on our <a href="https://www.finvestia.co.ke/policy.php" style="color: green;">Privacy Policy for finVestia</a>.</p>
      <button type="button" id="suspendBtn" name="suspendUser">Suspend</button>
    </div>
    <p id="result" style="color:green;"></p>
  </form>
</div>
</div>
    
    `;
            // mainContent.innerHTML = suspendItem;
            const mainContent = document.querySelector('main');
            mainContent.innerHTML = suspendItem;

            const suspendBtn = document.getElementById('suspendBtn');
            let susp = document.getElementById('result');

            suspendBtn.addEventListener('click', function() {
                // Get the form data
                const formData = new FormData();
                formData.append('suspendUser', true);
                formData.append('email', document.getElementById('email').value);
                formData.append('username', document.getElementById('username').value);
                formData.append('pass', document.getElementById('pass').value);

                // Create an XMLHttpRequest object
                const xhr = new XMLHttpRequest();

                // Configure the AJAX request
                xhr.open('POST', './suspend_user.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                // Set up the event listener to handle the response
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Request successful, handle the response here
                            const response = JSON.parse(xhr.responseText);
                            susp.innerHTML = response.message; // Access the 'message' property

                        } else {
                            // Request failed, handle errors here
                            console.error('Error:', xhr.status, xhr.statusText);
                            susp.innerHTML = "Error occurred while processing the request.";
                        }
                    }
                };

                // Send the AJAX request with the form data
                xhr.send(formData);
            });

        });
    </script>
    <script>
        const transactUser = document.querySelector('.side-menu li:nth-child(7)');

        transactUser.addEventListener('click', function(event) {
            event.preventDefault();
            const transact = `
            <div class="header">
                <div class="left">
                    <h1>Transaction</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Transact
                            </a></li>
                        /
                        <li><a href="#" class="active">User</a></li>
                    </ul>
                </div>
                <a href="mailto:finvestiateam@gmail.com" class="report">
                    <i class='bx bx-envelope'></i>
                    <span>Send a Message</span>
                </a>
            </div>
            <div class="transactionContainer">

            <div class="flexBlock">
            <div class="main-block">
  <h1 style="font-size: 1rem !important; text-align: center; color: var(--secondary);">Transact A User By Phone</h1>
  <form id="transactForm" method="POST">
    <hr>
    <input type="text" name="transactionID" id="transactionID" placeholder="TransactionID" required />
    <input type="number" name="phone" id="phone" placeholder="Customer Phone Number" required />
    <input type="number" name="amount" id="amount" placeholder="Amount Customer Paid" required />
    <input type="Date" name="date" id="date" placeholder="Date" required />
    <input type="time" name="time" id="time" placeholder="Time" required />
    <input type="password" name="OTP" id="OTP" placeholder="One Time Password" required />
    <select name="transactor" id="transactor">
            <option value="Ian">Ian</option>
            <option value="Paul">Paul</option>
            <option value="Gilbert">Gilbert</option>
    </select>
    <input type="password" name="pass" id="pass" placeholder="Password" required />
    <hr>

    <div class="btn-block">
      <p style="color: var(--dark);">By clicking Transact, you agree on our <a href="https://www.finvestia.co.ke/policy.php" style="color: green;">Privacy Policy for finVestia</a>.</p>
      <button type="button" id="transactBtn22" name="transactBtn2">Transact Now</button>
    </div>
    <p id="trans_result" style="color:green;"></p>
  </form>
</div>









<div class="main-block">
  <h1 style="font-size: 1rem !important; text-align: center; color: var(--secondary);">Verify User Withdrawal</h1>
  <form id="withdrawform" method="POST">
    <hr>
    <input type="text" name="withdrawID" id="withdrawID" placeholder="MPESA ID" required />
    <input type="number" name="withdrawPhone" id="withdrawPhone" placeholder="Phone sending Money" required />
    <input type="number" name="phonerecieving" id="phonerecieving" placeholder="Phone recieving Money" required />
    <input type="number" name="withdrawAmount" id="withdrawAmount" placeholder="Amount Customer Withdrew" required />
    <input type="Date" name="withdrawDate" id="withdrawDate" placeholder="Date" required />
    <input type="time" name="withdrawTime" id="withdrawTime" placeholder="Time" required />
    <input type="password" name="O_T_P" id="O_T_P" placeholder="One Time Password" required />
    <select name="withdrawTransactor" id="withdrawTransactor">
            <option value="Ian">Ian</option>
            <option value="Paul">Paul</option>
            <option value="Gilbert">Gilbert</option>
    </select>
    <input type="password" name="withdrawPass" id="withdrawPass" placeholder="Password" required />
    <hr>

    <div class="btn-block">
      <p style="color: var(--dark);">By clicking withdraw, you agree on our <a href="https://www.finvestia.co.ke/policy.php" style="color: green;">Privacy Policy for finVestia</a>.</p>
      <button type="button" id="withdrawUserBtn" name="withdrawUserBtn">Withdraw For User</button>
    </div>
    <p id="withdrawRes" style="color:green;"></p>
  </form>
</div>







</div>



<div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Requested Deposits</h3>
                       
                        <?php
                        $pay = 0;
                        $countRequests = "SELECT COUNT(*) AS REQUESTSCOUNTED FROM transactionsupdate WHERE PayTo = ?";
                        $countRequests_stmt = $mysqli->prepare($countRequests);
                        $countRequests_stmt->bind_param('s', $pay);
                        $countRequests_stmt->execute();
                        $countRequestNumber = $countRequests_stmt->get_result()->fetch_assoc();
                        $RequestsCounts = $countRequestNumber['REQUESTSCOUNTED'];
                        ?>
                        <h2 style="color:black; background-color:green; height:auto; width:auto;border-radius:3px;font-weight:bolder; text-align:center; padding:3px;"><?php echo $RequestsCounts; ?></h2>

                    </div>
                    <?php

                    $onepageRecords = 5;

                    // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

                    // Calculate the offset for pagination
                    $OFFSET = ($currentPage - 1) * $onepageRecords;

                    $deposits1 = "SELECT * FROM transactionsupdate ORDER BY Phone_No DESC LIMIT ? OFFSET ?";
                    $deposits1_stmt = $mysqli->prepare($deposits1);
                    $deposits1_stmt->bind_param('ii', $onepageRecords, $OFFSET);
                    $deposits1_stmt->execute();
                    $depositResultDetails = $deposits1_stmt->get_result();


                    // Get the total number of records for pagination
                    $countDeposits1 = "SELECT COUNT(*) as TOTAL FROM transactionsupdate ";
                    $countDeposits1_stmt = $mysqli->prepare($countDeposits1);
                    // $countDeposits1_stmt->bind_param('s', $email);
                    $countDeposits1_stmt->execute();
                    $resultCountDeposits = $countDeposits1_stmt->get_result();
                    $rowDeposits = $resultCountDeposits->fetch_assoc();
                    $totalDepositRecords = $rowDeposits['TOTAL'];

                    // Calculate the total number of pages
                    $totalDepositPages = ceil($totalDepositRecords / $onepageRecords);


                    ?>
                     <div class="tableContainer"> 
                    
                    <form method="post"> <!-- Add a form around the table -->
                    <table>
                        <thead>

                            <tr>
                                <th>Email Address</th>
                                <th>UserName</th>
                                <th>Phone No</th>
                                <th>Pay To</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="paginationContent">
                            <?php

                            $onepageRecords = 5;

                            // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                            $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

                            // Calculate the OFFSET for pagination
                            $OFFSET = ($currentPage - 1) * $onepageRecords;
                            $payto = 0;

                            $deposits1 = "SELECT * FROM transactionsupdate WHERE PayTo = ? ORDER BY Phone_No DESC LIMIT ? OFFSET ?";
                            $deposits1_stmt = $mysqli->prepare($deposits1);
                            $deposits1_stmt->bind_param('iii', $payto, $onepageRecords, $offset);
                            $deposits1_stmt->execute();
                            $depositResultDetails = $deposits1_stmt->get_result();

                            if ($depositResultDetails->num_rows > 0) {
                                while ($rowDepositDetails1 = $depositResultDetails->fetch_assoc()) {
                                    $useremail = $rowDepositDetails1['Email_Address'];
                                    $usernameAvailable = $rowDepositDetails1['User_Name'];
                                    // Generate the table rows here
                                    echo '<tr>';
                                    echo '<p id="DepositrequestResponse" style="color:var(--light); background-color:var(--dark); border-radius:5px; padding-left:10px; font-weight:bolder;">' . "" . '</p>';
                                    echo '<td>' . $rowDepositDetails1['Email_Address'] . '</td>';
                                    echo '<td>' . $rowDepositDetails1['User_Name'] . '</td>';
                                    echo '<td>' . $rowDepositDetails1['Phone_No'] . '</td>';
                                    echo '<td>' . "<input type='number' placeholder='Phone No' name='phoneNumber'>" . '</td>';
                                    echo '<td>' . "<input type='hidden' class='user-email' value='$useremail'>" . '</td>';
                                    echo '<td>' . "<input type='hidden' class='username' value='$usernameAvailable'>" . '</td>';
                                    echo '<td>' . "<input type='button' class='issue-btn' value='Issue Number'>" . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="5">No records</td></tr>';
                            }

                            ?>

                        </tbody>
                    </table>
                    </form>
                    <?php
                    if ($totalDepositPages > 0) {
                        // Add navigation arrows
                        $prevPage = $currentPage - 1;
                        $nextPage = $currentPage + 1;
                        if ($prevPage >= 1) {
                    ?>
                            <a href="?page=<?php echo $prevPage; ?>">
                                << <!-- Previous page arrow -->
                            </a>
                        <?php
                        }
                        if ($nextPage <= $totalDepositPages) {
                        ?>
                            <a href="?page=<?php echo $nextPage; ?>">
                                >> <!-- Next page arrow -->
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>




                <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Requested withdrawals</h3>
                        <?php
                        $pay = 0;
                        $countRequests1 = "SELECT COUNT(*) AS REQUESTSCOUNTED FROM requestedwithdrawals WHERE Recieve_From = ?";
                        $countRequests_stmt1 = $mysqli->prepare($countRequests1);
                        $countRequests_stmt1->bind_param('s', $pay);
                        $countRequests_stmt1->execute();
                        $countRequestNumber1 = $countRequests_stmt1->get_result()->fetch_assoc();
                        $RequestsCounts1 = $countRequestNumber1['REQUESTSCOUNTED'];
                        ?>
                        <h2 style="color:black; background-color:green; height:auto; width:auto;border-radius:3px;font-weight:bolder; text-align:center; padding:3px;"><?php echo $RequestsCounts1; ?></h2>

                    </div>
                    <?php

                    $onepageRecords = 5;

                    // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

                    // Calculate the offset for pagination
                    $OFFSET = ($currentPage - 1) * $onepageRecords;

                    $withdrawals1 = "SELECT * FROM requestedwithdrawals ORDER BY Phone_No DESC LIMIT ? OFFSET ?";
                    $withdrawals1_stmt = $mysqli->prepare($withdrawals1);
                    $withdrawals1_stmt->bind_param('ii', $onepageRecords, $OFFSET);
                    $withdrawals1_stmt->execute();
                    $withdrawalResultDetails = $withdrawals1_stmt->get_result();


                    // Get the total number of records for pagination
                    $countwithdrawals1 = "SELECT COUNT(*) as TOTAL FROM requestedwithdrawals ";
                    $countwithdrawals1_stmt = $mysqli->prepare($countwithdrawals1);
                    // $countwithdrawals1_stmt->bind_param('s', $email);
                    $countwithdrawals1_stmt->execute();
                    $resultCountwithdrawals = $countwithdrawals1_stmt->get_result();
                    $rowwithdrawals = $resultCountwithdrawals->fetch_assoc();
                    $totalwithdrawalRecords = $rowwithdrawals['TOTAL'];

                    // Calculate the total number of pages
                    $totalwithdrawalPages = ceil($totalwithdrawalRecords / $onepageRecords);


                    ?>
                     <div class="tableContainer"> 
                    <form method="post"> <!-- Add a form around the table -->
                    <table>
                        <thead>

                            <tr>
                                <th>Email Address</th>
                                <th>UserName</th>
                                <th>Phone No</th>
                                <th>Amount</th>
                                <th>I'll pay through</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="paginationContent">
                            <?php

                            $onepageRecords = 5;

                            // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                            $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

                            // Calculate the OFFSET for pagination
                            $OFFSET = ($currentPage - 1) * $onepageRecords;
                            $Recive_From = 0;

                            $withdrawals1 = "SELECT * FROM requestedwithdrawals WHERE Recieve_From = ? ORDER BY Phone_No DESC LIMIT ? OFFSET ?";
                            $withdrawals1_stmt = $mysqli->prepare($withdrawals1);
                            $withdrawals1_stmt->bind_param('iii', $Recive_From, $onepageRecords, $offset);
                            $withdrawals1_stmt->execute();
                            $withdrawalResultDetails = $withdrawals1_stmt->get_result();

                            if ($withdrawalResultDetails->num_rows > 0) {
                                while ($rowwithdrawalDetails1 = $withdrawalResultDetails->fetch_assoc()) {
                                    $useremail = $rowwithdrawalDetails1['Email_Address'];
                                    $usernameAvailable = $rowwithdrawalDetails1['User_Name'];
                                    $userphone = $rowwithdrawalDetails1['Phone_No'];
                                    $useramount = $rowwithdrawalDetails1['Amount'];
                                    // Generate the table rows here
                                    echo '<tr>';
                                    echo '<p id="withdrawrequestResponse" style="color:var(--light); background-color:var(--dark); border-radius:5px; padding-left:10px; font-weight:bolder;">' . "" . '</p>';
                                    echo '<td>' . $rowwithdrawalDetails1['Email_Address'] . '</td>';
                                    echo '<td>' . $rowwithdrawalDetails1['User_Name'] . '</td>';
                                    echo '<td>' . $rowwithdrawalDetails1['Phone_No'] . '</td>';
                                    echo '<td>' . $rowwithdrawalDetails1['Amount'] . '</td>';
                                    echo '<td>' . "<input type='number' placeholder='Phone No' name='phone-Number'>" . '</td>';
                                    echo '<td>' . "<input type='hidden' class='user_email' value='$useremail'>" . '</td>';
                                    echo '<td>' . "<input type='hidden' class='user-name' value='$usernameAvailable'>" . '</td>';
                                    echo '<td>' . "<input type='hidden' class='user-phone' value='$userphone'>" . '</td>';
                                    echo '<td>' . "<input type='hidden' class='user-amount' value='$useramount'>" . '</td>';
                                    echo '<td>' . "<input style='margin-right:30px;' type='button' class='sending-btn' value='Am Sending'>" . '</td>';
                                    echo '<td>' . "<input type='button' class='decline' value='Decline'>" . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6">No records</td></tr>';
                            }

                            ?>

                        </tbody>
                    </table>
                    </form>
                    <?php
                    if ($totalwithdrawalPages > 0) {
                        // Add navigation arrows
                        $prevPage = $currentPage - 1;
                        $nextPage = $currentPage + 1;
                        if ($prevPage >= 1) {
                    ?>
                            <a href="?page=<?php echo $prevPage; ?>">
                                << <!-- Previous page arrow -->
                            </a>
                        <?php
                        }
                        if ($nextPage <= $totalwithdrawalPages) {
                        ?>
                            <a href="?page=<?php echo $nextPage; ?>">
                                >> <!-- Next page arrow -->
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>
</div>
            `;


            // mainContent.innerHTML = suspendItem;
            const mainContent = document.querySelector('main');
            mainContent.innerHTML = transact;

            var Decline = document.querySelectorAll('.decline');
            Decline.forEach(function(button) {
                button.addEventListener('click', function() {
                    var row = this.closest('tr');
                    var phoneInput = row.querySelector('input[name="phone-Number"]');
                    var userEmailInput = row.querySelector('.user_email');
                    var usernameInput = row.querySelector('.user-name');
                    var userphonenumber = row.querySelector('.user-phone');
                    var userwithdrawamount = row.querySelector('.user-amount');
                    var withdrawrequestResponse = document.getElementById('withdrawrequestResponse');

                    var phoneValue = phoneInput ? phoneInput.value : '';
                    var userEmailValue = userEmailInput ? userEmailInput.value : '';
                    var usernameValue = usernameInput ? usernameInput.value : '';
                    var userphonenumberValue = userphonenumber ? userphonenumber.value : '';
                    var userwithdrawamountValue = userwithdrawamount ? userwithdrawamount.value : '';

                    var formData = new FormData();
                    formData.append('phone', phoneValue);
                    formData.append('userEmail', userEmailValue);
                    formData.append('username', usernameValue);
                    formData.append('userphone', userphonenumberValue);
                    formData.append('userwithdrawamount', userwithdrawamountValue);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', './decline.php', true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                withdrawrequestResponse.innerHTML = response.message;
                                // Handle the response
                            } else {
                                console.error('Error:', xhr.status, xhr.statusText);
                            }
                        }
                    };

                    xhr.send(formData);
                });
            });

            // Assuming you have added the 'issue-btn' class to your buttons in the HTML
            // document.addEventListener('DOMContentLoaded', function() {
            var sendButtons = document.querySelectorAll('.sending-btn');
            sendButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var row = this.closest('tr');
                    var phoneInput = row.querySelector('input[name="phone-Number"]');
                    var userEmailInput = row.querySelector('.user_email');
                    var usernameInput = row.querySelector('.user-name');
                    var userphonenumber = row.querySelector('.user-phone');
                    var userwithdrawamount = row.querySelector('.user-amount');
                    var withdrawrequestResponse = document.getElementById('withdrawrequestResponse');

                    var phoneValue = phoneInput ? phoneInput.value : '';
                    var userEmailValue = userEmailInput ? userEmailInput.value : '';
                    var usernameValue = usernameInput ? usernameInput.value : '';
                    var userphonenumberValue = userphonenumber ? userphonenumber.value : '';
                    var userwithdrawamountValue = userwithdrawamount ? userwithdrawamount.value : '';

                    var formData = new FormData();
                    formData.append('phone', phoneValue);
                    formData.append('userEmail', userEmailValue);
                    formData.append('username', usernameValue);
                    formData.append('userphone', userphonenumberValue);
                    formData.append('userwithdrawamount', userwithdrawamountValue);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', './sending.php', true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                withdrawrequestResponse.innerHTML = response.message;
                                // Handle the response
                            } else {
                                console.error('Error:', xhr.status, xhr.statusText);
                            }
                        }
                    };

                    xhr.send(formData);
                });
            });
            // });
            // ==============
            var issueButtons = document.querySelectorAll('.issue-btn');

            issueButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var row = this.closest('tr');
                    var phoneInput = row.querySelector('input[name="phoneNumber"]');
                    var userEmailInput = row.querySelector('.user-email');
                    var usernameInput = row.querySelector('.username');

                    var phoneValue = phoneInput ? phoneInput.value : '';
                    var userEmailValue = userEmailInput ? userEmailInput.value : '';
                    var usernameValue = usernameInput ? usernameInput.value : '';
                    var DepositrequestResponse = document.getElementById('DepositrequestResponse');
                    var formData = new FormData();
                    formData.append('phone4', phoneValue);
                    formData.append('userEmail4', userEmailValue);
                    formData.append('username4', usernameValue);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', './giveNumber.php', true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                // Handle the response
                                DepositrequestResponse.innerHTML = response.message;
                            } else {
                                console.error('Error:', xhr.status, xhr.statusText);
                            }
                        }
                    };

                    xhr.send(formData);
                });
            });
            // ===============
            // });


            // =====================================================
            const transactBtn = document.getElementById('transactBtn22');
            let trans = document.getElementById('trans_result');

            transactBtn.addEventListener('click', function() {
                // Get the form data
                // form = event.target;
                const formData = new FormData();
                formData.append('transactBtn2', true);
                formData.append('transactionID', document.getElementById('transactionID').value);
                formData.append('phone', document.getElementById('phone').value);
                formData.append('amount', document.getElementById('amount').value);
                formData.append('OTP', document.getElementById('OTP').value);
                formData.append('date', document.getElementById('date').value);
                formData.append('time', document.getElementById('time').value);
                formData.append('pass', document.getElementById('pass').value);
                formData.append('transactor', document.getElementById('transactor').value);


                // Create an XMLHttpRequest object
                const xhr = new XMLHttpRequest();

                // Configure the AJAX request
                xhr.open('POST', './invoice.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                // Set up the event listener to handle the response
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Request successful, handle the response here
                            const response = JSON.parse(xhr.responseText);
                            trans.innerHTML = response.message; // Access the 'message' property

                        } else {
                            // Request failed, handle errors here
                            console.error('Error:', xhr.status, xhr.statusText);
                            trans.innerHTML = "Error occurred while processing the request.";
                        }
                    }
                };

                // Send the AJAX request with the form data
                xhr.send(formData);
            });

            // =============================================








            const withdrawUserBtn = document.getElementById('withdrawUserBtn');
            let withdrawRes = document.getElementById('withdrawRes');

            withdrawUserBtn.addEventListener('click', function() {
                // Get the form data
                // form = event.target;
                const formData = new FormData();
                formData.append('withdrawUserBtn', true);
                formData.append('withdrawID', document.getElementById('withdrawID').value);
                formData.append('withdrawPhone', document.getElementById('withdrawPhone').value);
                formData.append('withdrawAmount', document.getElementById('withdrawAmount').value);
                formData.append('O_T_P', document.getElementById('O_T_P').value);
                formData.append('withdrawDate', document.getElementById('withdrawDate').value);
                formData.append('withdrawTime', document.getElementById('withdrawTime').value);
                formData.append('withdrawPass', document.getElementById('withdrawPass').value);
                formData.append('withdrawTransactor', document.getElementById('withdrawTransactor').value);
                formData.append('phonerecieving', document.getElementById('phonerecieving').value);


                // Create an XMLHttpRequest object
                const xhr = new XMLHttpRequest();

                // Configure the AJAX request
                xhr.open('POST', './verify_user_withdrawals.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                // Set up the event listener to handle the response
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Request successful, handle the response here
                            const response = JSON.parse(xhr.responseText);
                            withdrawRes.innerHTML = response.message; // Access the 'message' property

                        } else {
                            // Request failed, handle errors here
                            console.error('Error:', xhr.status, xhr.statusText);
                            withdrawRes.innerHTML = "Error occurred while processing the request.";
                        }
                    }
                };

                // Send the AJAX request with the form data
                xhr.send(formData);
            });




        });
    </script>
    <script>
        const transactorss = document.querySelector('.side-menu li:nth-child(8)');

        transactorss.addEventListener('click', function(event) {
            event.preventDefault();
            const transactors3 = `

            <div class="header">
                <div class="left">
                    <h1>Transactors</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Transactor
                            </a></li>
                        /
                        <li><a href="#" class="active">transactions</a></li>
                    </ul>
                </div>
                <a href="mailto:finvestiateam@gmail.com" class="report">
                    <i class='bx bx-envelope'></i>
                    <span>Send a Message</span>
                </a>
            </div>

    <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Transactor Deposits</h3>

                    </div>
                   
                     <div class="tableContainer"> 
                    <table>
                        <thead>
                            <tr>
                                <th>Email Address</th>
                                <th>UserName</th>
                                <th>Phone No</th>
                                <th>Transactor</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="paginationContent">
                            <?php
                            $recordsPerPage1 = 5;
                            // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                            $currentpagenumber = isset($_GET['page']) ? intval($_GET['page']) : 1;
                            // Calculate the offset for pagination
                            $offset1 = ($currentpagenumber - 1) * $recordsPerPage1;
                            $invests14 = "SELECT * FROM transactionsupdate ORDER BY Date";
                            $stmt254 = $mysqli->prepare($invests14);
                            $stmt254->execute();
                            $resultingDetails254 = $stmt254->get_result();
                            if ($resultingDetails254->num_rows > 0) {
                                while ($rowDetails254 = $resultingDetails254->fetch_assoc()) {
                                    // Generate the table rows here
                                    echo '<tr>';
                                    echo '<td>' . $rowDetails254['Email_Address'] . '</td>';
                                    echo '<td>' . $rowDetails254['User_Name'] . '</td>';
                                    echo '<td>' . $rowDetails254['Phone_No'] . '</td>';
                                    echo '<td>' . $rowDetails254['Transactor'] . '</td>';
                                    echo '<td>' . $rowDetails254['Date'] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6">No records</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>




                <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Transactor withdrawals</h3>

                    </div>
                   
                     <div class="tableContainer"> 
                    <table>
                        <thead>
                            <tr>
                                <th>Email Address</th>
                                <th>UserName</th>
                                <th>Phone No</th>
                                <th>Transactor</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="paginationContent">
                            <?php
                            $recordsPerPage1 = 5;
                            // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                            $currentpagenumber = isset($_GET['page']) ? intval($_GET['page']) : 1;
                            // Calculate the offset for pagination
                            $offset1 = ($currentpagenumber - 1) * $recordsPerPage1;
                            $invests14 = "SELECT * FROM requestedwithdrawals ORDER BY Date";
                            $stmt254 = $mysqli->prepare($invests14);
                            $stmt254->execute();
                            $resultingDetails254 = $stmt254->get_result();
                            if ($resultingDetails254->num_rows > 0) {
                                while ($rowDetails254 = $resultingDetails254->fetch_assoc()) {
                                    // Generate the table rows here
                                    echo '<tr>';
                                    echo '<td>' . $rowDetails254['Email_Address'] . '</td>';
                                    echo '<td>' . $rowDetails254['User_Name'] . '</td>';
                                    echo '<td>' . $rowDetails254['Phone_No'] . '</td>';
                                    echo '<td>' . $rowDetails254['Transactor'] . '</td>';
                                    echo '<td>' . $rowDetails254['Date'] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6">No records</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
    `;
            const mainContent = document.querySelector('main');
            mainContent.innerHTML = transactors3;
        });
    </script>
    <script>
        // Disable right-click context menu
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });

        // Disable keyboard shortcuts (Ctrl + U, Ctrl + Shift + I)
        document.addEventListener('keydown', function(event) {
            if ((event.ctrlKey && event.key === 'u') || (event.ctrlKey && event.shiftKey && event.key === 'i')) {
                event.preventDefault();
            }
        });
    </script>
    <script src="./client.js"></script>
    <script src="./JS FILES/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Get the "Change plan" list item
        const refferalItem = document.querySelector('.side-menu li:nth-child(4)');

        // Add a click event listener to the "Change plan" list item
        refferalItem.addEventListener('click', function(event) {
            // Prevent the default link behavior
            event.preventDefault();
            const refferal = `
        <div class="header">
                <div class="left">
                    <h1>Analitics</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Users
                            </a></li>
                        /
                        <li><a href="#" class="active">Analytics</a></li>
                    </ul>
                </div>
                <a href="mailto:finvestiateam@gmail.com" class="report">
                    <i class='bx bx-envelope'></i>
                    <span>Send a Message</span>
                </a>
            </div>


            <div class="bottom-data">
            <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Recent Investments</h3>
                        <?php
                        $countInvestments = "SELECT COUNT(*) AS investia FROM investments WHERE End_Date>=?";
                        $countInvestments_stmt = $mysqli->prepare($countInvestments);
                        $countInvestments_stmt->bind_param('s', $current_date_str);
                        $countInvestments_stmt->execute();
                        $resultCountinvestments = $countInvestments_stmt->get_result()->fetch_assoc();
                        $countsInvestments = $resultCountinvestments['investia'];
                        ?>
                         <h2 style="color:black; background-color:green; height:auto; width:auto;border-radius:3px;font-weight:bolder; text-align:center; padding:3px;"><?php echo $countsInvestments; ?></h2>
                        
                    </div>
                    <?php

                    $recordsPerPage = 5;

                    // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                    // Calculate the offset for pagination
                    $offset = ($current_page - 1) * $recordsPerPage;

                    $invests1 = "SELECT * FROM investments ORDER BY Date DESC LIMIT ? OFFSET ?";
                    $stmt8 = $mysqli->prepare($invests1);
                    $stmt8->bind_param('ii', $recordsPerPage, $offset);
                    $stmt8->execute();
                    $resultingDetails2 = $stmt8->get_result();


                    // Get the total number of records for pagination
                    $countInvests = "SELECT COUNT(*) as total FROM investments";
                    $stmtCount = $mysqli->prepare($countInvests);
                    // $stmtCount->bind_param('s', $email);
                    $stmtCount->execute();
                    $resultCount = $stmtCount->get_result();
                    $row = $resultCount->fetch_assoc();
                    $totalRecords = $row['total'];

                    // Calculate the total number of pages
                    $totalPages = ceil($totalRecords / $recordsPerPage);

                    // Output the pagination links
                    // for ($i = 1; $i <= $totalPages; $i++) {
                    //     echo '<a href="#" onclick="handlePaginationClick(' . $i . ')">' . $i . '</a>';
                    // }

                    ?>
                     <div class="tableContainer"> 
                    <table>
                        <thead>
                            <tr>
                                <th>UserName</th>
                                <th>Phone No</th>
                                <th>Status</th>
                                <th>Package</th>
                                <th>Accumulative</th>
                                <th>Date</th>
                                <th>UserName</th>

                            </tr>
                        </thead>

                        <tbody id="paginationContent">
                            <?php

                            $recordsPerPage = 5;

                            // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                            $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                            // Calculate the offset for pagination
                            $offset = ($current_page - 1) * $recordsPerPage;

                            $invests1 = "SELECT * FROM investments WHERE End_Date>=? ORDER BY Date DESC LIMIT ? OFFSET ?";
                            $stmt8 = $mysqli->prepare($invests1);
                            $stmt8->bind_param('sii', $current_date_str, $recordsPerPage, $offset);
                            $stmt8->execute();
                            $resultingDetails2 = $stmt8->get_result();

                            if ($resultingDetails2->num_rows > 0) {
                                while ($rowDetails = $resultingDetails2->fetch_assoc()) {
                                    // Generate the table rows here
                                    echo '<tr>';
                                    echo '<td>' . $rowDetails['Amount'] . '</td>';
                                    echo '<td>' . $rowDetails['Date'] . '</td>';
                                    echo '<td>' . $rowDetails['Status'] . '</td>';
                                    echo '<td>' . $rowDetails['Package'] . '</td>';
                                    echo '<td>' . ($rowDetails['Amount'] + $rowDetails['Accumulative_Amount']) . '</td>';
                                    echo '<td>' . $rowDetails['Date'] . '</td>';
                                    echo '<td>' . $rowDetails['User_Name'] . '</td>';


                                    echo '</tr>';
                                }
                            } else {
                                // If there are no records, display a single row with "No records"
                                echo '<tr><td colspan="5">No records</td></tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                    <?php
                    if ($totalPages > 0) {
                        // Add navigation arrows
                        $prevPage = $current_page - 1;
                        $nextPage = $current_page + 1;
                        if ($prevPage >= 1) {
                    ?>
                            <a href="?page=<?php echo $prevPage; ?>">
                                << <!-- Previous page arrow -->
                            </a>
                        <?php
                        }
                        if ($nextPage <= $totalPages) {
                        ?>
                            <a href="?page=<?php echo $nextPage; ?>">
                                >> <!-- Next page arrow -->
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>
</div>
                <div class="bottom-data">
            <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Recent Deposits</h3>
                        <?php
                        $recentdepositcount = "SELECT COUNT(*) AS RECENT FROM deposits";
                        $recentdepositcount_stmt = $mysqli->prepare($recentdepositcount);
                        $recentdepositcount_stmt->execute();
                        $recentCountsDeposits = $recentdepositcount_stmt->get_result()->fetch_assoc();
                        $depositsCounts = $recentCountsDeposits['RECENT'];
                        ?>
                        <h2 style="color:black; background-color:green; height:auto; width:auto;border-radius:3px;font-weight:bolder; text-align:center; padding:3px;"><?php echo $depositsCounts; ?></h2>
                    </div>
                    <?php

                    $recordsPerPage = 5;

                    // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                    // Calculate the offset for pagination
                    $offset = ($current_page - 1) * $recordsPerPage;

                    $invests1 = "SELECT * FROM deposits ORDER BY Date DESC LIMIT ? OFFSET ?";
                    $stmt8 = $mysqli->prepare($invests1);
                    $stmt8->bind_param('ii', $recordsPerPage, $offset);
                    $stmt8->execute();
                    $resultingDetails2 = $stmt8->get_result();


                    // Get the total number of records for pagination
                    $countInvests = "SELECT COUNT(*) as total FROM deposits";
                    $stmtCount = $mysqli->prepare($countInvests);
                    // $stmtCount->bind_param('s', $email);
                    $stmtCount->execute();
                    $resultCount = $stmtCount->get_result();
                    $row = $resultCount->fetch_assoc();
                    $totalRecords = $row['total'];

                    // Calculate the total number of pages
                    $totalPages = ceil($totalRecords / $recordsPerPage);

                    // Output the pagination links
                    // for ($i = 1; $i <= $totalPages; $i++) {
                    //     echo '<a href="#" onclick="handlePaginationClick(' . $i . ')">' . $i . '</a>';
                    // }

                    ?>
                     <div class="tableContainer"> 
                    <table>
                        <thead>
                            <tr>
                            <th>Email Address</th>
                                <th>Transaction ID</th>
                                <th>Phone No</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody id="paginationContent">
                            <?php

                            $recordsPerPage = 5;

                            // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                            $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                            // Calculate the offset for pagination
                            $offset = ($current_page - 1) * $recordsPerPage;

                            $invests1 = "SELECT * FROM deposits  ORDER BY Date DESC LIMIT ? OFFSET ?";
                            $stmt8 = $mysqli->prepare($invests1);
                            $stmt8->bind_param('ii', $recordsPerPage, $offset);
                            $stmt8->execute();
                            $resultingDetails2 = $stmt8->get_result();

                            if ($resultingDetails2->num_rows > 0) {
                                while ($rowDetails = $resultingDetails2->fetch_assoc()) {
                                    // Generate the table rows here
                                    echo '<tr>';
                                    echo '<td>' . $rowDetails['Email_Address'] . '</td>';
                                    echo '<td>' . $rowDetails['TransactionID'] . '</td>';
                                    echo '<td>' . $rowDetails['Phone_No'] . '</td>';
                                    echo '<td>' . $rowDetails['Amount'] . '</td>';
                                    echo '<td>' . $rowDetails['Date'] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                // If there are no records, display a single row with "No records"
                                echo '<tr><td colspan="5">No records</td></tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                    <?php
                    if ($totalPages > 0) {
                        // Add navigation arrows
                        $prevPage = $current_page - 1;
                        $nextPage = $current_page + 1;
                        if ($prevPage >= 1) {
                    ?>
                            <a href="?page=<?php echo $prevPage; ?>">
                                << <!-- Previous page arrow -->
                            </a>
                        <?php
                        }
                        if ($nextPage <= $totalPages) {
                        ?>
                            <a href="?page=<?php echo $nextPage; ?>">
                                >> <!-- Next page arrow -->
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>
                </div>
                
                <div class="bottom-data">
            <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Recent Withdrawals</h3>
                        <?php
                        $withdrawalsDone = "SELECT COUNT(*) AS WITHDRAWALSDONE FROM withdrawals";
                        $withdrwalsDone_stmt = $mysqli->prepare($withdrawalsDone);
                        $withdrwalsDone_stmt->execute();
                        $withdrawalsdoneCounts = $withdrwalsDone_stmt->get_result()->fetch_assoc();
                        $withdrawalsCounts = $withdrawalsdoneCounts['WITHDRAWALSDONE'];
                        ?>
                        <h2 style="color:black; background-color:green; height:auto; width:auto;border-radius:3px;font-weight:bolder; text-align:center; padding:3px;"><?php echo $withdrawalsCounts; ?></h2>
                        
                    </div>
                    <?php

                    $recordsPerPage = 5;

                    // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                    // Calculate the offset for pagination
                    $offset = ($current_page - 1) * $recordsPerPage;

                    $invests1 = "SELECT * FROM withdrawals ORDER BY Date DESC LIMIT ? OFFSET ?";
                    $stmt8 = $mysqli->prepare($invests1);
                    $stmt8->bind_param('ii', $recordsPerPage, $offset);
                    $stmt8->execute();
                    $resultingDetails2 = $stmt8->get_result();


                    // Get the total number of records for pagination
                    $countInvests = "SELECT COUNT(*) as total FROM withdrawals";
                    $stmtCount = $mysqli->prepare($countInvests);
                    // $stmtCount->bind_param('s', $email);
                    $stmtCount->execute();
                    $resultCount = $stmtCount->get_result();
                    $row = $resultCount->fetch_assoc();
                    $totalRecords = $row['total'];

                    // Calculate the total number of pages
                    $totalPages = ceil($totalRecords / $recordsPerPage);

                    // Output the pagination links
                    // for ($i = 1; $i <= $totalPages; $i++) {
                    //     echo '<a href="#" onclick="handlePaginationClick(' . $i . ')">' . $i . '</a>';
                    // }

                    ?>
                     <div class="tableContainer"> 
                    <table>
                        <thead>
                            <tr>
                                <th>Email Address</th>

                                <th>UserName</th>
                                <th>Phone No</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody id="paginationContent">
                            <?php

                            $recordsPerPage = 5;

                            // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                            $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                            // Calculate the offset for pagination
                            $offset = ($current_page - 1) * $recordsPerPage;

                            $invests1 = "SELECT * FROM withdrawals ORDER BY Date DESC LIMIT ? OFFSET ?";
                            $stmt8 = $mysqli->prepare($invests1);
                            $stmt8->bind_param('ii', $recordsPerPage, $offset);
                            $stmt8->execute();
                            $resultingDetails2 = $stmt8->get_result();

                            if ($resultingDetails2->num_rows > 0) {
                                while ($rowDetails = $resultingDetails2->fetch_assoc()) {
                                    // Generate the table rows here
                                    echo '<tr>';
                                    echo '<td>' . $rowDetails['Email_Address'] . '</td>';
                                    echo '<td>' . $rowDetails['User_Name'] . '</td>';
                                    echo '<td>' . $rowDetails['Phone_No'] . '</td>';
                                    echo '<td>' . $rowDetails['Amount'] . '</td>';
                                    echo '<td>' . $rowDetails['Date'] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                // If there are no records, display a single row with "No records"
                                echo '<tr><td colspan="5">No records</td></tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                    <?php
                    if ($totalPages > 0) {
                        // Add navigation arrows
                        $prevPage = $current_page - 1;
                        $nextPage = $current_page + 1;
                        if ($prevPage >= 1) {
                    ?>
                            <a href="?page=<?php echo $prevPage; ?>">
                                << <!-- Previous page arrow -->
                            </a>
                        <?php
                        }
                        if ($nextPage <= $totalPages) {
                        ?>
                            <a href="?page=<?php echo $nextPage; ?>">
                                >> <!-- Next page arrow -->
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>
                
            </div>
                
            
        `;


            const mainContent = document.querySelector('main');
            mainContent.innerHTML = refferal;




        });

        function copycontent() {
            const element = document.querySelector("#refferal_link");


            if (navigator.clipboard) {
                //element.select();
                navigator.clipboard.writeText(element.value);
                alert("Refferal Link Copied!");
            } else {
                let tempInput = document.createElement("input");
                tempInput.setAttribute("type", "text");
                tempInput.setAttribute("value", element.value);
                document.body.appendChild(tempInput);
                tempInput.setSelectionRange(0, 9999);
                document.execCommand("copy");
            }


        }
    </script>



</body>


</html>
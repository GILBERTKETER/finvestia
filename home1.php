<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();
require('./db_conn.php');
$accsType = 'user_account_type_joiner';
if (!isset($_SESSION['LOGGED_IN_EMAIL']) && $_SESSION['LOGGED_IN_ACCTYPE'] != $accsType || $_SESSION['LOGGED_IN_ACCTYPE'] != $accsType) {
    header("Location:./login.php");
    exit();
}
$email = $_SESSION['LOGGED_IN_EMAIL'];

$cookie_name = "user";
$cookie_value = $email;
$cookie_expiry = time() + (86400 * 1); // Expires in 4 days
$cookie_path = "/"; // The path on the server where the cookie is available

setcookie($cookie_name, $cookie_value, $cookie_expiry, $cookie_path);
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
    <link rel="stylesheet" href="./indexClient.css">
    <title>finvestia.co.ke</title>

    <style>
        /* ========================== */
    </style>



</head>

<body>

    <?php
    $total_Withdrawals = 0;
    //withdrawals query
    $withdrawals_Query = "SELECT SUM(Amount) AS WITHDRAWALS FROM withdrawals WHERE Email_Address = ?";
    $withdraw_stmt = $mysqli->prepare($withdrawals_Query);
    $withdraw_stmt->bind_param('s', $email);
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
    $status = 'Approved';
    $invetsmentsDone = "SELECT SUM(Amount) AS INVESTMENTS,SUM(Accumulative_Amount) AS PROFITS FROM investments WHERE Email_Address = ? AND Status = ?";
    $investment_stmt = $mysqli->prepare($invetsmentsDone);
    $investment_stmt->bind_param('ss', $email, $status);
    $investment_stmt->execute();
    $investmentResults = $investment_stmt->get_result();
    if ($investmentResults->num_rows > 0) {
        $rowInvestmentsDone = $investmentResults->fetch_assoc();
        $total_Investments = intval($rowInvestmentsDone['INVESTMENTS']);
        $total_ProfitsInvested = intval($rowInvestmentsDone['PROFITS']);
    } else {
        $total_Investments = 0;
        $total_ProfitsInvested = 0;
    }

    ?>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <!-- <i class='bx bx-code-alt'></i> -->
            <img src="./images/logo.png" alt="">
            <div class="logo-name"><span>fin</span>Vestia</div>
        </a>
        <ul class="side-menu">
            <li class="active"><a href="#"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
            <li><a href="#"><i class='bx bx-wallet-alt'></i>Wallet</a></li>
            <li><a href="#"><i class='bx bx-dollar'></i>Transactions</a></li>
            <li><a href="#"><i class='bx bx-group'></i>Refferals</a></li>
            <li><a href="#"><i class='bx bx-package'></i>Change plan</a></li>
            <li><a href="#"><i class='bx bx-paper-plane'></i>Lets Invest</a></li>
            <li><a href="#"><i class='bx bx-cog'></i>Settings</a></li>
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
                        <p>Total Approved Investments</p>
                    </span>
                </li>
                <li><i class='bx bx-dollar-circle'></i>
                    <span class="info">
                        <h3>
                            <?php echo "Ksh. " . $total_ProfitsInvested; ?>
                        </h3>
                        <p>Total Profit</p>
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
                            <?php require('./Account_Balance.php');
                            echo 'Ksh. ' . $ACCOUNTBALANCEAVAILABLE; ?>
                        </h3>
                        <p>Account Balance</p>
                    </span>
                </li>
            </ul>
            <!-- End of Insights -->

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Recent Investments</h3>

                    </div>
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
                    <!-- <div class="tableContainer"> -->
                    <table>
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Package</th>
                                <th>Accumulative</th>
                            </tr>
                        </thead>

                        <tbody id="paginationContent">
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

                            if ($resultingDetails2->num_rows > 0) {
                                while ($rowDetails = $resultingDetails2->fetch_assoc()) {
                                    // Generate the table rows here
                                    echo '<tr>';
                                    echo '<td>' . $rowDetails['Amount'] . '</td>';
                                    echo '<td>' . $rowDetails['Date'] . '</td>';
                                    echo '<td>' . $rowDetails['Status'] . '</td>';
                                    echo '<td>' . $rowDetails['Package'] . '</td>';
                                    echo '<td>' . ($rowDetails['Amount'] + $rowDetails['Accumulative_Amount']) . '</td>';
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
                <!-- Reminders -->
                <div class="reminders">
                    <div class="header">
                        <i class='bx bx-note'></i>
                        <h3>Performance</h3>
                        <!-- <i class='bx bx-filter'></i>
                        <i class='bx bx-plus'></i> -->
                    </div>
                    <?php

                    // ================================
                    $payTo = 0;
                    $emailaddress = $_SESSION['LOGGED_IN_EMAIL'];
                    $usernam = $_SESSION['LOGGED_IN_USERNAME'];
                    $paytoQuery = "SELECT * FROM transactionsupdate WHERE Email_Address = ? AND User_Name = ?";
                    $paytoQuery_stmt = $mysqli->prepare($paytoQuery);
                    $paytoQuery_stmt->bind_param('ss', $emailaddress, $usernam);
                    $paytoQuery_stmt->execute();
                    $resultingpayto = $paytoQuery_stmt->get_result();
                    if ($resultingpayto->num_rows > 0) {
                        $resultingpayto_res = $resultingpayto->fetch_assoc();
                        $payTo = $resultingpayto_res['PayTo'];
                    } else {
                        $payTo = 'will appear';
                    }




                    // ==============================
                    // Count for Gold Package
                    $TotalGoldCounts = 0;
                    $packageTest_Gold = 'Gold Package';
                    $countPackagesGold = "SELECT COUNT(Package) AS GOLDCOUNTS FROM investments WHERE Email_Address = ? AND Package = ?";
                    $countPackage_stmtGold = $mysqli->prepare($countPackagesGold);
                    $countPackage_stmtGold->bind_param('ss', $email, $packageTest_Gold);
                    $countPackage_stmtGold->execute();
                    $resulting_countGold_package = $countPackage_stmtGold->get_result();
                    if ($resulting_countGold_package->num_rows > 0) {
                        $rowPackage_count = $resulting_countGold_package->fetch_assoc();
                        $TotalGoldCounts = intval($rowPackage_count['GOLDCOUNTS']);
                    }

                    // Count for Silver Package
                    $TotalSilverCounts = 0;
                    $packageTest_Silver = 'Silver Package';
                    $countPackagesSilver = "SELECT COUNT(Package) AS SILVERCOUNTS FROM investments WHERE Email_Address = ? AND Package = ?";
                    $countPackage_stmtSilver = $mysqli->prepare($countPackagesSilver);
                    $countPackage_stmtSilver->bind_param('ss', $email, $packageTest_Silver);
                    $countPackage_stmtSilver->execute();
                    $resulting_countSilver_package = $countPackage_stmtSilver->get_result();
                    if ($resulting_countSilver_package->num_rows > 0) {
                        $rowPackage_count = $resulting_countSilver_package->fetch_assoc();
                        $TotalSilverCounts = intval($rowPackage_count['SILVERCOUNTS']);
                    }

                    // Count for Bronze Package
                    $TotalBronzeCounts = 0;
                    $packageTest_Bronze = 'Bronze Package';
                    $countPackagesBronze = "SELECT COUNT(Package) AS BRONZECOUNTS FROM investments WHERE Email_Address = ? AND Package = ?";
                    $countPackage_stmtBronze = $mysqli->prepare($countPackagesBronze);
                    $countPackage_stmtBronze->bind_param('ss', $email, $packageTest_Bronze);
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

    <script>
        // Get the "Change plan" list item
        const changePlanItem = document.querySelector('.side-menu li:nth-child(5)');

        // Add a click event listener to the "Change plan" list item
        changePlanItem.addEventListener('click', function(event) {
            // Prevent the default link behavior
            event.preventDefault();

            // Replace the main content with the new code
            const newCode = ` 
            <div class="header">
            <div class="left">
                <h1>Change Plan</h1>
                <ul class="breadcrumb">
                    <li><a href="#">
                            Investments
                            
                        </a></li>
                    /
                    <li><a href="#" class="active">Change</a></li>
                </ul>
            </div>
            <a href="mailto:finvestiateam@gmail.com" class="report">
                <i class='bx bx-envelope'></i>
                <span>Send a Message</span>
            </a>
        </div>
        <p style="padding:10px 0; font-weight:bolder;" class="planPar">Welcome to our investment platform! Everything you need to know about investments has been thoroughly explained on our home page. Now, it's time to take action and secure your financial future. Choose your plan wisely and start your journey to financial success with confidence. We're here to support you every step of the way. Happy investing!</p>
            <div class="plan">
       
        <div class="container">
            <div class="packages">
                <div class="goldPackage">
                    <div class="bestsale">
                        <h5>Best sale</h5>
                    </div>
                    <div class="goldImg">
                        <img src="./images/Gold.png" alt='No imaage'></img>

                    </div>
                    <div class="plan">
                        <h3>Gold Plan</h3>
                        <h2>30% <span>weekly</span></h2>
                    </div>
                    <hr>
                 </hr>
                    <div class="investmentAmount">
                        <div class="minimumInvestment">
                            <h3>Minimum Investment: </h3>
                            <h3> ksh. 4,000</h3>
                        </div>

                        <div class="maximumInvestment">
                            <h3>Maximum Investment: </h3>
                            <h3>Above 4,000</h3>
                        </div>

                        <div class="avarageInvestment">
                            <h3>Avarage Monthly: </h3>
                            <h3> 95%</h3>
                        </div>

                    </div>

                    <div class="deposit">
                        <form method="post" id="goldPlanForm">
                       
                        <input type="text" value="Gold" name="GoldpackageName" hidden readonly>
                        <button type="submit" id = "goldplanbtn" data-plan="Gold Plan" name="GoldButton">Choose Plan</button>
                        </form>
                    </div>




                </div>
                <div class="silverPackage">
                    <div class="bestsale">
                        <h5>Best sale</h5>
                    </div>
                    <div class="silverImg">
                        <img src="./images/silver.png" alt='No imaage'></img>
                    </div>

                    <div class="plan">
                        <h3>Silver Plan</h3>
                        <h2>20% <span>weekly</span></h2>
                    </div>
                    <hr>
                    </hr>
                    <div class="investmentAmount">
                        <div class="minimumInvestment">
                            <h3>Minimum Investment: </h3>
                            <h3> Ksh. 2,001</h3>
                        </div>

                        <div class="maximumInvestment">
                            <h3>Maximum Investment: </h3>
                            <h3> Ksh. 3,999</h3>
                        </div>

                        <div class="avarageInvestment">
                            <h3>Avarage Monthly: </h3>
                            <h3> 70%</h3>
                        </div>

                    </div>

                    <div class="deposit">
                    <form method="post" id="silverPlanForm">
                    
                    <input type="text" value="Silver" name="SilverpackageName" hidden readonly>
                        <button type="submit" id = "silverplanbtn" data-plan="Silver Plan" name="SilverButton">Choose Plan</button>
                        </form>
                    </div>


                </div>
                <div class="bronzePackage">
                    <div class="bestsale">
                        <h5>Best sale</h5>
                    </div>
                    <div class="bronzeImg">
                        <img src="./images/Bronze.png" alt='No imaage'></img>
                    </div>
                    

                    <div class="plan">
                        <h3>Bronze Plan</h3>
                        <h2>16% <span>weekly</span></h2>
                    </div>
                    
                    <hr>
                    </hr>
                    
                    <div class="investmentAmount">
                    
                        <div class="minimumInvestment">
                            <h3>Minimum Investment: </h3>
                            <h3> Ksh. 1,200</h3>
                        </div>

                        <div class="maximumInvestment">
                            <h3>Maximum Investment: </h3>
                            <h3>Ksh. 2,000</h3>
                        </div>

                        <div class="avarageInvestment">
                            <h3>Avarage Monthly: </h3>
                            <h3> 50%</h3>
                        </div>

                    </div>
                    
                    <div class="deposit">
                    

    <form method="post" id="bronzeplanForm">

        <input type="text" value="Bronze" name="BronzepackageName" hidden readonly>
        <button type="submit" id="bronzeplanbtn" data-plan="Bronze Plan" name="BronzeButton">Choose Plan</button>
    </form>
    
</div>




                </div>

            </div>

        </div>

        
        `;

            // Get the main content element
            const mainContent = document.querySelector('main');

            // Replace the HTML content of the main content element with the new code
            mainContent.innerHTML = newCode;

            function handleGoldFormSubmission(event) {
                event.preventDefault(); // Prevent the default form submission behavior

                let form = event.target;
                let formData = new FormData(form);
                formData.append('GoldButton', true);

                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Handle the successful response here (if needed)
                            console.log(xhr.responseText);
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);


                        } else {
                            // Handle the error response here (if needed)
                            console.log("Error");
                        }
                    }
                };

                // Set up the AJAX request with the method, URL, and data
                xhr.open('POST', './set_plan.php', true);

                // Send the request with the form data
                xhr.send(formData);
            }



            // Add the event listener to the form's submit event
            let goldPlanForm = document.getElementById('goldPlanForm');
            goldPlanForm.addEventListener('submit', handleGoldFormSubmission);

            function handleSilverFormSubmission(event) {
                event.preventDefault(); // Prevent the default form submission behavior

                let form = event.target;
                let formData = new FormData(form);
                formData.append('SilverButton', true);

                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Handle the successful response here (if needed)
                            console.log(xhr.responseText);
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);


                        } else {
                            // Handle the error response here (if needed)
                            console.log("Error");

                        }
                    }
                };

                // Set up the AJAX request with the method, URL, and data
                xhr.open('POST', './set_plan.php', true);

                // Send the request with the form data
                xhr.send(formData);
            }



            // Add the event listener to the form's submit event
            let silverPlanForm = document.getElementById('silverPlanForm');
            silverPlanForm.addEventListener('submit', handleSilverFormSubmission);


            function handleBronzeFormSubmission(event) {
                event.preventDefault(); // Prevent the default form submission behavior

                let form = event.target;
                let formData = new FormData(form);
                formData.append('BronzeButton', true);

                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Handle the successful response here (if needed)
                            console.log(xhr.responseText);
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);


                        } else {
                            // Handle the error response here (if needed)
                            console.log("Error");

                        }
                    }
                };

                // Set up the AJAX request with the method, URL, and data
                xhr.open('POST', './set_plan.php', true);

                // Send the request with the form data
                xhr.send(formData);
            }



            // Add the event listener to the form's submit event
            let bronzePlanForm = document.getElementById('bronzeplanForm');
            bronzePlanForm.addEventListener('submit', handleBronzeFormSubmission);


            setupPlanButtons();
        });

        function setupPlanButtons() {
            // Get the "Choose Plan" buttons
            const goldPlanBtn = document.getElementById('goldplanbtn');
            const silverPlanBtn = document.getElementById('silverplanbtn');
            const bronzePlanBtn = document.getElementById('bronzeplanbtn');

            // Add click event listeners to the buttons
            goldPlanBtn.addEventListener('click', function() {
                // Call the function to display the alert message with the chosen plan
                showAlertMessage('Gold Plan');
            });

            silverPlanBtn.addEventListener('click', function() {
                // Call the function to display the alert message with the chosen plan
                showAlertMessage('Silver Plan');
            });

            bronzePlanBtn.addEventListener('click', function() {
                // Call the function to display the alert message with the chosen plan
                showAlertMessage('Bronze Plan');
            });
        }

        function showAlertMessage(plan) {
            alert('You have chosen the ' + plan + '.'); // Modify the alert message as per your requirement
        }

        // Call the function to set up the click event listeners for the "Choose Plan" buttons
        setupPlanButtons();

        // Function to handle form submission and send data via AJAX
    </script>
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
                        <p>Total Approved Investments</p>
                    </span>
                </li>
                <li><i class='bx bx-dollar-circle'></i>
                    <span class="info">
                        <h3>
                           <?php echo "Ksh. " . $total_ProfitsInvested; ?>
                        </h3>
                        <p>Total Profit</p>
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
                        <?php require('./Account_Balance.php');
                        echo 'Ksh. ' . $ACCOUNTBALANCEAVAILABLE; ?>
                        </h3>
                        <p>Account Balance</p>
                    </span>
                </li>
            </ul>
            <!-- End of Insights -->

           
            <div class="bottom-data">
            <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Recent Investments</h3>
                        
                    </div>
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
                    <!-- <div class="tableContainer"> -->
                    <table>
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Package</th>
                                <th>Accumulative</th>
                            </tr>
                        </thead>

                        <tbody id="paginationContent">
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

                            if ($resultingDetails2->num_rows > 0) {
                                while ($rowDetails = $resultingDetails2->fetch_assoc()) {
                                    // Generate the table rows here
                                    echo '<tr>';
                                    echo '<td>' . $rowDetails['Amount'] . '</td>';
                                    echo '<td>' . $rowDetails['Date'] . '</td>';
                                    echo '<td>' . $rowDetails['Status'] . '</td>';
                                    echo '<td>' . $rowDetails['Package'] . '</td>';
                                    echo '<td>' . ($rowDetails['Amount'] + $rowDetails['Accumulative_Amount']) . '</td>';
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
                    $countPackagesGold = "SELECT COUNT(Package) AS GOLDCOUNTS FROM investments WHERE Email_Address = ? AND Package = ?";
                    $countPackage_stmtGold = $mysqli->prepare($countPackagesGold);
                    $countPackage_stmtGold->bind_param('ss', $email, $packageTest_Gold);
                    $countPackage_stmtGold->execute();
                    $resulting_countGold_package = $countPackage_stmtGold->get_result();
                    if ($resulting_countGold_package->num_rows > 0) {
                        $rowPackage_count = $resulting_countGold_package->fetch_assoc();
                        $TotalGoldCounts = intval($rowPackage_count['GOLDCOUNTS']);
                    }

                    // Count for Silver Package
                    $TotalSilverCounts = 0;
                    $packageTest_Silver = 'Silver Package';
                    $countPackagesSilver = "SELECT COUNT(Package) AS SILVERCOUNTS FROM investments WHERE Email_Address = ? AND Package = ?";
                    $countPackage_stmtSilver = $mysqli->prepare($countPackagesSilver);
                    $countPackage_stmtSilver->bind_param('ss', $email, $packageTest_Silver);
                    $countPackage_stmtSilver->execute();
                    $resulting_countSilver_package = $countPackage_stmtSilver->get_result();
                    if ($resulting_countSilver_package->num_rows > 0) {
                        $rowPackage_count = $resulting_countSilver_package->fetch_assoc();
                        $TotalSilverCounts = intval($rowPackage_count['SILVERCOUNTS']);
                    }

                    // Count for Bronze Package
                    $TotalBronzeCounts = 0;
                    $packageTest_Bronze = 'Bronze Package';
                    $countPackagesBronze = "SELECT COUNT(Package) AS BRONZECOUNTS FROM investments WHERE Email_Address = ? AND Package = ?";
                    $countPackage_stmtBronze = $mysqli->prepare($countPackagesBronze);
                    $countPackage_stmtBronze->bind_param('ss', $email, $packageTest_Bronze);
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

    
    `;
            const mainContent = document.querySelector('main');
            mainContent.innerHTML = Dashboard;
        });
    </script>

    <script>
        // Get the "Change plan" list item
        const settingsItem = document.querySelector('.side-menu li:nth-child(7)');

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
                    <h1>Settings</h1>
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

        <div class="flex">
            <h4>Account balance</h4>
            <h4> <?php require('./Account_Balance.php');
                    echo 'Ksh. ' . $ACCOUNTBALANCEAVAILABLE; ?></h4>
        </div>

        <div class="flex">
            <h4>Refferer</h4>
            <h4 >
            <?php
            echo $Refferer;
            ?>
            </h4>
        </div>
        <div class="flex">
            <h4>Date Joined</h4>
            <h4>
            <?php
            echo $joined;
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
                    <h1>Transaction</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Transact
                            </a></li>
                        /
                        <li><a href="#" class="active">Funds</a></li>
                    </ul>
                </div>
                <a href="mailto:finvestiateam@gmail.com" class="report">
                    <i class='bx bx-envelope'></i>
                    <span>Send a Message</span>
                </a>
            </div>
        
            <div class="depositWithdraw">
            <div class="main-block">
            <h2 style="color:var(--secondary); font-weight:bolder; text-align:center;">The Deposit Request Form</h2>
            <div class="fleximg">
            <img src="./images/mpesa.png" alt="not available">
           
            <p>Pay to:<br></br><?php echo $payTo; ?></p>
            </div>

            <p style="margin:0 20px 10px 20px; color:silver !important; font-weight:bolder;">welcome to the request deposit form. Here you are allowed to request a deposit first before sending any money so that the administrator can issue you an account to deposit the funds. Upon depositing, you are therefore urged to remain calm for an hour for your payments to reflect on your End. Happy Investing.</p>

            <div class="transactForm">
                <form id="requestdeposit" method="POST">
                    <input type="submit" id="request" name="request" value="Request a deposit">
                </form>
                
            </div>
            <p style="margin-left:20px; color:green;" id="requestresult"></p>

            </div>

            <div class="main-block">

            <h1 style="font-size: 1rem !important; text-align: center; color: var(--secondary);">Confirm my deposits</h1>
            <form id="transactForm" method="POST">
                <hr>
                <input type="text" name="transactionID" id="transactionID" placeholder="TransactionID" required />
                <input type="number" name="phone" id="phone" placeholder="My Phone Number" required />
                <input type="number" name="amount" id="amount" placeholder="Amount I Paid" required />
                <input type="Date" name="date" id="date" placeholder="Date" required />
                <input type="password" name="pass" id="pass" placeholder="Password" required />
                <hr>

                <div class="btn-block">
                <p style="color: var(--dark);">By clicking Confirm, you agree on our <a href=https://www.finvestia.co.ke/policy.php" style="color: green;">Privacy Policy for finVestia</a>.</p>
                <button type="button" id="transactBtn22" name="transactBtn2">Confirm Now</button>
                </div>
                <p id="trans_result" style="color:green;"></p>
            </form>
            </div>

            
            
            <div class="main-block" >
            
            <h2 style="color:var(--secondary); font-weight:bolder; text-align:center;">The Withdrawal Request Form</h2>
            <div class="fleximg">
            <img src="./images/mpesa.png" alt="not available">
            
             <p>Recieve From:<br>
             <?php
                $recieveFrom11 = 0;
                $emailaddress = $_SESSION['LOGGED_IN_EMAIL'];
                $usernam = $_SESSION['LOGGED_IN_USERNAME'];
                $recieveFrom11Query = "SELECT * FROM requestedwithdrawals WHERE Email_Address = ? AND User_Name = ?";
                $recieveFrom11Query_stmt = $mysqli->prepare($recieveFrom11Query);
                $recieveFrom11Query_stmt->bind_param('ss', $emailaddress, $usernam);
                $recieveFrom11Query_stmt->execute();
                $resultingrecieveFrom11 = $recieveFrom11Query_stmt->get_result();
                if ($resultingrecieveFrom11->num_rows > 0) {
                    $resultingrecieveFrom11_res = $resultingrecieveFrom11->fetch_assoc();
                    $recieveFrom11 = $resultingrecieveFrom11_res['Recieve_From'];
                } else {
                    $recieveFrom11 = 'will appear';
                }
                echo $recieveFrom11;
                ?></br></p>
            </div>

            <p style="margin:0 20px 10px 20px; color:silver !important; font-weight:bolder;">This is the withdrawal request form. Please enter the amount to withdraw in the field below and request. A number to recieve amount from will be generated to you. After which you'll have to confirm the withdrawal. Congratulations!</p>


            <div class="transactForm">
                <form id="requestWithdrawal" method="POST">
                <input type="number" name="withdrawal" id="withdrawal" placeholder="Amount to withdraw" required />
                <input type="submit" id="requestWithdraw" name="requestWithdraw" value="Request Withdrawal">
                </form>
                
            </div>
            <p style="margin-left:20px; color:green;" id="withdrawResult"></p>

            </div>

            <div class="main-block">

            <h1 style="font-size: 1rem !important; text-align: center; color: var(--secondary);">Confirm my Withdrawals</h1>
            <form id="transactForm" method="POST">
                <hr>
                <input type="text" name="withdrawalID" id="withdrawalID" placeholder="TransactionID" required />
                <input type="number" name="recievedfrom" id="recievedfrom" placeholder="Phone Recieved From" required />
                <input type="number" name="withdrawalamount" id="withdrawalamount" placeholder="Amount Recieved" required />
                <input type="Date" name="withdrawalDate1" id="withdrawalDate1" placeholder="withdrawalDate" required />
                <input type="time" name="withdrawaltime1" id="withdrawaltime1" placeholder="withdrawaltime" required />
                <input type="password" name="password1" id="password1" placeholder="My Password" required />
                <hr>

                <div class="btn-block">
                <p style="color: var(--dark);">By clicking Recived, you agree on our <a href="https://www.finvestia.co.ke/policy.php" style="color: green;">Privacy Policy for finVestia</a>.</p>
                <button type="button" id="recievedButton" name="recievedButton">Recieved</button>
                </div>
                <p id="recievedResultsWithdrawals" style="color:green;"></p>
            </form>
            </div>


            </div>

                <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Recent Deposits</h3>

                    </div>
                    <?php

                    $deposistRecordsPerPage = 5;

                    // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                    // Calculate the offset for pagination
                    $depositsOffset = ($current_page - 1) * $deposistRecordsPerPage;

                    $depositsQuery = "SELECT * FROM deposits WHERE Email_Address = ? ORDER BY Date DESC LIMIT ? OFFSET ?";
                    $depositsQuery_stmt = $mysqli->prepare($depositsQuery);
                    $depositsQuery_stmt->bind_param('sii', $email, $deposistRecordsPerPage, $depositsOffset);
                    $depositsQuery_stmt->execute();
                    $resultingDepositsStatements1 = $depositsQuery_stmt->get_result();


                    // Get the total number of records for pagination
                    $countDeposits = "SELECT COUNT(*) as total FROM deposits WHERE Email_Address = ?";
                    $countDeposits_stmt = $mysqli->prepare($countDeposits);
                    $countDeposits_stmt->bind_param('s', $email);
                    $countDeposits_stmt->execute();
                    $resultCountDepsoits = $countDeposits_stmt->get_result();
                    $rowDeposits = $resultCountDepsoits->fetch_assoc();
                    $totalRecords = $rowDeposits['total'];

                    // Calculate the total number of pages
                    $depositsTotalPagesAvailable = ceil($totalRecords / $deposistRecordsPerPage);

                    // Output the pagination links
                    // for ($i = 1; $i <= $depositsTotalPagesAvailable; $i++) {
                    //     echo '<a href="#" onclick="handlePaginationClick(' . $i . ')">' . $i . '</a>';
                    // }

                    ?>
                    <!-- <div class="tableContainer"> -->
                    <table>
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Date</th>
                                
                            </tr>
                        </thead>

                        <tbody id="paginationContent">
                            <?php

                            $deposistRecordsPerPage = 5;

                            // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                            $currentDepositsPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

                            // Calculate the offset for pagination
                            $depositsOffset = ($currentDepositsPage - 1) * $deposistRecordsPerPage;

                            $deposits = "SELECT * FROM deposits WHERE Email_Address = ? ORDER BY Date DESC LIMIT ? OFFSET ?";
                            $depositsStatements = $mysqli->prepare($deposits);
                            $depositsStatements->bind_param('sii', $email, $deposistRecordsPerPage, $depositsOffset);
                            $depositsStatements->execute();
                            $resultingDepositsStatements = $depositsStatements->get_result();

                            if ($resultingDepositsStatements->num_rows > 0) {
                                while ($RowDepositsStatements = $resultingDepositsStatements->fetch_assoc()) {
                                    // Generate the table rows here
                                    echo '<tr>';
                                    echo '<td>' . $RowDepositsStatements['TransactionID'] . '</td>';
                                    echo '<td>' . $RowDepositsStatements['Amount'] . '</td>';
                                    echo '<td>' . $RowDepositsStatements['Date'] . '</td>';
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
                    if ($depositsTotalPagesAvailable > 0) {
                        // Add navigation arrows
                        $prevPage = $currentDepositsPage - 1;
                        $nextPage = $currentDepositsPage + 1;
                        if ($prevPage >= 1) {
                    ?>
                            <a href="?page=<?php echo $prevPage; ?>">
                                << <!-- Previous page arrow -->
                            </a>
                        <?php
                        }
                        if ($nextPage <= $depositsTotalPagesAvailable) {
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
                        <h3>Recent Withdrawals</h3>

                    </div>
                    <?php

                    $deposistRecordsPerPage = 5;

                    // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                    // Calculate the offset for pagination
                    $withdrawalsOffset = ($current_page - 1) * $deposistRecordsPerPage;

                    $withdrawalsQuery = "SELECT * FROM withdrawals WHERE Email_Address = ? ORDER BY Date DESC LIMIT ? OFFSET ?";
                    $withdrawalsQuery_stmt = $mysqli->prepare($withdrawalsQuery);
                    $withdrawalsQuery_stmt->bind_param('sii', $email, $deposistRecordsPerPage, $withdrawalsOffset);
                    $withdrawalsQuery_stmt->execute();
                    $resultingwithdrawalsStatements1 = $withdrawalsQuery_stmt->get_result();


                    // Get the total number of records for pagination
                    $countwithdrawals = "SELECT COUNT(*) as total FROM withdrawals WHERE Email_Address = ?";
                    $countwithdrawals_stmt = $mysqli->prepare($countwithdrawals);
                    $countwithdrawals_stmt->bind_param('s', $email);
                    $countwithdrawals_stmt->execute();
                    $resultCountDepsoits = $countwithdrawals_stmt->get_result();
                    $rowwithdrawals = $resultCountDepsoits->fetch_assoc();
                    $totalRecords = $rowwithdrawals['total'];

                    // Calculate the total number of pages
                    $withdrawalsTotalPagesAvailable = ceil($totalRecords / $deposistRecordsPerPage);

                    // Output the pagination links
                    // for ($i = 1; $i <= $withdrawalsTotalPagesAvailable; $i++) {
                    //     echo '<a href="#" onclick="handlePaginationClick(' . $i . ')">' . $i . '</a>';
                    // }

                    ?>
                    <!-- <div class="tableContainer"> -->
                    <table>
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Date</th>
                                
                            </tr>
                        </thead>

                        <tbody id="paginationContent">
                            <?php

                            $deposistRecordsPerPage = 5;

                            // Determine the current page number (use $_GET or $_POST, depending on how you are passing the page number)
                            $currentwithdrawalsPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

                            // Calculate the offset for pagination
                            $withdrawalsOffset = ($currentwithdrawalsPage - 1) * $deposistRecordsPerPage;

                            $withdrawals = "SELECT * FROM withdrawals WHERE Email_Address = ? ORDER BY Date DESC LIMIT ? OFFSET ?";
                            $withdrawalsStatements = $mysqli->prepare($withdrawals);
                            $withdrawalsStatements->bind_param('sii', $email, $deposistRecordsPerPage, $withdrawalsOffset);
                            $withdrawalsStatements->execute();
                            $resultingwithdrawalsStatements = $withdrawalsStatements->get_result();

                            if ($resultingwithdrawalsStatements->num_rows > 0) {
                                while ($RowwithdrawalsStatements = $resultingwithdrawalsStatements->fetch_assoc()) {
                                    // Generate the table rows here
                                    echo '<tr>';
                                    echo '<td>' . $RowwithdrawalsStatements['TransactionID'] . '</td>';
                                    echo '<td>' . $RowwithdrawalsStatements['Amount'] . '</td>';
                                    echo '<td>' . $RowwithdrawalsStatements['Date'] . '</td>';
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
                    if ($withdrawalsTotalPagesAvailable > 0) {
                        // Add navigation arrows
                        $prevPage = $currentwithdrawalsPage - 1;
                        $nextPage = $currentwithdrawalsPage + 1;
                        if ($prevPage >= 1) {
                    ?>
                            <a href="?page=<?php echo $prevPage; ?>">
                                << <!-- Previous page arrow -->
                            </a>
                        <?php
                        }
                        if ($nextPage <= $withdrawalsTotalPagesAvailable) {
                        ?>
                            <a href="?page=<?php echo $nextPage; ?>">
                                >> <!-- Next page arrow -->
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>









            `;
            const mainContent = document.querySelector('main');
            mainContent.innerHTML = transactions;


            const requstbtn = document.getElementById('request');
            let requestresult = document.getElementById('requestresult');

            requstbtn.addEventListener('click', function(e) {
                // Get the form data
                e.preventDefault();
                // form = event.target;
                const formData = new FormData();
                formData.append('request', true);

                // Create an XMLHttpRequest object
                const xhr = new XMLHttpRequest();

                // Configure the AJAX request
                xhr.open('POST', './request.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                // Set up the event listener to handle the response
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Request successful, handle the response here
                            const response = JSON.parse(xhr.responseText);
                            requestresult.innerHTML = response.message; // Access the 'message' property

                        } else {
                            // Request failed, handle errors here
                            console.error('Error:', xhr.status, xhr.statusText);
                            requestresult.innerHTML = "Error occurred while processing the request.";
                        }
                    }
                };

                // Send the AJAX request with the form data
                xhr.send(formData);
            });










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
                formData.append('date', document.getElementById('date').value);
                formData.append('pass', document.getElementById('pass').value);


                // Create an XMLHttpRequest object
                const xhr = new XMLHttpRequest();

                // Configure the AJAX request
                xhr.open('POST', './verify_Deposits.php', true);
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


            // ===========request withdrawals
            const requestWithdraw = document.getElementById('requestWithdraw');
            let withdrawResult = document.getElementById('withdrawResult');

            requestWithdraw.addEventListener('click', function(e) {
                // Get the form data
                e.preventDefault();
                // form = event.target;
                const formData = new FormData();
                formData.append('requestWithdraw', true);
                formData.append('withdrawal', document.getElementById('withdrawal').value);

                // Create an XMLHttpRequest object
                const xhr = new XMLHttpRequest();

                // Configure the AJAX request
                xhr.open('POST', './withdrawRequest.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                // Set up the event listener to handle the response
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Request successful, handle the response here
                            const response = JSON.parse(xhr.responseText);
                            withdrawResult.innerHTML = response.message; // Access the 'message' property

                        } else {
                            // Request failed, handle errors here
                            console.error('Error:', xhr.status, xhr.statusText);
                            withdrawResult.innerHTML = "Error occurred while processing the request.";
                        }
                    }
                };

                // Send the AJAX request with the form data
                xhr.send(formData);
            });


            const recievedButton = document.getElementById('recievedButton');
            let recievedResultsWithdrawals = document.getElementById('recievedResultsWithdrawals');

            recievedButton.addEventListener('click', function() {
                // Get the form data
                // form = event.target;
                const formData = new FormData();
                formData.append('recievedButton', true);
                formData.append('withdrawalID', document.getElementById('withdrawalID').value);
                formData.append('recievedfrom', document.getElementById('recievedfrom').value);
                formData.append('withdrawalamount', document.getElementById('withdrawalamount').value);
                formData.append('withdrawalDate1', document.getElementById('withdrawalDate1').value);
                formData.append('withdrawaltime1', document.getElementById('withdrawaltime1').value);
                formData.append('password1', document.getElementById('password1').value);


                // Create an XMLHttpRequest object
                const xhr = new XMLHttpRequest();

                // Configure the AJAX request
                xhr.open('POST', './verify_withdrawals.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                // Set up the event listener to handle the response
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Request successful, handle the response here
                            const response = JSON.parse(xhr.responseText);
                            recievedResultsWithdrawals.innerHTML = response.message; // Access the 'message' property

                        } else {
                            // Request failed, handle errors here
                            console.error('Error:', xhr.status, xhr.statusText);
                            recievedResultsWithdrawals.innerHTML = "Error occurred while processing the request.";
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

            $myReferals = 0;
            $packageName = '';
            $user_name = $_SESSION['LOGGED_IN_USERNAME'];
            $no_OF_Refferals = "SELECT COUNT(*) AS REFFERALS_COUNT FROM profitedge_users WHERE Refferer = ?";
            $refferals_count_stmt = $mysqli->prepare($no_OF_Refferals);
            $refferals_count_stmt->bind_param('s', $user_name);
            $refferals_count_stmt->execute();
            $resultingRefferals = $refferals_count_stmt->get_result();
            if ($resultingRefferals->num_rows > 0) {
                $rowRefferals = $resultingRefferals->fetch_assoc();
                $myReferals = intval($rowRefferals['REFFERALS_COUNT']);
            } else {
                $myReferals = 0;
            }
            $refferalEarnings = $myReferals * 50;


            ?>
            <?php
            $packageName = '';
            $package = "SELECT Package FROM set_plan WHERE Email_Address = ?";
            $package_stmt = $mysqli->prepare($package);
            $package_stmt->bind_param('s', $email);
            $package_stmt->execute();
            $resultingPackage = $package_stmt->get_result();
            if ($resultingPackage->num_rows > 0) {
                $rowPackage = $resultingPackage->fetch_assoc();
                $packageName = $rowPackage['Package'];
            } else {
                $packageName = 'None';
            }
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
                        <?php echo "Ksh. " . $refferalEarnings; ?>
                        </h3>
                        <p>Refferal Earnings</p>
                    </span>
                </li>
                <li><i class='bx bx-medal'></i>
                    <span class="info">
                        <h3>
                            <?php echo $packageName; ?>
                        </h3>
                        <p>Active Package</p>
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
                        <?php require('./Account_Balance.php');
                        echo 'Ksh. ' . $ACCOUNTBALANCEAVAILABLE; ?>
                        </h3>
                        <p>Total Balance</p>
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
                <h2>Choose Your Phone Number</h2>
                <p>Be sure to change your Number anytime for a succesfull transaction.</p>
                <form method="post" class="wallet_form">
                <img src="./images/mpesa.png" alt="not found">
                <p id="setphone_response" style="font-size:.8rem; font-weight:bolder; text-align:center;"></p>
                <input type="number" name="phoneNumber" placeholder="Enter Phone No" class="inputs" autocomplete="off" required>
                <input type="password" placeholder="Password" name="password" class="inputs" required>
                <input type="submit" value="set Phone Number" name="changephoneno">
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
                xhr.open("POST", "./wallet.php", true);
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
                    <h1>Reffer</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Refferals
                            </a></li>
                        /
                        <li><a href="#" class="active">share</a></li>
                    </ul>
                </div>
                <a href="mailto:finvestiateam@gmail.com" class="report">
                    <i class='bx bx-envelope'></i>
                    <span>Send a Message</span>
                </a>
            </div>
            <div class="cover">
<div class="box">
    <div class="ellipse">
        <p>Reffer A Friend Today And Earn Ksh. 50 From Each</p>
        </div>
        <div class="flex_Ellipse">
        <img src="./images/boy.png" alt="boy"/>

    <div>
    <?php

    $QueryUsername = "SELECT User_Name FROM  profitedge_users
                                 WHERE Email_Address = ?;";
    $stmt5 = $mysqli->prepare($QueryUsername);
    $stmt5->bind_param('s', $email);
    $stmt5->execute();
    $userNameResults = $stmt5->get_result();

    if ($userNameResults->num_rows === 1) {
        $row_user = $userNameResults->fetch_assoc();
        $usernameAvail = $row_user['User_Name'];
        $userNameResults->free();
    }
    $baseURL = "https://www.finvestia.co.ke/Register.php";
    $Refferal_Link = $baseURL . '?ref=' . urlencode($usernameAvail);
    ?>
    <input type="hidden" id="refferal_link" value="<?php echo htmlspecialchars($Refferal_Link); ?>">
    <h6>referal code </h6>
    <h2 style="color:var(--dark);"><?php echo htmlspecialchars($usernameAvail); ?></h2>
        </div>
    </div>
        
        <button onclick="copyContent()">Copy Your Refferal Link</button>
</div>
<div class="refferalHistory">
<table id="downlinetable">
<caption>Your Downlines</caption>
<thead>
<tr>
<th>UserName</th>
<th>Date Joined</th>
<th>Phone</th>
</tr>
</thead>
<tbody>
<?php
$user = $_SESSION['LOGGED_IN_USERNAME'];
$downlines = "SELECT * FROM profitedge_users WHERE Refferer = ?";
$stmt6 = $mysqli->prepare($downlines);
$stmt6->bind_param('s', $user);
$stmt6->execute();
$resultingName = $stmt6->get_result();

if ($resultingName->num_rows > 0) {
    while ($rowDownlines = $resultingName->fetch_assoc()) {
        $downlineUserName = $rowDownlines['User_Name'];
        $downlineDate_joined = $rowDownlines['Joining_Day'];
        $downline_phone = $rowDownlines['Phone_No'];
?>
    <tr>
        <td><?php echo $downlineUserName; ?></td>
        <td><?php echo $downlineDate_joined; ?></td>
        <td><?php echo $downline_phone; ?></td>
    </tr>
<?php
    }
} else {
    // If there are no records, display a single row with "No records"
?>
    <tr>
        <td colspan="3">No records</td>
    </tr>
<?php
}
?>
</tbody>

</table>
</div>
</div>
        `;


            const mainContent = document.querySelector('main');
            mainContent.innerHTML = refferal;




        });

        function copyContent() {
            const element2 = document.querySelector("#refferal_link");

            if (navigator.clipboard) {
                navigator.clipboard.writeText(element2.value)
                    .then(() => {
                        alert("Referral Link Copied!");
                    })
                    .catch(error => {
                        console.error("Error copying to clipboard:", error);
                    });
            } else {
                // Fallback code for browsers that do not support Clipboard API
                let tempInput = document.createElement("input");
                tempInput.setAttribute("type", "text");
                tempInput.setAttribute("value", element2.value);
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                alert("Referral Link Copied!");
            }
        }
    </script>

    <script>
        // Get the "Change plan" list item
        const letsInvestItem = document.querySelector('.side-menu li:nth-child(6)');

        // Add a click event listener to the "Change plan" list item
        letsInvestItem.addEventListener('click', function(event) {
            // Prevent the default link behavior
            event.preventDefault();
            const letsInvest = `
            <div class="header">
                <div class="left">
                    <h1>Invest Today</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Investor
                            </a></li>
                        /
                        <li><a href="#" class="active">Invest</a></li>
                    </ul>
                </div>
                <a href="mailto:finvestiateam@gmail.com" class="report">
                    <i class='bx bx-envelope'></i>
                    <span>Send a Message</span>
                </a>
            </div>
        
        <div class="invest_funds">
        <div class="planInvest" id="gold_Plan">
        <h2>Invest With Gold Plan Today</h2>

            <div class="gold_Plan" >
                <div class="left_plan">
                    <p>When choosing the Gold Plan at the Plans tab, users will have access to a luxurious and exclusive investment opportunity. Investing with the Gold Plan is available in three flexible parts, with durations of 8 days, 14 days, and 21 days. Each part offers substantial returns, with rates of 30%, 50%, and 80% respectively, promising an excellent chance to grow their wealth. Don't miss out on this golden opportunity for high-yield investments!
                       </p>
                </div>
                <div class="right_plan">
                <p style="text-align:center; font-weight:bolder; font-size:.8rem;" id="Investmentresponse"></p>
                <form action="" method="post" id="gold_Plan_form">
                    <input type="number" name="gold_amount" placeholder="Amount" autocomplete="off" id="gold_amount" required>
                    <input type="text" name="gold_package" value="Gold Package" autocomplete="off" required readonly>
                    <select name="gold_selectDays" id="gold_selectDays">
                        <option value="8">Eight Days - 30%</option>
                        <option value="14">Fourteen Days - 50%</option>
                        <option value="21">Twenty One Days - 80%</option>
                    </select>
                    <input type="number" value="" readonly id="gold_accumulative" placeholder="This is the accumulative Amount" name="gold_accumulative">

                    <div class="check">
                        <input type="checkbox" name="check1" value="" id="check1" required>
                        <label for="check1">Confirm Investment</label>
                    </div>
                    <input type="submit" name="investGoldNow" value="Invest Now">
                </form>
                </div>
            </div>

        </div>

        <!--  -->
        <div class="planInvest" id="silver_Plan">
            <h2>Invest With Silver Plan Today</h2>
            <div class="silver_Plan" >

                <div class="left_plan">
                    <p>Introducing the Silver Fortune Plan, designed for investors seeking elevated opportunities. Elevate your portfolio with the Premium Silver Investment Package, offering three investment durations: 8 days, 14 days, and 21 days. Experience the power of balanced returns, with rates of 20%, 35%, and 60% respectively. Let your investments shine with the Shining Silver Package and embrace a path to success. Don't miss out on the Silver Harvest - choose the Silver Path to Success today!
                       </p>
                </div>
                <div class="right_plan">
                <p style="text-align:center; font-weight:bolder; font-size:.8rem;" id="silverResponseText"></p>
                <form action="" method="post" id="silver_Plan_form">
                    <input type="number" name="silver_amount" placeholder="Amount" autocomplete="off" id="silver_amount" required>
                    <input type="text" name="silver_package" value="Silver Package" autocomplete="off" required readonly>
                    <select name="silver_selectDays" id="silver_selectDays">
                    <option value="8">Eight Days - 20%</option>
                    <option value="14">Forteen Days - 35%</option>
                    <option value="21">Twenty One Days - 60% </option>
                    </select>
                    <input type="number" value="" readonly id="silver_accumulative" name="silver_accumulative" placeholder="This is the accumulative Amount">

                    <div class="check">
                    <input type="checkbox" name="check2" value="" id="check2">
                    <label for="check2">Confirm Investment</label>
                    </div>
                    <input type="submit" name="investSilver" value="Invest Now">
                </form>
</div>


            </div>
        </div>
        <!--  -->

        <div class="planInvest" id="bronze_Plan">
            <h2>Invest With Bronze Plan Today</h2>
            <div class="bronze_Plan" >

                <div class="left_plan">
                    <p>Discover the Bronze Boost Plan, a fantastic opportunity for new investors to start their journey. With a focus on essential growth, this investment package is tailored for beginners. The Bronze Plan offers three different investment durations: 8 days, 14 days, and 21 days. Embrace the potential to earn attractive returns, with rates of 16%, 30%, and 50% respectively. Don't underestimate the power of the Bronze Package in unveiling your investment potential. Choose the Bronze Pathway to Profits today!
                        </p>
                </div>
                <div class="right_plan">
                <p style="text-align:center; font-weight:bolder; font-size:.8rem;" id="bronzeResponseText"></p>
                    <form action="" method="post" id="bronze_Plan_form">
                        <input type="number" name="bronze_amount" placeholder="Amount" autocomplete="off" id="bronze_amount" required>
                        <input type="text"  name="bronze_package" value="Bronze Package" autocomplete="off" required readonly>
                        <select name="bronze_selectDays" id="bronze_selectDays">
                            <option value="8">Eight Days - 16%</option>
                            <option value="14">Forteen Days - 30%</option>
                            <option value="21">Twenty One Days - 50%</option>
                        </select>
                        <input type="number" value="" readonly id="bronze_accumulative" name="bronze_accumulative" placeholder="This is the accumulative Amount">

                        <div class="check">
                            <input type="checkbox" name="check3" value="" id="check3">
                            <label for="check3">Confirm Investment</label>
                        </div>
                        <input type="submit" name="investBronze" value="Invest Now">
                    </form>

                </div>


            </div>

        </div>
        `;

            const mainContent = document.querySelector('main');
            mainContent.innerHTML = letsInvest;
            var packageName = '<?php echo $packageName; ?>';
            // Function to disable the form elements
            function disableFormElements(form) {
                var elements = form.elements;
                for (var i = 0; i < elements.length; i++) {
                    elements[i].disabled = true;
                }
            }

            // Function to enable the form elements
            function enableFormElements(form) {
                var elements = form.elements;
                for (var i = 0; i < elements.length; i++) {
                    elements[i].disabled = false;
                }
            }

            // Get the form elements
            var bronzePlanForm = document.getElementById('bronze_Plan_form');
            var silverPlanForm = document.getElementById('silver_Plan_form');
            var goldPlanForm = document.getElementById('gold_Plan_form');

            // Disable or enable the form elements based on the package
            if (packageName === 'Bronze') {
                disableFormElements(silverPlanForm);
                disableFormElements(goldPlanForm);
            } else if (packageName === 'Silver') {
                disableFormElements(bronzePlanForm);
                disableFormElements(goldPlanForm);
            } else if (packageName === 'Gold') {
                disableFormElements(bronzePlanForm);
                disableFormElements(silverPlanForm);
            } else {
                // If the package is not Bronze, Silver, or Gold, handle it accordingly
                // For example, show a default message or hide all features
                disableFormElements(bronzePlanForm);
                disableFormElements(silverPlanForm);
                disableFormElements(goldPlanForm);
            }
            // ===============gold begins============
            const goldAmountInput = document.getElementById('gold_amount');
            const goldSelectDays = document.getElementById('gold_selectDays');
            const accumulativeInput = document.getElementById('gold_accumulative');

            // Add event listeners to the gold_amount and gold_selectDays inputs
            goldAmountInput.addEventListener('input', calculateAccumulative);
            goldSelectDays.addEventListener('change', calculateAccumulative);

            // Function to calculate and update the accumulative field
            function calculateAccumulative() {
                const goldAmount = parseFloat(goldAmountInput.value);
                const selectedDays = parseInt(goldSelectDays.value);

                if (!isNaN(goldAmount)) {
                    let percentage;
                    if (selectedDays === 8) {
                        percentage = 0.3;
                    } else if (selectedDays === 14) {
                        percentage = 0.5;
                    } else if (selectedDays === 21) {
                        percentage = 0.8;
                    } else {
                        percentage = 0; // Default to 0% if none of the above conditions are met
                    }

                    const accumulativeValue = goldAmount * percentage;
                    accumulativeInput.value = accumulativeValue.toFixed(2);
                } else {
                    accumulativeInput.value = '';
                }
            }
            // ==================gold done===================
            // =============silver begins==========
            const silverAmountInput = document.getElementById('silver_amount');
            const silverSelectDays = document.getElementById('silver_selectDays');
            const silverAccumulativeInput = document.getElementById('silver_accumulative');

            // Add event listeners to the silver_amount and silver_selectDays inputs
            silverAmountInput.addEventListener('input', calculateSilverAccumulative);
            silverSelectDays.addEventListener('change', calculateSilverAccumulative);

            // Function to calculate and update the accumulative field for the Silver Plan
            function calculateSilverAccumulative() {
                const silverAmount = parseFloat(silverAmountInput.value);
                const selectedDays = parseInt(silverSelectDays.value);

                if (!isNaN(silverAmount)) {
                    let percentage;
                    if (selectedDays === 8) {
                        percentage = 0.2;
                    } else if (selectedDays === 14) {
                        percentage = 0.35;
                    } else if (selectedDays === 21) {
                        percentage = 0.6;
                    } else {
                        percentage = 0; // Default to 0% if none of the above conditions are met
                    }

                    const accumulativeValue = silverAmount * percentage;
                    silverAccumulativeInput.value = accumulativeValue.toFixed(2);
                } else {
                    silverAccumulativeInput.value = '';
                }
            }
            // ==============silver nds=====================

            // ==================bronze begins=====================
            const bronzeAmountInput = document.getElementById('bronze_amount');
            const bronzeSelectDays = document.getElementById('bronze_selectDays');
            const bronzeAccumulativeInput = document.getElementById('bronze_accumulative');

            // Add event listeners to the silver_amount and silver_selectDays inputs
            bronzeAmountInput.addEventListener('input', calculateBronzeAccumulative);
            bronzeSelectDays.addEventListener('change', calculateBronzeAccumulative);

            // Function to calculate and update the accumulative field for the Silver Plan
            function calculateBronzeAccumulative() {
                const bronzeAmount = parseFloat(bronzeAmountInput.value);
                const selectedDays = parseInt(bronzeSelectDays.value);

                if (!isNaN(bronzeAmount)) {
                    let percentage;
                    if (selectedDays === 8) {
                        percentage = 0.16;
                    } else if (selectedDays === 14) {
                        percentage = 0.3;
                    } else if (selectedDays === 21) {
                        percentage = 0.5;
                    } else {
                        percentage = 0; // Default to 0% if none of the above conditions are met
                    }

                    const accumulativeValue = bronzeAmount * percentage;
                    bronzeAccumulativeInput.value = accumulativeValue.toFixed(2);
                } else {
                    bronzeAccumulativeInput.value = '';
                }
            }
            // =============bronze ends======================

            // Function to handle Gold form submission
            function handleGoldInvest(event) {
                event.preventDefault();
                const form = event.target;
                const formData = new FormData(form);
                formData.append('investGoldNow', true);
                const amountInput = form.querySelector('[name="gold_amount"]');
                const investmentResponse = document.getElementById('Investmentresponse');
                const amount = parseFloat(amountInput.value);
                if (isNaN(amount) || amount < 5000) {
                    investmentResponse.textContent = "Gold Investment must be greater than or equal to Ksh. 5000";
                    investmentResponse.style.color = "red";
                    return;
                }
                const xhr = new XMLHttpRequest();
                xhr.open('POST', './invest.php', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            investmentResponse.textContent = xhr.responseText;
                            investmentResponse.style.color = "green";
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);

                        } else {
                            investmentResponse.textContent = "Something went wrong.";
                            investmentResponse.style.color = "red";
                        }
                    }
                };
                xhr.send(formData);
                console.log("sent");
            }
            const goldForm = document.querySelector('#gold_Plan_form');
            goldForm.addEventListener('submit', handleGoldInvest);

            // Function to handle silver form submission
            function handleSilverInvest(event) {
                event.preventDefault();
                const form = event.target;
                const formData = new FormData(form);
                formData.append('investSilver', true);
                const amountInput = form.querySelector('[name="silver_amount"]');
                const investmentResponse = document.getElementById('silverResponseText');
                const amount = parseFloat(amountInput.value);
                if (isNaN(amount) || amount <= 2000 || amount > 4999) {
                    investmentResponse.textContent = "Silver Investment must be greater than Ksh. 2000 and less than Ksh. 5000";
                    investmentResponse.style.color = "red";

                    return;
                }
                const xhr = new XMLHttpRequest();
                xhr.open('POST', './invest.php', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            investmentResponse.textContent = xhr.responseText;
                            investmentResponse.style.color = "green";
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);

                        } else {
                            investmentResponse.textContent = "Something went wrong.";
                            investmentResponse.style.color = "red";
                        }
                    }
                };
                xhr.send(formData);
                console.log("sent");
            }
            const silverForm = document.querySelector('#silver_Plan_form');
            silverForm.addEventListener('submit', handleSilverInvest);

            // Function to handle bronze form submission
            function handleBronzeInvest(event) {
                event.preventDefault();
                const form = event.target;
                const formData = new FormData(form);
                formData.append('investBronze', true);
                const amountInput = form.querySelector('[name="bronze_amount"]');
                const investmentResponse = document.getElementById('bronzeResponseText');
                const amount = parseFloat(amountInput.value);
                if (isNaN(amount) || amount < 1200 || amount >= 2001) {
                    investmentResponse.textContent = "Bronze Investment must be greater than Ksh. 1200 and less than or equal Ksh. 2000";
                    investmentResponse.style.color = "red";
                    return;
                }
                const xhr = new XMLHttpRequest();
                xhr.open('POST', './invest.php', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            investmentResponse.textContent = xhr.responseText;
                            investmentResponse.style.color = "green";
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);

                        } else {
                            investmentResponse.textContent = "Something went wrong.";
                            investmentResponse.style.color = "red";
                        }
                    }
                };
                xhr.send(formData);
                console.log("sent");
            }
            const bronzeForm = document.querySelector('#bronze_Plan_form');
            bronzeForm.addEventListener('submit', handleBronzeInvest);
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

</body>


</html>
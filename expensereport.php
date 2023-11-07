    <?php
    include("session.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $reportType = $_POST['report_type'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];

        $query = "";
        $tableHeader = '';
        $periodDates = array();

        switch ($reportType) {
            case 'datewise':
                $query = "SELECT DATE(expensedate) AS period, SUM(expense) AS totalExpense FROM expenses WHERE user_id = '$userid' AND expensedate BETWEEN '$startDate' AND '$endDate' GROUP BY period";
                $tableHeader = 'Date';
                $periodDates = generateDateRange($startDate, $endDate);
                break;
            case 'monthwise':
                $query = "SELECT YEAR(expensedate) AS year, MONTH(expensedate) AS month, SUM(expense) AS totalExpense FROM expenses WHERE user_id = '$userid' AND expensedate BETWEEN '$startDate' AND '$endDate' GROUP BY year, month";
                $tableHeader = 'Year-Month';
                $periodDates = generateMonthYearRange($startDate, $endDate);
                break;
            case 'yearwise':
                $query = "SELECT YEAR(expensedate) AS year, SUM(expense) AS totalExpense FROM expenses WHERE user_id = '$userid' AND expensedate BETWEEN '$startDate' AND '$endDate' GROUP BY year";
                $tableHeader = 'Year';
                $periodDates = generateYearRange($startDate, $endDate);
                break;
        }

        if ($query !== "") {
            $exp_fetched = mysqli_query($con, $query);
        }
    }

    function generateDateRange($startDate, $endDate) {
        $dates = array();
        $currentDate = strtotime($startDate);

        while ($currentDate <= strtotime($endDate)) {
            $dates[] = date('Y-m-d', $currentDate);
            $currentDate = strtotime('+1 day', $currentDate);
        }

        return $dates;
    }

    function generateMonthYearRange($startDate, $endDate) {
        $periodDates = array();
        $currentDate = strtotime($startDate);

        while ($currentDate <= strtotime($endDate)) {
            $periodDates[] = date('Y-m', $currentDate);
            $currentDate = strtotime('+1 month', $currentDate);
        }

        return $periodDates;
    }

    function generateYearRange($startDate, $endDate) {
        $periodDates = array();
        $currentDate = strtotime($startDate);

        while ($currentDate <= strtotime($endDate)) {
            $periodDates[] = date('Y', $currentDate);
            $currentDate = strtotime('+1 year', $currentDate);
        }

        return $periodDates;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Expense Manager - Expense Report</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <style>
            .try {
    font-size: 28px; /* Adjust the font size as needed */
    color: #333;    /* Adjust the color as needed */
    padding: 15px 0px 5px 0px;   /* Adjust the padding as needed */
    }
    .text-center {
        text-align: center;
    }

            </style>
    </head>

    <body>
        <div class="d-flex" id="wrapper">
        <div class="border-right" id="sidebar-wrapper">
        <div class="user">
            <img class="img img-fluid rounded-circle" src="uploads\default_profile.png" width="120">
            <h5><?php echo $username ?></h5>
            <p><?php echo $useremail ?></p>
        </div>
        <div class="sidebar-heading">Management</div>
        <div class="list-group list-group-flush">
            <a href="index.php" class="list-group-item list-group-item-action "><span data-feather="home"></span> Dashboard</a>
            <a href="add_expense.php" class="list-group-item list-group-item-action "><span data-feather="plus-square"></span> Add Expenses</a>
            <a href="manage_expense.php" class="list-group-item list-group-item-action "><span data-feather="dollar-sign"></span> Manage Expenses</a>
            <a href="expensereport.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="file-text"></span> Expense Report</a>

        </div>
        <div class="sidebar-heading">Settings </div>
        <div class="list-group list-group-flush">
            <a href="profile.php" class="list-group-item list-group-item-action "><span data-feather="user"></span> Profile</a>
            <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
        </div>
        </div>
        
            <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light  border-bottom">


    <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
    <span data-feather="menu"></span>
    </button>
    <div class="col-md-11 text-center">
    <h2 class="try">Expense Report</h2>
    </div>


    </nav>
                <div class="container-fluid">   
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form method="POST" action="">
                        <div class="form-group row"  style="padding-top: 25px;">
        <label for="report_type" class="col-sm-6 col-form-label"><b>Select Report Type:</b></label>
        <div class="col-md-6">
            <select class="form-control col-sm-12" id="report_type" name="report_type">
                <option value="datewise">Datewise Report</option>
                <option value="monthwise">Monthwise Report</option>
                <option value="yearwise">Yearwise Report</option>
            </select>
        </div>
    </div>


                                <div class="form-group row">
        <label for="start_date" class="col-sm-6 col-form-label"><b>Start Date</b></label>
        <div class="col-md-6">
            <input type="date" class="form-control col-sm-12" value="<?php echo date('Y-m-d'); ?>" name="start_date" id="start_date" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="end_date" class="col-sm-6 col-form-label"><b>End Date</b></label>
        <div class="col-md-6">
            <input type="date" class="form-control col-sm-12" value="<?php echo date('Y-m-d'); ?>" name="end_date" id="end_date" required>
        </div>
    </div>


    <div class="form-group row">
        <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-lg btn-block btn-success" style="border-radius: 0%;">Generate Report</button>
        </div>
    </div>

                            </form>

                            <!-- Display the generated report here -->
                            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($exp_fetched)) {
        echo '<h4 class="mt-4">Generated Report</h4>';
        echo '<table class="table table-hover table-bordered">';
        echo '<thead><tr class="text-center">';
        echo '<th>Sl No.</th>';
        echo '<th>' . $tableHeader . '</th>';
        echo '<th>Total Amount</th></tr></thead>';
        echo '<tbody>';

        $count = 1;
        foreach ($periodDates as $periodDate) {
            mysqli_data_seek($exp_fetched, 0); // Reset fetch pointer
            $totalAmount = 0;

            while ($row = mysqli_fetch_array($exp_fetched)) {
                if ($reportType == 'datewise' && $row['period'] == $periodDate) {
                    $totalAmount = $row['totalExpense'];
                    break;
                }
                
                if ($reportType == 'monthwise' && $row['year'] == substr($periodDate, 0, 4) && $row['month'] == substr($periodDate, 5, 2)) {
                    $totalAmount += $row['totalExpense'];
                }
                
                if ($reportType == 'yearwise' && $row['year'] == $periodDate) {
                    $totalAmount += $row['totalExpense'];
                }
            }

            if ($totalAmount > 0) { // Only display if there's expense for this period
                echo '<tr>';
                echo '<td class="text-center">' . $count . '</td>';
                
                if ($reportType == 'datewise') {
                    echo '<td class="text-center">' . $periodDate . '</td>';
                } elseif ($reportType == 'monthwise') {
                    echo '<td class="text-center">' . date('F Y', strtotime($periodDate)) . '</td>';
                } elseif ($reportType == 'yearwise') {
                    echo '<td class="text-center">' . $periodDate . '</td>';
                }
                
                echo '<td  class="text-center">' . $totalAmount . '</td>';
                echo '</tr>';
                $count++;
            }
        }

        echo '</tbody></table>';
    }
    ?>




                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery.slim.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/feather.min.js"></script>
        <!-- Menu Toggle Script -->
        <script>
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
        </script>
        
        <script>
            feather.replace()
        </script>
            <script>
            $(function () {
                $("#start_date").datepicker();
                $("#end_date").datepicker();
            });
        </script>

    </body>

    </html>
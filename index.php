<?php
  include("session.php");
  $one_month_ago = date("Y-m-d", strtotime("-1 month"));
  $exp_category_dc = mysqli_query($con, "SELECT expensecategory FROM expenses WHERE user_id = '$userid' AND expensedate >= '$one_month_ago' GROUP BY expensecategory");
  $exp_amt_dc = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate >= '$one_month_ago' GROUP BY expensecategory");
  
  $one_week_ago = date("Y-m-d", strtotime("-1 week"));
  $exp_date_line = mysqli_query($con, "SELECT DATE_FORMAT(expensedate, '%b %d') AS day_month FROM expenses WHERE user_id = '$userid' AND expensedate >= '$one_week_ago' GROUP BY expensedate");
  $exp_amt_line = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate >= '$one_week_ago' GROUP BY expensedate");
  
  $yearly_expenses_query = "SELECT YEAR(expensedate) AS year, SUM(expense) AS total_expense
                          FROM expenses
                          WHERE user_id = '$userid'
                          GROUP BY YEAR(expensedate)
                          ORDER BY YEAR(expensedate)";
$yearly_expenses_result = mysqli_query($con, $yearly_expenses_query);
$year_labels = [];
$yearly_expense_data = [];
while ($row = mysqli_fetch_assoc($yearly_expenses_result)) {
    $year_labels[] = $row['year'];
    $yearly_expense_data[] = $row['total_expense'];
}

$monthly_expenses_query = "SELECT DATE_FORMAT(expensedate, '%Y-%m') AS month_year, SUM(expense) AS total_expense
                          FROM expenses
                          WHERE user_id = '$userid'
                          AND expensedate >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
                          GROUP BY DATE_FORMAT(expensedate, '%Y-%m')
                          ORDER BY expensedate";
$monthly_expenses_result = mysqli_query($con, $monthly_expenses_query);
$monthly_labels = [];
$monthly_expense_data = [];
while ($row = mysqli_fetch_assoc($monthly_expenses_result)) {
    $monthly_labels[] = $row['month_year'];
    $monthly_expense_data[] = $row['total_expense'];
}

$today_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate = CURDATE()");
$yesterday_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
$this_week_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)");
$this_month_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
$this_year_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)");
$total_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid'");

$today_expense_amount = '0' + mysqli_fetch_assoc($today_expense)['SUM(expense)'];
$yesterday_expense_amount ='0' + mysqli_fetch_assoc($yesterday_expense)['SUM(expense)'];
$this_week_expense_amount = '0' + mysqli_fetch_assoc($this_week_expense)['SUM(expense)'];
$this_month_expense_amount = '0' + mysqli_fetch_assoc($this_month_expense)['SUM(expense)'];
$this_year_expense_amount = '0' + mysqli_fetch_assoc($this_year_expense)['SUM(expense)'];
$total_expense_amount = '0' + mysqli_fetch_assoc($total_expense)['SUM(expense)'];

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Expense Manager - Dashboard</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.css" rel="stylesheet">
  
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

  <!-- Feather JS for Icons -->
  <script src="js/feather.min.js"></script>
  <style>
    .card a {
      color: #000;
      font-weight: 500;
    }

    .card a:hover {
      color: #28a745;
      text-decoration: dotted;
    }
    .try {
  font-size: 28px; /* Adjust the font size as needed */
  color: #333;    /* Adjust the color as needed */
  padding: 5px 0px 0px 0px;   /* Adjust the padding as needed */
}
.container {
    padding:0px 20px 20px 20px;/* Add padding to the container */
  }
.card.text-center {
    border: 3px solid #ccc;
    padding: 10px;
    margin: 10px;
    background-color: #f8f9fa;
    border-radius: 5px;
  }

  .card-title {
    font-size: 17.5px;
    margin-bottom: 1px ;
    color: #333;
  }

  .card-text {
    font-size: 24px;
    font-weight: bold;
    color: #6c757d;
  }
  
  </style>

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="border-right" id="sidebar-wrapper">
      <div class="user">
        <img class="img img-fluid rounded-circle" src="uploads\default_profile.png" width="120">
        <h5><?php echo $username ?></h5>
        <p><?php echo $useremail ?></p>
      </div>
      <div class="sidebar-heading">Management</div>
      <div class="list-group list-group-flush">
        <a href="index.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="home"></span> Dashboard</a>
        <a href="add_expense.php" class="list-group-item list-group-item-action "><span data-feather="plus-square"></span> Add Expenses</a>
        <a href="manage_expense.php" class="list-group-item list-group-item-action "><span data-feather="dollar-sign"></span> Manage Expenses</a>
        <a href="expensereport.php" class="list-group-item list-group-item-action"><span data-feather="file-text"></span> Expense Report</a>

      </div>
      <div class="sidebar-heading">Settings </div>
      <div class="list-group list-group-flush">
        <a href="profile.php" class="list-group-item list-group-item-action "><span data-feather="user"></span> Profile</a>
        <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light  border-bottom">


        <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
          <span data-feather="menu"></span>
        </button>
        <div class="col-md-0 text-center">
    <h3 class="try">Dashboard</h3>
</div>
        
      </nav>
      <div class="container-fluid">
        <h4 class="mt-4">Full-Expense Report</h4>
        <div class="row">

        <div class="container mt-4">
  <div class="row">
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Today's Expense</h5>
          <p class="card-text">₹<?php echo $today_expense_amount; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Yesterday's Expense</h5>
          <p class="card-text">₹<?php echo $yesterday_expense_amount; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Last 7Day's Expense</h5>
          <p class="card-text">₹<?php echo $this_week_expense_amount; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Last 30Day's Expense</h5>
          <p class="card-text">₹<?php echo $this_month_expense_amount; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Current Year Expense</h5>
          <p class="card-text">₹<?php echo $this_year_expense_amount; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Total Expense</h5>
          <p class="card-text">₹<?php echo $total_expense_amount; ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

          <!-- Daily Expenses Chart -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title text-center">Daily Expenses</h5>
              </div>
              <div class="card-body">
                <canvas id="expense_line" height="200"></canvas>
              </div>
            </div>
          </div>
          <!-- Expense Category Chart -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title text-center">Expense Category</h5>
              </div>
              <div class="card-body">
                <canvas id="expense_category_pie" height="200"></canvas>
              </div>
            </div>
          </div>
          <!-- Monthly Expenses Chart -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title text-center">Monthly Expenses</h5>
              </div>
              <div class="card-body">
                <canvas id="monthly_expense_line" height="200"></canvas>
              </div>
            </div>
          </div>
          <!-- Yearly Expenses Chart -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title text-center">Yearly Expenses</h5>
              </div>
              <div class="card-body">
                <canvas id="expense_yearly_line" height="200"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="js/jquery.slim.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/Chart.min.js"></script>
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
    var ctx = document.getElementById('expense_category_pie').getContext('2d');

var categories = [<?php while ($a = mysqli_fetch_array($exp_category_dc)) {
    echo '"' . $a['expensecategory'] . '",';
} ?>];
var expenses = [<?php while ($b = mysqli_fetch_array($exp_amt_dc)) {
    echo '"' . $b['SUM(expense)'] . '",';
} ?>];
var colors = [
    '#6f42c1',
    '#dc3545',
    '#28a745',
    '#007bff',
    '#ffc107',
    '#20c997',
    '#17a2b8',
    '#fd7e14',
    '#e83e8c',
    '#6610f2'
];

var dataset = {
    labels: categories,
    datasets: [{
        label: 'Expense by Category (Last Month)',
        data: expenses,
        backgroundColor: colors,
        borderWidth: 1
    }]
};

var options = {
    scales: {
        x: {
            beginAtZero: true,
            ticks: {
                autoSkip: false,
                maxRotation: 45,
                minRotation: 45
            }
        },
        y: {
            beginAtZero: true
        }
    }
};

var myChart = new Chart(ctx, {
    type: 'bar',
    data: dataset,
    options: options
});


var yearlyColors = [
  '#dc3545',  // Red
    '#28a745',  // Green
    '#007bff',  // Blue
    '#ffc107',  // Yellow
    '#20c997',  // Teal
    '#17a2b8',  // Cyan
    '#fd7e14',  // Orange
    '#e83e8c',  // Pink
    '#6610f2'
    ];

    var yearlyLine = document.getElementById('expense_yearly_line').getContext('2d');
    var yearlyChartData = {
      labels: [<?php echo '"' . implode('","', $year_labels) . '"'; ?>],
      datasets: [{
        label: 'Yearly Expense',
        data: [<?php echo implode(',', $yearly_expense_data); ?>],
        borderColor: yearlyColors,
        backgroundColor: yearlyColors,
        fill: false,
        borderWidth: 2
      }]
    };

    var yearlyExpenseChart = new Chart(yearlyLine, {
      type: 'bar',
      data: yearlyChartData,
      options: {
        scales: {
          x: {
            ticks: {
              autoSkip: false,
              maxRotation: 45,
              minRotation: 45
            }
          }
        }
      }
    });

  var monthlyLine = document.getElementById('monthly_expense_line').getContext('2d');
var monthlyChartData = {
    labels: [<?php echo '"' . implode('","', $monthly_labels) . '"'; ?>],
    datasets: [{
        label: 'Monthly Expense (Last Year)',
        data: [<?php echo implode(',', $monthly_expense_data); ?>],
        borderColor: [
            '#fd7e14'
        ],
        backgroundColor: [
            '#fd7e14'
        ],
        fill: false,
        borderWidth: 2
    }]
};
var monthlyExpenseChart = new Chart(monthlyLine, {
    type: 'line',
    data: monthlyChartData,
    options: {
        scales: {
            x: {
                ticks: {
                    autoSkip: false,
                    maxRotation: 45,
                    minRotation: 45
                }
            }
        }
    }
});


var line = document.getElementById('expense_line').getContext('2d');
var myChart = new Chart(line, {
  type: 'line',
  data: {
    labels: [<?php while ($c = mysqli_fetch_array($exp_date_line)) {
                echo '"' . $c['day_month'] . '",';
              } ?>],
    datasets: [{
      label: 'Expense by Day (Last Week)',
      data: [<?php while ($d = mysqli_fetch_array($exp_amt_line)) {
                echo '"' . $d['SUM(expense)'] . '",';
              } ?>],
      borderColor: [
        '#adb5bd'
      ],
      backgroundColor: [
        '#6f42c1',
        '#dc3545',
        '#28a745',
        '#007bff',
        '#ffc107',
        '#20c997',
        '#17a2b8',
        '#fd7e14',
        '#e83e8c',
        '#6610f2'
      ],
      fill: false,
      borderWidth: 2
    }]
  }
});



    
  </script>
</body>

</html>
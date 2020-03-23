<?php
include 'includes/config.php';
$today = date('Y-m-d');
$sql_get_sales = "SELECT date_done , SUM(quantity*price) AS sales FROM `total_sales`  GROUP BY total_sales.date_done";
$resu = $conn->query($sql_get_sales);
$date_sales = array();
$count_sales = array();
$max = 0;
while($row = $resu->fetch_assoc()){

$date_sales[]  = $row['date_done'];
$count_sales[] = $row['sales'];
$max          += $row['sales'];
}

?>

<script type="text/javascript">
  $(document).ready(function(){
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var sales_date  = [<?php echo '"'.implode('","',  $date_sales ).'"' ?>];
var sales_count = [<?php echo '"'.implode('","',  $count_sales ).'"' ?>];
var max = <?php echo $max; ?>

// Area Chart Example
var ctx = document.getElementById("kike");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: sales_date,
    datasets: [{
      label: "Total Amount is",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,11,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: sales_count,
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: max,
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});

  });
</script>
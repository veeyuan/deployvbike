<?php
include("adHeader.php");
include("db.php");

session_start();
if (!isset($_SESSION['adminID'])) {
    echo "<script>window.location='loginAdmin.php';</script>";
}
?>

<div class="container-fluid">
    <div class="block-header">
        <h2>Dashboard</h2>
        <small class="text-muted">Welcome to Admin Panel</small>
    </div>
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-account col-blue"></i> </div>
                <div class="content">
                    <div class="text">Total Users</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT * FROM users";
                        $qsql = mysqli_query($connect, $sql);
                        echo mysqli_num_rows($qsql);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-bug col-blush"></i> </div>
                <div class="content">
                    <div class="text">Performing Admins</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT * FROM admin WHERE statusID = 1";
                        $qsql = mysqli_query($connect, $sql);
                        echo mysqli_num_rows($qsql);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-balance col-cyan"></i> </div>
                <div class="content">
                    <div class="text">Total Reservations</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT * FROM reservations";
                        $qsql = mysqli_query($connect, $sql);
                        echo mysqli_num_rows($qsql);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        $rows = '';
        $query = "SELECT * FROM reservations ORDER BY startDate";
        $result = mysqli_query($connect,$query);
        $total_rows =  $result->num_rows;
        if($result) 
        {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    ?>
    <div class="col-xs-12" id="morris-line-chart"></div>
    <div class="clear"></div>
    <script>Morris.Line({
    // ID of the element in which to draw the chart.
    element: 'morris-line-chart',

    // Chart data records -- each entry in this array corresponds to a point
    // on the chart.
    data: <?php echo json_encode($rows);?>,

    // The name of the data record attribute that contains x-values.
    xkey: 'startDate',

    // A list of names of data record attributes that contain y-values.
    ykeys: ['totalPrice'],

    // Labels for the ykeys -- will be displayed when you hover over the
    // chart.
    labels: ['Price'],

    lineColors: ['#0b62a4'],
    xLabels: 'date',

    // Disables line smoothing
    smooth: true,
    resize: true
});</script> 
</div>
</div>
<?php
include("adFooter.php");
?>
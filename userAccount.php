
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.container {
  position: relative;
  width: 100%;
  max-width: 400px;
}

.container .button {
  position: absolute;
  top: 61%;
  left: 11%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  background-color: #02aab0;
  font-size: 16px;
  color: white;
  padding: 12px 24px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  text-align: center;
}

.container .button:hover {
  background-color: white;
  color: black;
}
</style>
</head>
<body>
<?php
include("adHeader.php");

include("db.php");
if(!isset($_SESSION['userID']))
{
	echo "<script>window.location='login.php';</script>";
}

$sqlpatient = "SELECT * FROM users WHERE userID = '$_SESSION[userID]' ";
$qsqlpatient = mysqli_query($connect,$sqlpatient);
$rspatient = mysqli_fetch_array($qsqlpatient);

$sqlpatientappointment = "SELECT * FROM appointment WHERE patientid='$_SESSION[patientid]' ";
$qsqlpatientappointment = mysqli_query($con,$sqlpatientappointment);
$rspatientappointment = mysqli_fetch_array($qsqlpatientappointment);
?>
<div class=" container-fluid">
    <div class="block-header">
        <h2>Dashboard</h2>
        <small class="text-muted">Welcome to MY V Bike Rental</small>
    </div>

    <div class="card">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <div class="alert bg-teal">
                            <h3>Welcome , <?php echo $rspatient['username']; ?> !</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="container">
                <img src="imForSite\biking.png" alt="bike" style="width:970px;height:400px;">
                <button class="button" onclick="document.location='reservation.php'">Reserve a bike</button>
            </div>


    </div>
</div>

<?php
include("adFooter.php");
?>

</body>
</html>
<?php
include("adFormHeader.php");
include("db.php");
if(isset($_GET['delid']))
{
	$sql ="DELETE FROM admin WHERE adminID='$_GET[delid]'";
	$qsql=mysqli_query($connect,$sql);
	if(mysqli_affected_rows($connect) == 1)
	{
		echo "<script>alert('Admin record deleted successfully');</script>";
	}
}
?>

<div class="container-fluid">
  <div class="block-header">
    View Adminstrator Record
  </div>
</div>
<div class="card">
  <section class="container">
   <table class="table table-bordered table-striped table-hover js-basic-example dataTable">


    <thead>
      <tr>
        <td width="12%" height="40">Username</td>
        <td width="11%">Email</td>
        <td width="12%">Status</td>
        <td width="10%">Action</td>
      </tr>
    </thead>
    <tbody>
     <?php          
     $sql ="SELECT * FROM admin";
     $qsql = mysqli_query($connect,$sql);
     while($rs = mysqli_fetch_array($qsql))
     {
         $status = "";
         if($rs['statusID'] == 1){
            $status = "Active";
         }
         else if($rs['statusID'] == 2){
            $status = "Inactive";
         }
      echo "<tr>
      <td>$rs[username]</td>
      <td>$rs[email]</td>
      <td>$status</td>
      <td style='min-width: 180px'>
      <a href='admin.php?editid=$rs[adminID]' class='btn btn-raised g-bg-cyan'>Edit</a> <a href='viewAdmin.php?delid=$rs[adminID]' class='btn btn-raised g-bg-blush2'>Delete</a> </td>
      </tr>";
    }
    ?>
  </tbody>
</table>
</section>

</div>
</div>



<?php
include("adFormFooter.php");
?>
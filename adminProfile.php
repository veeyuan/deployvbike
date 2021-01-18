<?php
include("adHeader.php");
include("db.php");
session_start();
if(isset($_POST['submit']))
{
	if(isset($_SESSION['adminID']))
	{
		$sql ="UPDATE admin SET username='$_POST[adminname]',email='$_POST[email]',statusID='$_POST[select]' WHERE adminID='$_SESSION[adminID]'";
		if($qsql = mysqli_query($connect,$sql))
		{
			echo "<div class='alert alert-success'>
			Admin record updated successfully
			</div>";
			
		}
		else
		{
			echo mysqli_error($connect);
		}	
	}
	else
	{
		$sql ="INSERT INTO admin(username,email,statusID) values('$_POST[adminname]','$_POST[email]','$_POST[select]')";
		if($qsql = mysqli_query($connect,$sql))
		{
			echo "<div class='alert alert-success'>
			Admin record inserted successfully
			</div>";

		}
		else
		{
			echo mysqli_error($connect);
		}
	}
}
if(isset($_SESSION['adminID']))
{
	$sql="SELECT * FROM admin WHERE adminID='$_SESSION[adminID]' ";
	$qsql = mysqli_query($connect,$sql);
	$rsedit = mysqli_fetch_array($qsql);  
}
?>
<div class="container-fluid">
    <div class="block-header">
        <h2> Update Admin Record</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">

                <form method="post" action="" name="frmadminprofile" onSubmit="return validateform()">

                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="adminname" id="adminname"
                                            value="<?php echo $rsedit['username']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="<?php echo $rsedit['email']; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group drop-custum">
                                    <select class="form-control show-tick" name = "select" id = "select">
                                        <?php
                                        $value = "";
                                        $value1 = "";
                                        if($rsedit['statusID'] == 1){
                                            $value = "Active";
                                            $value1 = "Inactive";
                                        }
                                        else if($rsedit['statusID'] == 2){
                                            $value = "Inactive";
                                            $value1 = "Active";
                                        }
                                        $arr = array(1, 2);
										foreach($arr as $val)
										{
											if($rsedit['statusID'] == $val)
											{                                                
                                                echo "<option value='$val' selected>$value</option>";
                                                
											}
											else
											{
												echo "<option value='$val'>$value1</option>";			  
											}
										}
										?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-raised g-bg-cyan" name="submit" id="submit"
                                value="Update" />

                        </div>
                    </div>
            </div>

            </form>
        </div>
    </div>
</div>
</div>
<?php
    include("adFooter.php");
?>
<script type="application/javascript">
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphanumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 

function validateform() {
    if (document.frmadminprofile.adminname.value == "") {
        alert("Admin name should not be empty..");
        document.frmadminprofile.adminname.focus();
        return false;
    } else if (!document.frmadminprofile.adminname.value.match(alphaspaceExp)) {
        alert("Admin name not valid..");
        document.frmadminprofile.adminname.focus();
        return false;
    } else if (document.frmadminprofile.email.value == "") {
        alert("Email should not be empty..");
        document.frmadminprofile.email.focus();
        return false;
    } else if (document.frmadminprofile.select.value == "") {
        alert("Kindly select the status..");
        document.frmadminprofile.select.focus();
        return false;
    } else {
        return true;
    }
}
</script>
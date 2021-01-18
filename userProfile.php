<?php
include("adHeader.php");
include("db.php");
if(isset($_POST['submit']))
{
		$sql ="UPDATE users SET username='$_POST[username]',email='$_POST[email]',mobileno='$_POST[mobileno]',address='$_POST[address]' WHERE userID='$_SESSION[userID]'";
		if($qsql = mysqli_query($connect,$sql))
		{
			echo "<script>alert('User profile updated successfully!');</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
}
if(isset($_SESSION['userID']))
{
	$sql="SELECT * FROM users WHERE userID = '$_SESSION[userID]' ";
	$qsql = mysqli_query($connect,$sql);
	$rsedit = mysqli_fetch_array($qsql);	
}
?>

<div class="container-fluid">
        <div class="block-header">
            <h2>Personal Profile</h2>            
        </div>
        <div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
				<form method="post" action="" name="frmpatprfl" onSubmit="return validateform()">
					<div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                	<label for="">Username</label>
                                    <div class="form-line">
                                    	
                                        <input class="form-control" type="text" name="username" id="username"  value="<?php echo $rsedit['username']; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                	<label for="">Email</label>
                                    <div class="form-line">
                                    
                                        <input class="form-control" type="email" name="email" id="email"  value="<?php echo $rsedit['email']; ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
							<div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                	<label for="">Mobile No</label>
                                    <div class="form-line">
                                    	
                                        <input class="form-control" type="number" name="mobileno" id="mobileno"  value="<?php echo $rsedit['mobileNo']; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group ">
                                	<label for="">Address</label>
                                	<div class="form-line">
                                    <input class="form-control" name="address" id="address" value="<?php echo $rsedit['address']; ?>" /> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">                                
                                <input type="submit" class="btn btn-raised g-bg-cyan" name="submit" id="submit" value="UPDATE" />
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


function validateform()
{
	if(document.frmpatprfl.username.value == "")
	{
		alert("Patient name should not be empty.");
		document.frmpatprfl.username.focus();
		return false;
	}
	else if(document.frmpatprfl.address.value == "")
	{
		alert("Address should not be empty.");
		document.frmpatprfl.address.focus();
		return false;
	}
	else if(document.frmpatprfl.mobileno.value == "")
	{
		alert("Mobile number should not be empty.");
		document.frmpatprfl.mobileno.focus();
		return false;
	}
	else if(!document.frmpatprfl.mobileno.value.match(numericExpression))
	{
		alert("Mobile number not valid.");
		document.frmpatprfl.mobileno.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>
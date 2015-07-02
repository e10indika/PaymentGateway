<?php
session_start();
ini_set('max_execution_time', 90); 
?>
<html>
<head>
<meta charset="UTF-8">
		<title>Pera.Pay Secure Transactions</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
</head>
<body>
<!-- Header -->
			<header id="header">
				<h1><a href="index.html">Pera.Pay Secure Transactions</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="index.html">Home</a></li>
						<li><a href="register.html">Register</a></li>
						<li><a href="transaction.html">Transaction</a></li>
					</ul>
				</nav>
			</header>

		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">

					<header class="major">
						<h2>Pera.Pay Secure Transactions</h2>
						<p>The Only Place to pay 200% secure</p>
					</header>

					<!-- Text -->
						<section>
<?php
include("connect.php");

mysql_select_db('pg',$conn);

$pass=$_POST['upw'];
$email=$_POST['uemail'];
$cardno=$_POST['ucardno'];
$usercvs=$_POST['ucvsno'];
//$userfingerprint=$_POST['ufp'];
//$userfingerprint="fp/".$userfingerprint;

$hashed_password = sha1($pass);
$hashed_usercardno = sha1($cardno); 

$sql="SELECT * FROM user_primary_data WHERE email='$email'";
if (mysql_num_rows(mysql_query($sql,$conn))<1)
{
	echo "<hr><font color='red' size=6>Email Not Registered<br>Tranaction Declined</font><hr><a href='transaction.html'><input type='button' value='Back'><a>";
}
else
{
	$run=mysql_fetch_array(mysql_query($sql,$conn));
	$userid=$run['user_id'];
	$username=$run['user_name'];
	$usermobile=$run['mobile_number'];
	$usercountry=$run['country'];
	$usernic=$run['ctizen_id_no'];
	$userdob=$run['birth_day'];	
	
	$sql="SELECT * FROM user_login_data WHERE user_id='$userid'";
	$run=mysql_fetch_array(mysql_query($sql,$conn));
	$password=$run['password'];
	
	if ($hashed_password==$password){
		
		$sql="SELECT * FROM user_billing_data WHERE user_id='$userid'";
		$run=mysql_fetch_array(mysql_query($sql,$conn));
		
		$userbillingadd=$run['billing_address'];
		$usershippingadd=$run['shipping_address'];
		$usercardno=$run['card_no'];
		$useruseraccountno=$run['bank_acc_no'];
		
		if($usercardno != $hashed_usercardno ){
			echo "<hr><font color='red' size=6>Card Number is not Correct<br>Tranaction Declined</font><hr><a href='transaction.html'><input type='button' value='Back'><a>";
		}
		else{
			
			echo "<font color='green' size='6'>User data verified </br></font>";
			
			if(!empty($_FILES["ufp"]["name"])) {
				
				$file_name=$_FILES["ufp"]["name"];
				$temp_name=$_FILES["ufp"]["tmp_name"];
				$imgtype=$_FILES["ufp"]["type"];
				$imagename="".$usercardno.'.tif';
				$target_image_path =  __DIR__ ."\\transaction\images\\".$imagename;
				$target_minutiae_path =  __DIR__ ."\\transaction\minutae\\";
			 
				move_uploaded_file($temp_name, $target_image_path);
		  
			}
			else 
			{
				header("Location: fileupload.php");
				exit();
			}
  
			$savename = "".$usercardno.'.dat';
			$inputDir  = "C:\mypay.Inc\FingerPrint\code";
			$command = "matlab -sd ".$inputDir." -nodisplay -nodesktop -nosplash -wait -r  fingerprint('".$target_image_path."','".$target_minutiae_path."','".$savename."')";
			$output = exec($command);
			
  

			$finger1_minutae_path = __DIR__ ."\\transaction\minutae\\";
			$finger2_minutae_path = __DIR__ ."\\registration\minutae\\";
			$command = "matlab -sd ".$inputDir." -nodisplay -nodesktop -nosplash -wait  -r  fingerprint_match('".$userid."','".$finger1_minutae_path."','".$finger2_minutae_path."','".$savename."')";
			exec ($command);
			
			mysql_select_db('fp',$conn);
			$sql="SELECT * FROM user_finger_maching WHERE user_id='$userid'";
			
			$run=mysql_fetch_array(mysql_query($sql,$conn));
			
			$approval=$run['approval'];
			
			$sql="DELETE FROM `user_finger_maching` WHERE user_id='$userid'";
			mysql_query($sql,$conn);
			
			exec ("del ".$target_image_path."");
			exec ("del ".$finger1_minutae_path."".$savename.""); 

			if($approval == 1)
			{
				echo "<font color='green' size='6'>Finger Print Also verified</font>";
			}else
			{
				echo "<font color='red' size='6'>Finger Print is not verified</font>";
			}
		}	
?>

<?php
	}
	else
	{
		echo "<hr><font color='red' size=6>User Verification Failed<br>Tranaction Declined</font><hr><a href='transaction.html'><input type='button' value='Back'><a>";
	}
}
?>




</body>
</html>
<html>
<head>
<meta charset="UTF-8">
		<title>Registration of MyPay</title>
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
	<header id="header">
		<nav id="nav">
			<ul>
			<li><a href="index.html">Home</a></li>
			<li><a href="transaction.html">Transaction</a></li>
			</ul>
		</nav>
	</header>

<?php

session_start();
include("connect.php");
$pass=$_POST['upw'];
$username=$_POST['uname'];
$useremail=$_POST['uemail'];
$usermobile=$_POST['umobile'];
$usercountry=$_POST['ucontry'];
$usernic=$_POST['ucitizenid'];
$userdob=$_POST['ubd'];
$userbillingadd=$_POST['billadd'];
$usershippingadd=$_POST['shipadd'];
$usercardno=$_POST['ucardno'];
$useruseraccountno=$_POST['uaccno'];

/* encrypt the password using sha1 hash algorithm in php */
$hashed_password = sha1($pass);
$hashed_usercardno = sha1($usercardno); 

	

	/* connect to 'pg' database */
	mysql_select_db('pg',$conn);
	$sql="SELECT * FROM user_primary_data WHERE email='$useremail'";
	if (mysql_num_rows(mysql_query($sql,$conn))>0){
		header("Location: existemail.php");
		exit();
		$run=mysql_fetch_array(mysql_query($sql,$conn));
		$userid=$run['user_id'];
	}else{
		
		/* Сheck that we have a file */
		if(!empty($_FILES["ufp"]["name"])) {
			$file_name=$_FILES["ufp"]["name"];
			$temp_name=$_FILES["ufp"]["tmp_name"];
			$imgtype=$_FILES["ufp"]["type"];
			
			/* set imagename to save the file */
			$imagename="".$hashed_usercardno.'.tif';

			/* set paths for image and minutae */
			$target_image_path =  __DIR__ ."\\registration\image\\".$imagename;
			$target_minutiae_path = __DIR__ ."\\registration\minutae\\";

			/* upload the file to s=destination */
			move_uploaded_file($temp_name, $target_image_path);
			
			/* set the path to save created by matlab */
			$savename = "".$hashed_usercardno.'.dat';
			$inputDir  = "C:\mypay.Inc\FingerPrint\code";
			$command = "matlab -sd ".$inputDir." -nodisplay -nodesktop -nosplash -wait -minimize -r  fingerprint('".$target_image_path."','".$target_minutiae_path."','".$savename."')";
			$output = exec($command);
		}
		else 
		{
			header("Location: fileupload.php");
			exit();
		}
		$sql="SELECT * FROM user_primary_data";
		$userid=mysql_num_rows(mysql_query($sql,$conn))+1;
		$sql="INSERT INTO user_primary_data value ('$userid','$username','$useremail','$usermobile','$usercountry','$usernic','$userdob')";
		if (mysql_query($sql,$conn)){
		}else{
			echo mysql_error();
		}

		$sql="INSERT INTO user_billing_data values ('$userid','$hashed_usercardno','$useruseraccountno','$userbillingadd','$usershippingadd')";
		if (mysql_query($sql,$conn)){
		}else{
			echo mysql_error();
		}
		$sql="INSERT INTO user_login_data value ('$userid','$hashed_password')";
		if (mysql_query($sql,$conn)){
		}else{
			echo mysql_error();
		}
		
		echo "<hr><font color='green' size=8>Email Registration Succeded </font><hr>";
		
	}

?>
<table align="center">

<tr><td>User ID</td><td>:</td><td><?php echo $userid;?></td></tr>
<tr><td>User Name</td><td>:</td><td><?php echo $username;?></td></tr>
<tr><td>User Email</td><td>:</td><td><?php echo $useremail;?></td></tr>
<tr><td>User Mobile</td><td>:</td><td><?php echo $usermobile;?></td></tr>
<tr><td>User Contry</td><td>:</td><td><?php echo $usercountry;?></td></tr>
<tr><td>User Citizen ID No</td><td>:</td><td><?php echo $usernic;?></td></tr>
<tr><td>User Birth Day</td><td>:</td><td><?php echo $userdob;?></td></tr>
<tr><td>Billing Address</td><td>:</td><td><?php echo $userbillingadd;?></td></tr>
<tr><td>Shipping Address</td><td>:</td><td><?php echo $usershippingadd;?></td></tr>
<tr><td>User Card No</td><td>:</td><td><?php echo $usercardno;?></td></tr>
<tr><td>User Account No</td><td>:</td><td><?php echo $useruseraccountno;?></td></tr>	
<tr><td><?php
		echo "<hr><font color='red' size=8>Is your data correct ? </font>&nbsp;<a href='index.html'><input type='button' value='Yes'><a>&nbsp;&nbsp;<a href='register.html'><input type='button' value='No'><a></>";
	?> 
</table>
</body>

</html>
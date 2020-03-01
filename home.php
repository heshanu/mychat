<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="script" type="text/javascript" href="js/boostrap.min.js">
	<link rel="stylesheet" type="text/css" href="F:\computer science\js\boostrap.min.js">
</head>
<body>
	<div class="container main-section">
		<div class="row">
			<div class="col-md-3 col-xs-12 left-sidebar ">
				<div class="input-group searchbox">
					<div class="input-group-btn">
						<center><a href="include/find_friends.php"><button class="btn btn-warning" name="search_user" type="submit">ADD NEW USER</button></a></center>
					</div>
				</div>

				<!--<-->
				<div class="left-chat">
					<ul>
						<?php include("include/get_users_data.php")?>
					</ul>
				</div>
			</div>
			<div class="col-md-9 col-sm-9 col-xs-12 right-sidebar">
				<div class="row">
					<!---->
					<?php

						$user_email=$_SESSION['email'];
						$get_user="SELECT * FROM users WHERE user_email='$user_email'";
						$run_user=mysqli_query($con,$get_user);
						$row=mysqli_fetch_assoc($run_user);
							
						$user_id=$row['user_id'];
						$user_name=$row['user_name'];
						
						


					?>

					<?php
					if(isset($GET['user_name'])){
						global $con;
						$get_username=$_GET['user_name'];
						$get_user="SELECT * FROM users where user_name='$get_username'";
						$run_user=mysqli_query($con,$get_user);
						$row_user=mysqli_query($con,$run_user);

						$username=$row_user['user_name'];
						$user_profile_image['user_profile_image'];

					    $total_message="SELECT * FROM user_chat where (sender_username='$user_name' AND receiver_username='$username') OR (receiver_username='$user_name' AND sender_username='$username')";

					$run_message=mysqli_query($con,$total_message);
					$total=mysqli_num_row($run_message);
					}

			
					?>

				<div class="col-md-12 right-header">
					<div class="right-header-img">
						<img src="<?php echo "$user_profile_image"; ?>">
					</div>

					<div class="right-header-detail">
						<form method="POST" action="home.php">
							<p><?php echo "$username";?></p>
							<span><?php echo $total;?>messages</span>&nbsp
							<button name="logout" class="btn btn-danger">logout</button>
						</form>
						<?php
						if(isset($_POST['logout'])){
							$update_msg=mysqli_query($con,"UPDATE users set log_in='Offline' where user_name='$user_name'");
							header("Location:logout.php");
							exit();


						
						}
						?>
					</div>
				</div>
				</div>
				<div class="row">
					<div class="scrolling_to_bottom" class="col-md-12 right-header-contentChat">
						<?php

						$update_msg=mysqli_query($con,"UPDATE users set log_in='Offline' where user_name='$user_name'");
						$sel_msg="select * from user_chat where(sender_username='$user_name' AND receiver_username='$username') OR (receiver_username='$user_name' AND sender_username='$username') order by 1 ASC";
						$run_msg=mysqli_query($con,$sel_msg);
						while($row=mysqli_fetch_arrays($run_msg)){
							$sender_username=$row['sender_username'];
							$receiver_username=$row['receiver_username'];
							$msg_contact=$row['msg_contact'];
							$msg_date=$row['msg_date'];

						

												?>
						<ul>
						<?php
							if($user_name==$sender_username AND $username==$receiver_username){
								echo "
								<li>
								<div class='rightside-chat'>
							<span>$username<small>$msg_date</small></span>
							<p>$msg_contact</p>	
								</div>
								</li>
								";
							}


							if($user_name==$receiver_username AND $username==$receiver_username){
								echo "
								<li>
									<div class='rightside-chat'>
										<span>$username<small>$msg_date</small></span>
										<p>$msg_contact</p>	
									</div>
								</li>
								";
							}
						?>
							
						</ul>						
						<?php
							}
						?>
					</div>				
				</div>
				<div class="row">
					<div class="col-md-12 right-chat-textbox">
						<input autocomplete="off" type="text" name="msg_contact" placeholder="write your message">
						<button class="btn" name="submit"><i class="fa fa-telegram" aria-hidden="true"></i></button>
					</div>
				</div>
			</div>	
		</div>
	</div>
	<?php
	if(isset($_POST['submit'])){
		$msg=htmlentities($_POST['msg_contact']);

		if($msg=""){
			echo "<strong>unable to send</strong>";
		}
		else if(strlen($msg)>100){
			echo "<strong>too long message</strong>";
		}
		else{
			$insert="insert into user_chat() values('$user_name','$username','$msg','unread',NOW())";
			$run_insert=mysqli_query($con,$insert);
		}
	}

	?>
</body>
</html>

<?php
	session_destroy();
?>
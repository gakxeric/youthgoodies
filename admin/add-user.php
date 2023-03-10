<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<?php require('adminheader.php'); ?>
<?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<div class="alert bg-success" role="alert">
				<svg class="glyph stroked checkmark">
				<use xlink:href="#stroked-checkmark"></use>
				</svg>User '.$_GET['action'].'.</div>'; 
	} 
	?>
	

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		//collect form data
		extract($_POST);

		//very basic validation
		if($username ==''){
			 $error[]= 'Please enter the username.';

		}

		if($password ==''){
			$error[] = 'Please enter the password.';
		}

		if($passwordConfirm ==''){
			$error[] = 'Please confirm the password.';
		}

		if($password != $passwordConfirm){
			$error[] = 'Passwords do not match.';
		}

		if($email ==''){
			$error[] = 'Please enter the email address.';
		}

		if(!isset($error)){

			$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

			try {

				//insert into database
				$stmt = $db->prepare('INSERT INTO blog_members (username,password,email) VALUES (:username, :password, :email)') ;
				$stmt->execute(array(
					':username' => $username,
					':password' => $hashedpassword,
					':email' => $email
				));

				//redirect to index page
				header('Location: users.php?action=added');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Form Elements</div>
					<div class="panel-body">
						<div class="col-md-6">
							<form role="form" action='' method='post'>
							
								<div class="form-group">
									<label>Username</label>
									<input class="form-control" type='text' name='username' value='<?php if(isset($error)){ echo $_POST['username'];}?>'>
								</div>
								<div class="form-group">
									<label>Password</label>
									<input class="form-control" type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'>
								</div>
								<div class="form-group">
									<label>Confirm Password</label>
									<input class="form-control" type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input class="form-control" type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'>
								</div>
																
								<input type='submit' name='submit' value='Add User'class="btn btn-primary ">
							</form>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		
	</div><!--/.main-->


	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	<script src="js/bootstrap-table.js"></script>
</body>

</html>

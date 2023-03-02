<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['deluser'])){ 

	//if user id is 1 ignore
	if($_GET['deluser']){

		$stmt = $db->prepare('DELETE FROM blog_members WHERE memberID = :memberID') ;
		$stmt->execute(array(':memberID' => $_GET['deluser']));

		header('Location: users.php?action=deleted');
		exit;

	}
} 

?>
<?php require('adminheader.php'); ?>
<script language="JavaScript" type="text/javascript">
  function deluser(id, username)
  {
	  if (confirm("Are you sure you want to delete '" + username + "'"))
	  {
	  	window.location.href = 'users.php?deluser=' + id;
	  }
  }
  </script>
	
		   <?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<div class="alert bg-success" role="alert">
				<svg class="glyph stroked checkmark">
				<use xlink:href="#stroked-checkmark"></use>
				</svg>User '.$_GET['action'].'.</div>'; 
	} 
	?>
	<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Users</div>
					<div class="panel-body">
						<table data-toggle="table"  
						 data-show-refresh="true" data-show-toggle="true" 
						 data-show-columns="true" data-search="true" 
						 data-select-item-name="toolbar1" data-pagination="true">
						    <thead>
						    <tr>
						        <th>Username</th>
						        <th>Email</th>
						        <th>Action</th>
						    </tr>
						    </thead>
	<?php
		try {

			$stmt = $db->query('SELECT memberID, username, email FROM blog_members ORDER BY username');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['username'].'</td>';
				echo '<td>'.$row['email'].'</td>';
				?>

				<td>
					<a href="edit-user.php?id=<?php echo $row['memberID'];?>">Edit</a>
					<?php if($row['memberID'] != 1){?>
						| <a href="javascript:deluser('<?php echo $row['memberID'];?>','<?php echo $row['username'];?>')">Delete</a>
					<?php } ?>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

<p><a href='add-user.php' class="btn btn-primary ">Add user</a></p>
						
					</div>
				</div>
			</div>
		</div><!--/.row-->
		
					
				</div>
								
			</div><!--/.col-->
		</div><!--/.row-->
	</div>	<!--/.main-->

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	<script src="js/bootstrap-table.js"></script>
</body>

</html>
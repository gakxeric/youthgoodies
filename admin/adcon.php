 <?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show msg from add / edit page
if(isset($_GET['delmsg'])){ 

	$stmt = $db->prepare('DELETE FROM contact WHERE msgID = :msgID') ;
	$stmt->execute(array(':msgID' => $_GET['delmsg']));

	header('Location: adcon.php?action=deleted');
	exit;
} 

?>
<?php require('adminheader.php'); ?>
<script language="JavaScript" type="text/javascript">
  function delmsg(id, name)
  {
	  if (confirm("Are you sure you want to delete '" + name + "'"))
	  {
	  	window.location.href = 'adcon.php?delmsg=' + id;
	  }
  }
  </script>

	
		   <?php 
	//show msg from add / edit page
	if(isset($_GET['action'])){ 
		echo '<div class="alert bg-success" role="alert">
				<svg class="glyph stroked checkmark">
				<use xlink:href="#stroked-checkmark"></use>
				</svg>msg '.$_GET['action'].'.</div>'; 
	} 
	?>
	<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Messages</div>
					<div class="panel-body">
						<table data-toggle="table"  
						 data-show-refresh="true" data-show-toggle="true" 
						 data-show-columns="true" data-search="true" 
						 data-select-item-name="toolbar1" data-pagination="true">
						    <thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Subject</th>
									<th>msg</th>
									<th>Action</th>
								</tr>
								</thead>
								<?php
									try {

										$stmt = $db->query('SELECT msgID, name, email,subject, msg FROM contact ORDER BY msgID DESC');
										while($row = $stmt->fetch()){
											
											echo '<tr>';
											echo '<td>'.$row['name'].'</td>
											<td>'.$row['email'].'</td>
											<td>'.$row['subject'].'</td>
											<td>'.$row['msg'].'</td>

											';
											?>
											<td>
												<a href="javascript:delmsg('<?php echo $row['msgID'];?>','<?php echo $row['name'];?>')">Delete</a>
											</td>

											
											<?php 
											echo '</tr>';

										}

									} catch(PDOException $e) {
									    echo $e->getmsg();
									}
								?>
							</table>						
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
<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delcat'])){ 

	$stmt = $db->prepare('DELETE FROM blog_cats WHERE catID = :catID') ;
	$stmt->execute(array(':catID' => $_GET['delcat']));

	header('Location: categories.php?action=deleted');
	exit;
} 

?>
<?php require('adminheader.php'); ?>
<script language="JavaScript" type="text/javascript">
  function delcat(id, title)
  {
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
	  	window.location.href = 'categories.php?delcat=' + id;
	  }
  }
  </script>
		   
		   <?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<div class="alert bg-success" role="alert">
				<svg class="glyph stroked checkmark">
				<use xlink:href="#stroked-checkmark"></use>
				</svg>Category '.$_GET['action'].'.</div>'; 
	} 
	?>
	<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Categories</div>
					<div class="panel-body">
						<table data-toggle="table"  
						 data-show-refresh="true" data-show-toggle="true" 
						 data-show-columns="true" data-search="true" 
						 data-select-item-name="toolbar1" data-pagination="true">
						    <thead>
						    <tr>
						        <th>Title</th>
						        <th>Action</th>
						    </tr>
						    </thead>
	<?php
		try {

			$stmt = $db->query('SELECT catID, catTitle, catSlug FROM blog_cats ORDER BY catTitle DESC');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['catTitle'].'</td>';
				?>

				<td>
					<a href="edit-category.php?id=<?php echo $row['catID'];?>">Edit</a> | 
					<a href="javascript:delcat('<?php echo $row['catID'];?>','<?php echo $row['catSlug'];?>')">Delete</a>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
</table>

<p><a href='add-category.php' class="btn btn-primary ">Add Category</a></p>
						
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
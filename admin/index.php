<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delpost'])){ 

	$stmt = $db->prepare('DELETE FROM blog_posts_seo WHERE postID = :postID') ;
	$stmt->execute(array(':postID' => $_GET['delpost']));

	//delete post categories. 
	// $stmt = $db->prepare('DELETE FROM blog_post_cats WHERE postID = :postID');
	// $stmt->execute(array(':postID' => $_GET['delpost']));

	header('Location: index.php?action=deleted');
	exit;
} 

?>
<?php require('adminheader.php'); ?>
		   
		  <?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<div class="alert bg-success" role="alert">
				<svg class="glyph stroked checkmark">
				<use xlink:href="#stroked-checkmark"></use>
				</svg>Post '.$_GET['action'].'.</div>'; 
	} 
	?>
	<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Posts</div>
					<div class="panel-body">
						<table data-toggle="table"  
						 data-show-refresh="true" data-show-toggle="true" 
						 data-show-columns="true" data-search="true" 
						 data-select-item-name="toolbar1" data-pagination="true">
						    <thead>
						    <tr>
						        <th>Title</th>
						        <th>Date</th>
						        <th>Action</th>
						    </tr>
						    </thead>
	<?php
		try {

			$stmt = $db->query('SELECT postID, postTitle, postDate FROM blog_posts_seo ORDER BY postID DESC');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['postTitle'].'</td>';
				echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
				?>

				<td>
					<a href="edit-post.php?id=<?php echo $row['postID'];?>">Edit</a> | 
					<a href="javascript:delpost('<?php echo $row['postID'];?>','<?php echo $row['postTitle'];?>')">Delete</a>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
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

</html>


<?php require('adminheader.php'); ?>

		<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Upload a file
					</div>
					<div class="panel-body">
			 <form method="post" enctype="multipart/form-data" action="upload.php" id="form">
			    <input style="background-color:grey;" type="file" name="uploadFile" id="image" ><br/>
			    <span><input type="submit" class="btn btn-primary" value="Upload" name="upload"></span>
			     
			  </form>

		</div>
		</div>
		</div>
<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	<script src="js/bootstrap-table.js"></script>
</body>

</html>
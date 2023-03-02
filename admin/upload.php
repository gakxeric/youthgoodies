
<?php require('adminheader.php'); ?>

	
		<?php 
		if ($_FILES['uploadFile']['tmp_name']=='') {
			echo '<div class="alert bg-danger" role="alert">
	          <svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg>
	          Please upload a file first</div>';
		}
		else{
		move_uploaded_file($_FILES['uploadFile']['tmp_name'],"../uploads/{$_FILES['uploadFile']['name']}");
		
		$file_name=$_FILES['uploadFile']['name'];
		$add="uploads/$file_name";
		echo '<div class="alert bg-success" role="alert">
	          <svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"></use></svg>
	          '.$add.' has been successfuly uploaded</div>';
	          }
		 ?>
	 <a href="media.php"><input type='submit' name='submit' value='Return to media upload'class="btn btn-primary "></a>
<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	<script src="js/bootstrap-table.js"></script>
</body>

</html>
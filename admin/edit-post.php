<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
  <script>
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
<?php require('adminheader.php'); ?>

	


	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if($postID ==''){
			$error[] = 'This post is missing a valid id!.';
		}

		if($postTitle ==''){
			$error[] = 'Please enter the title.';
		}

		if($postDesc ==''){
			$error[] = 'Please enter the description.';
		}

		if($postCont ==''){
			$error[] = 'Please enter the content.';
		}

		if(!isset($error)){

			try {

				$postSlug = slug($postTitle);

				//insert into database
				$stmt = $db->prepare('UPDATE blog_posts_seo SET postTitle = :postTitle, postSlug = :postSlug, postDesc = :postDesc, postCont = :postCont,category = :category, postimg = :postimg WHERE postID = :postID') ;
				$stmt->execute(array(
					':postTitle' => $postTitle,
					':postSlug' => $postSlug,
					':postDesc' => $postDesc,
					':postCont' => $postCont,
					':category' => $category,
					':postID' => $postID,
					':postimg' => $postimg
				));

				//delete all items with the current postID
				// $stmt = $db->prepare('DELETE FROM blog_post_cats WHERE postID = :postID');
				// $stmt->execute(array(':postID' => $postID));
				//redirect to index page
				header('Location: index.php?action=updated');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	?>


	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}

		try {

			$stmt = $db->prepare('SELECT postID, postTitle, postDesc, postCont, postimg FROM blog_posts_seo WHERE postID = :postID') ;
			$stmt->execute(array(':postID' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>
	<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Edit Post</div>
					<div class="panel-body">
						<div class="col-md-6">
							<form  action='' method='post' name="form">
							<input type='hidden' name='postID' value='<?php echo $row['postID'];?>'>
							
								<div class="form-group">
									<label>Title</label>
									<input class="form-control" type='text' name='postTitle' value='<?php echo $row['postTitle'];?>'>
								</div>
								<div class="form-group">
									<label>Description</label>
									<input class="form-control" type='text' name='postDesc' value='<?php echo $row['postDesc'];?>'>
								</div>
								<div class="form-group">
									<label>Content</label>
									<textarea class="form-control" name='postCont' cols='60' rows='10'><?php echo $row['postCont'];?></textarea>
								</div>
								<div class="form-group">
									<input  type="button"  name='upload' value='add post image' class="btn btn-primary" onclick="addpimg();"><br/>
									<label>Post image</label>
									<input class="form-control" type='text' name='postimg' value='<?php echo $row['postimg'];?>'>
								</div>
								
								<fieldset>
									<?php
									echo '<label for="category">CATEGORIES</label><br/>';
									try {

										$stmt = $db->query('SELECT catID, catTitle, catSlug FROM blog_cats ORDER BY catTitle DESC');
										while($row = $stmt->fetch()){
										
									echo '
						             <input type="radio" name="category" value='.$row['catTitle'].'>'.$row['catTitle'].'<br/>';
						         }
							     } catch(PDOException $e) {
									    echo $e->getMessage();
									}
								?>
								</fieldset>
																
								<input type='submit' name='submit' value='Submit' class="btn btn-primary ">
							</form>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		
	</div><!--/.main-->
<script type="text/javascript">
	function addimg(){
		document.form.postCont.value +="\x3Cimg src=\x22uploads/1.jpg\x22 \x3E";
		
	}
	function addpimg(){
		document.form.postimg.value +="\x3Cimg src=\x22uploads/1.jpg\x22 \x3E";
		
	}
	
	function addvid(){
		document.form.postCont.value +="\x3Cp\x3E \x3C/p\x3E";
		
	}
	function addaud(){
		document.form.postCont.value +="\x3Caudio controls\x3E \x3Csource src=\x22uploads/1.mp3\x22 type=\x22audio/mpeg\x22\x3E\x3C/audio\x3E";
		
	}
</script>
<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	<script src="js/bootstrap-table.js"></script>
</body>

</html>


	
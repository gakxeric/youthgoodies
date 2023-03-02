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
				$stmt = $db->prepare('INSERT INTO blog_posts_seo (postTitle,postSlug,postDesc,postCont,category, postDate, postimg) VALUES (:postTitle, :postSlug, :postDesc, :postCont,:category, :postDate, :postimg)') ;
				$stmt->execute(array(
					':postTitle' => $postTitle,
					':postSlug' => $postSlug,
					':postDesc' => $postDesc,
					':postCont' => $postCont,
					':category' => $category,
					':postDate' => date('Y-m-d H:i:s'),
					':postimg' => $postimg
				));
				$postID = $db->lastInsertId();
				//redirect to index page
				header('Location: index.php?action=added');
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
				<div class="panel panel-primary">
					<div class="panel-heading">Add Post</div>
					<div class="panel-body">
						<div class="col-md-6">
							<form  action='' method='post' name="form">
							
								<div class="form-group">
									<label>Title</label>
									<input class="form-control" type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'>
								</div>
								<div class="form-group">
									<label>Description</label>
									<input class="form-control" type='text' name='postDesc' value='<?php if(isset($error)){ echo $_POST['postDesc'];}?>'>
								</div>
								<div class="form-group">
									<label>Content</label>
									<textarea class="form-control" name='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea>
								</div>
								<div class="form-group">
									<input type="button"  name='upload' value='add post image' class="btn btn-primary" onclick="addpimg();"><br/>
									<label>Post image</label>
									<input class="form-control" type='text' name='postimg' value='<?php if(isset($error)){ echo $_POST['postimg'];}?>'>
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

<?php require('includes/config.php'); 
$stmt = $db->prepare('SELECT postID, postTitle, postCont,category,postimg, postDate FROM blog_posts_seo WHERE postID = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['postID'] == ''){
  header('Location: ./');
  exit;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>YouthExpress | Post</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/animate.css">
<link rel="stylesheet" type="text/css" href="assets/css/slick.css">
<link rel="stylesheet" type="text/css" href="assets/css/theme.css">
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<!--[if lt IE 9]>
<script src="../assets/js/html5shiv.min.js"></script>
<script src="../assets/js/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div id="preloader">
  <div id="status">&nbsp;</div>
</div>
<?php require('head.php'); ?>

  <section id="mainContent">
    <div class="content_bottom">
      <div class="col-lg-8 col-md-8">
        <div class="content_bottom_left">
          <div class="single_page_area">
            <?php
        
          
          echo '<ol class="breadcrumb">
              <li><a href="index.php">Home</a></li>
              <li><a href="category.php?category='.$row['category'].'">'.$row['category'].'</a></li>
              <li class="active">'.$row['postTitle'].'</li>
            </ol>
            <h2 class="post_titile">'.$row['postTitle'].'</h2>
            <div class="single_page_content">
              <div class="post_commentbox"><span><i class="fa fa-calendar"></i>'.$row['postDate'].'</span> <a href="#"><i class="fa fa-tags"></i>'.$row['category'].'</a> </div>
              '.$row['postimg'].'
              <p>'.$row['postCont'].'</p>
              
            </div>';

            {
                    $links = "<a href='c-".$row['category']."'>".$row['category']."</a>";
                }
                

      ?>
            
          </div>
        </div>
<!--         <div class="share_post"> <a class="facebook" href="#"><i class="fa fa-facebook"></i>Facebook</a> <a class="twitter" href="#"><i class="fa fa-twitter"></i>Twitter</a> <a class="googleplus" href="#"><i class="fa fa-google-plus"></i>Google+</a> <a class="linkedin" href="#"><i class="fa fa-linkedin"></i>LinkedIn</a> <a class="stumbleupon" href="#"><i class="fa fa-stumbleupon"></i>StumbleUpon</a> <a class="pinterest" href="#"><i class="fa fa-pinterest"></i>Pinterest</a> </div>
 -->      </div>
      <div class="col-lg-4 col-md-4">
        <div class="content_bottom_right">
          <div class="single_bottom_rightbar">
            <h2>Recent Post</h2>
            <ul class="small_catg popular_catg wow fadeInDown">
            <?php
                try {
                     $pages = new Paginator('6','p');
                  $stmt = $db->query('SELECT postID FROM blog_posts_seo');

                  //pass number of records to
                  $pages->set_total($stmt->rowCount());

                  $stmt = $db->query('SELECT postID, postTitle, postSlug, postDesc,category, postDate, postimg FROM blog_posts_seo WHERE category = "General" ORDER BY postID DESC '.$pages->get_limit());
                  while($row = $stmt->fetch()){
                    echo 
                      '
                        <li>
                        <div class="media wow fadeInDown">
                        <a href="viewpost.php?id='.$row['postID'].'" class="media-left">'.$row['postimg'].'</a>
                          <div class="media-body">
                            <h4 class="media-heading"><a href="#">'.$row['postTitle'].' </a></h4>
                            <p>'.$row['postDesc'].'</p>
                          </div>
                        </div>
                      </li>
                      ';
                      

                        {
                            $links = "<a href='c-".$row['category']."'>".$row['category']."</a>";
                        }
                  
                  }


                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
              ?>
              
            </ul>
          </div>
          <!-- <div class="single_bottom_rightbar wow fadeInDown">
            <h2>Popular Lnks</h2>
            <ul>
              <li><a href="#">Blog</a></li>
              <li><a href="#">Blog Home</a></li>
              <li><a href="#">Error Page</a></li>
              <li><a href="#">Social link</a></li>
              <li><a href="#">Login</a></li>
            </ul>
          </div> -->
        </div>
      </div>
    </div>
  </section>
</div>
<?php require('footer.php'); ?>
<script src="assets/js/jquery.min.js"></script> 
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/wow.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/custom.js"></script>
</body>
</html>
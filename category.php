<?php require('includes/config.php'); 
$stmt = $db->prepare('SELECT category FROM blog_posts_seo WHERE category= :category');
$stmt->execute(array(':category' => $_GET['category']));
$row = $stmt->fetch();
?>
<!DOCTYPE html>
<html>
<head>
<title>YouthExpress | <?php echo $row['category'];?></title>
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
<script src="assets/js/html5shiv.min.js"></script>
<script src="assets/js/respond.min.js"></script>
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
          <div class="single_category wow fadeInDown">
            <div class="archive_style_1">
            <?php
                try {
                  $pages = new Paginator('20','p');

                  $stmt = $db->query('SELECT postID FROM blog_posts_seo');

                  //pass number of records to
                  $pages->set_total($stmt->rowCount());

                  $stmt = $db->prepare('SELECT * FROM blog_posts_seo WHERE category= :category ORDER BY postID DESC '.$pages->get_limit());
                  $stmt->execute(array(':category' => $row['category'])); 
                  echo '<h2> <span class="bold_line"><span></span></span> <span class="solid_line"></span> <span class="title_text">'.$row['category'].'</span> </h2>';
                  while($row = $stmt->fetch()){
                    echo 
                      '

                      <div class="business_category_left wow fadeInDown">
                        <ul class="fashion_catgnav">
                          <li>
                            <div class="catgimg2_container"> <a href="viewpost.php?id='.$row['postID'].'">'.$row['postimg'].'</a> </div>
                            <h2 class="catg_titile"><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h2>
                            <div class="comments_box"> <span class="meta_date">'.$row['postDate'].'</span> <span class="meta_comment"><a href="#">No Comments</a></span> <span class="meta_more"><a  href="#">Read More...</a></span> </div>
                            <p>'.$row['postDesc'].'</p>
                          </li>
                        </ul>
                      </div>
                    
                      ';
                      

                        {
                            $links = "<a href='c-".$row['category']."'>".$row['category']."</a>";
                        }
                  
                  }


                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
              ?>
              
            </div>
          </div>
        </div>
        <!-- <div class="pagination_area">
          <nav>
            <ul class="pagination">
              <li><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li><a href="#"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
            </ul>
          </nav>
        </div> -->
      </div>
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
            </div>
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
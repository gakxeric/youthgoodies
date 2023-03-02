<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html>
<head>
<title>YouthExpress</title>
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
    <div class="content_top">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm6">
          <div class="latest_slider">
            <div class="slick_slider">
              <?php
                try {
                  $pages = new Paginator('3','p');

                  $stmt = $db->query('SELECT postID FROM blog_posts_seo');

                  //pass number of records to
                  $pages->set_total($stmt->rowCount());

                  $stmt = $db->query('SELECT postID, postTitle, postSlug, postDesc,category, postDate, postimg FROM blog_posts_seo WHERE category = "Opportunities" ORDER BY postID DESC '.$pages->get_limit());
                  while($row = $stmt->fetch()){
                    echo 
                      '<div class="single_iteam">'.$row['postimg'].'
                        <h2><a class="slider_tittle" href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h2>
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
        <div class="col-lg-6 col-md-6 col-sm6">
          <div class="content_top_right">
            <ul class="featured_nav wow fadeInDown">
            <?php
                try {
                     $pages = new Paginator('4','p');
                  $stmt = $db->query('SELECT postID FROM blog_posts_seo');

                  //pass number of records to
                  $pages->set_total($stmt->rowCount());

                  $stmt = $db->query('SELECT postID, postTitle, postSlug, postDesc,category, postDate, postimg FROM blog_posts_seo WHERE category = "General" ORDER BY postID DESC '.$pages->get_limit());
                  while($row = $stmt->fetch()){
                    echo 
                      '<li>'.$row['postimg'].'
                          <div class="title_caption"><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></div>
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
    </div>
    
    <div class="content_bottom">
      <div class="col-lg-8 col-md-8">
        <div class="content_bottom_left">
          <div class="single_category wow fadeInDown">
            <div class="archive_style_1">
              <h2> <span class="bold_line"><span></span></span> <span class="solid_line"></span> <span class="title_text">Latest Updates</span> </h2>
              <?php
                try {
                     $pages = new Paginator('8','p');
                  $stmt = $db->query('SELECT postID FROM blog_posts_seo');

                  //pass number of records to
                  $pages->set_total($stmt->rowCount());

                  $stmt = $db->query('SELECT postID, postTitle, postSlug, postDesc,category, postDate, postimg FROM blog_posts_seo WHERE category = "General" ORDER BY postID DESC '.$pages->get_limit());
                  while($row = $stmt->fetch()){
                    echo 
                      '
                        <div class="business_category_left wow fadeInDown">
                          <ul class="fashion_catgnav">
                            <li>
                              <div class="catgimg2_container"> <a href="viewpost.php?id='.$row['postID'].'">'.$row['postimg'].'</a> </div>
                              <h2 class="catg_titile"><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h2>
                              <div class="comments_box"> <span class="meta_date">'.$row['postDate'].'</span> <span class="meta_comment"><span class="meta_date">No Comments</span> <span class="meta_more"><a  href="viewpost.php?id='.$row['postID'].'">Read More...</a></span> </div>
                              <p>'.$row['postDesc'].'</p>
                            </li>
                          </ul>
                        </div>
  
                      ';
                      

                        {
                            $links = "<a href='c-".$row['category']."'>".$row['category']."</a>";
                        }
                 
                  
                  }
                   echo $pages->page_links();


                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
              ?>

            </div>
          </div>
        </div>
        
      </div>
      <?php require('ads.php'); ?>
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
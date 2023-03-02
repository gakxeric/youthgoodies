<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html>
<head>
<title>YouthExpress | Contact</title>
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
<?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        $_POST = array_map( 'stripslashes', $_POST );

        //collect form data
        extract($_POST);

        //very basic validation
        if($name ==''){
            $error[] = 'Please enter the title.';
        }

        if($email ==''){
            $error[] = 'Please enter the description.';
        }

        if($subject ==''){
            $error[] = 'Please enter the content.';
        }

        

        if(!isset($error)){

            try {


                //insert into database
                $stmt = $db->prepare('INSERT INTO contact (name,email,subject,msg) VALUES (:name, :email, :subject, :msg)') ;
                $stmt->execute(array(
                    ':name' => $name,
                    ':email' => $email,
                    ':subject' => $subject,
                    ':msg' => $msg
                ));
                $conID = $db->lastInsertId();
                header('Location: contact.php?action=sent');
                exit;

            } catch(PDOException $e) {
                echo $e->getmsg();
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
    <section id="ContactContent">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="contact_area">
            <h1>Contact Us</h1>
           <center><h2>We would love to hear from you.</h2></center>
            <div class="contact_bottom">
              <div class="contact_us wow fadeInRightBig">
                <form method="post" name="contact" action="#" class="contact_form">
                  <input type="text" id="author" name="name" value="<?php if(isset($error)){ echo $_POST['name'];}?>" placeholder="Name(required)" required>
                  <input type="email" id="email" name="email" value="<?php if(isset($error)){ echo $_POST['email'];}?>" placeholder="E-mail(required)" required>
                  <input type="text" name="subject" value="<?php if(isset($error)){ echo $_POST['subject'];}?>" id="subject" placeholder="Subject" required>
                  <textarea id="text" name="msg" value="<?php if(isset($error)){ echo $_POST['msg'];}?>" placeholder="msg(required)" required></textarea>
                  <input type="submit" value="send" id="submit" name="submit" >
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<?php require('footer.php'); ?>
<script src="assets/js/jquery.min.js"></script> 
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/wow.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/custom.js"></script>
</body>
</html>
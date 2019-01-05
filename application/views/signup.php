
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentellela Alela! | </title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url();?>assets/css/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://colorlib.com/polygon/gentelella/css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>assets/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        

        <div id="register" class="animate form">
          <section class="login_content">
		 <?php   echo $this->session->flashdata('message_name'); ?>

             <form method="post" action="http://careermarshalletters.com/app/signup/business">
              <h1>Create Account</h1>
			   <div>
                <input type="text" class="form-control" name="username" placeholder="Username" required="" />
              </div>
              <div>
                <input type="text" class="form-control" name="fname" placeholder="First Name" required="" />
              </div>
			   <div>
                <input type="text" class="form-control" name="lname" placeholder="Last Name" required="" />
              </div>
              <div>
                <input type="email" class="form-control" name="email"  placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password"  placeholder="Password" required="" />
              </div>
              <div>
                 <input class="btn btn-default submit" type="submit" name="submit" value="Sign Up" >
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <!--<p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>-->

                <div class="clearfix"></div>
                <br />

                <div>
                  <p>©2016 All Rights Reserved</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
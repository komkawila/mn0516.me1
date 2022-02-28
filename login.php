<?php include 'includes/session.php'; ?>
<?php
  if(isset($_SESSION['user'])){
    header('location: cart_view.php');
  }
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition login-page ">
<div class="login-box">
  	<?php
     if(isset($_SESSION['warning'])){
      echo "
        <div class='callout callout-warning text-center'>
          <p>".$_SESSION['warning']."</p> 
        </div>
      ";
      unset($_SESSION['warning']);
    }
      if(isset($_SESSION['error'])){
        echo "
          <div class='callout callout-danger text-center'>
            <p>".$_SESSION['error']."</p> 
          </div>
        ";
        unset($_SESSION['error']);
      }
      if(isset($_SESSION['success'])){
        echo "
          <div class='callout callout-success text-center'>
            <p>".$_SESSION['success']."</p> 
          </div>
        ";
        unset($_SESSION['success']);
      }
    ?>
  	<div class="login-box-body ">
    	<h4 class="login-box-msg text-success">เข้าสู่ระบบ online by me</h4>

    	<form action="verify.php" method="POST">
      		<div class="form-group  has-success has-feedback">
        		<input type="email" class="form-control" name="email" placeholder="Email" required>
        		<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      		</div>
          <div class="form-group has-success has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
      		<div class="row">
    			<div class="col-xs-12">
          			<button type="submit" class="btn btn-success btn-block btn-flat" name="login"><i class="fa fa-sign-in"></i> Sign In</button>
        		</div>
      		</div>
    	</form>
      <br>
      <a href="signup.php" class="text-center text-success">สมัครเป็นสมาชิก</a><br>
      <a href="index.php" class="text-success"><i class="fa fa-home "></i> Home</a>
  	</div>
</div>
	
<?php include 'includes/scripts.php' ?>
</body>
</html>
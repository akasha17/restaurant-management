<?php
  session_start();
  $con = mysqli_connect("localhost","root","","restaurant");
  if (isset($_POST['submit'])) 
  {
    $sql2 = "select * from admin where username='" . $_POST['username']. "' and password='" .$_POST['password'] . "' ";
    $res2 = mysqli_query($con, $sql2);
    if($array3 = mysqli_fetch_array($res2))
    {
      $_SESSION['admin_id']=$array3['admin_id'];
      $_SESSION['username']=$array3['username'];
     header("location:dashboard.php");
       }
       else
       {
        echo"<script>alert('email or password is wrong!!')</script>";
    }
  }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restaurant Management Admin</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body style="background-color: #E2E2E2;">
    <div class="container">
        <div class="row text-center " style="padding-top:100px;">
            <div class="col-md-12">
                <h1>Login Page</h1>
            </div>
        </div>
         <div class="row ">
               
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                           
                            <div class="panel-body">
                                <form role="form" method="POST">
                                    <hr />
                                    <h5>Enter Details to Login</h5>
                                       <br />
                                     <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                            <input type="text" name="username" class="form-control" placeholder="Your Username " pattern="[A-Za-z ]+" title="Please enter only alphabetic characters" required />
                                        </div>
                                                                              <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="password" name="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least 8 characters, including at least one uppercase letter, one lowercase letter, and one digit"   placeholder="Your Password" required />
                                        </div>
                                   <!--  <div class="form-group">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" /> Remember me
                                            </label>
                                            <span class="pull-right">
                                                   <a href="index.html" >Forget password ? </a> 
                                            </span>
                                        </div> -->
                                     
                                     <button type="submit" name="submit" class="btn btn-primary ">Login Now</button>
                                    <hr />
                                    Not register ? <a href="register.php" >click here </a> 
                                    </form>
                            </div>
                           
                        </div>
                
                
        </div>
    </div>

</body>
</html>

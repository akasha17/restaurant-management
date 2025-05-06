<?php 
session_start();
    $con = mysqli_connect("localhost","root","","restaurant");

    if(isset($_POST['submit']))
    {
        $sql2 = "select * from staff where email='" . $_POST['email']. "' and password='" .$_POST['password'] . "' ";
 
        $result = mysqli_query($con,$sql2);

        if($array3 = mysqli_fetch_array($result))
        {
            $_SESSION['staff_id']=$array3['staffid'];
            $_SESSION['staff_name']=$array3['fname'];
            header("location:dashboard.php");
        }
        else
        {
            echo"<script>alert('Email or Password is wrong!!')</script>";
        }
    }
?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restaurant Management Staff</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES -->
    <link href="assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
    <!--CUSTOM BASIC STYLES-->
    <link href="assets/css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">RESTAURANT MANAGEMENT</a>
            </div>
        </nav>
            <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Staff Login</h1>
                        

                    </div>
                </div>
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-6">
                       <div class="panel panel-default">
                        <div class="panel-heading">
                          
                        </div>
                        <div class="panel-body">
                            <form method="POST">
                            
                            <div class="form-group">
                                <label class="control-label col-lg-4">Email</label>
                                <input type="email" name="email" placeholder="Email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Please enter a valid email address" required />
                            </div>
                           
                            <div class="form-group">
                                <label class="control-label col-lg-4">Password</label>
                                <input type="password" name="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least 8 characters, including at least one uppercase letter, one lowercase letter, and one digit" required/>
                            </div>
                            <button type="submit" name="submit" class="btn btn-danger">Login </button><br>
                             Not register ? <a href="register.php" >click here </a> 
                            </form>
                        </div> 
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    <!-- /. WRAPPER  -->
    <div id="footer-sec">
        &copy; 2023 YourCompany |
    </div>
    <!-- /. FOOTER  -->

    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- PAGE LEVEL SCRIPTS -->
    <script src="assets/js/bootstrap-fileupload.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>


</body>
</html>

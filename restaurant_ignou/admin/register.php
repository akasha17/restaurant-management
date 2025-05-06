<?php
$con = mysqli_connect("localhost","root","","restaurant");

if(isset($_POST['submit']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $role=$_POST['role'];

    $password = $_POST['password'];
   

   

        $q="insert into admin(username,email,phone,role,password)values('$name','$email','$phone','$role','$password')";
        $result = mysqli_query($con,$q);

        if($result)
        {
            echo "<script>alert('Registered sucessfully!!');window.location = 'index.php';</script>";
        }
        else
        {
            echo "<script>alert('Not Registered sucessfully!!')</script>";
        }
    }
  
  ?>      
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Responsive Bootstrap Advance Admin Template</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!--CUSTOM BASIC STYLES-->
    <link href="assets/css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        
           
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Register Page</h1>
                        <!-- <h1 class="page-subhead-line">This is dummy text , you can replace it with your original text. </h1> -->

                    </div>
                </div>
                <!-- /. ROW  -->
                <div class="row">
        
<div class="col-md-6 col-sm-6 col-xs-12">
               <div style="justify-content: center;" class="panel panel-danger">
                        <div class="panel-heading">
                           Registration
                        </div>
                        <div class="panel-body">
                            <form method="post" role="form" >
                                        
                                 <div class="form-group">
                                            <label>User Name</label>
                                            <input class="form-control" name="name"type="text" pattern="[A-Za-z ]+" title="Please enter only alphabetic characters" required>
                                     
                                        </div>
                                            <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control"name="email" type="email"  pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Please enter a valid email address" required>
                                     
                                        </div>
                                <div class="form-group">
                                            <label>Phone No.</label>
                                            <input class="form-control"name="phone" type="text"  maxlength="10" pattern="[0-9]{10}" title="Please enter 10 digits" required>
                                    
                                        </div>
                                        <div class="form-group">
    <label for="role">Role</label>
    <input class="form-control" id="role" name="role" type="text" pattern="[a-zA-Z]+" title="Please enter only letters" required>
</div>

                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control"name="password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least 8 characters, including at least one uppercase letter, one lowercase letter, and one digit" required>
                                     
                                        </div>
                                 
                                        <button type="submit" name="submit" class="btn btn-danger">Register </button>

                                    </form>
                            </div>
                        </div>
                            </div>
        </div>
            
        </div>

            </div>
           
        </div>
        
    </div> -->
    <!-- /. WRAPPER  -->
    <!-- <div id="footer-sec"> -->
        <!-- &copy; 2014 YourCompany | Design By : <a href="http://www.binarytheme.com/" target="_blank">BinaryTheme.com</a> -->
    <!-- </div> -->
    <!-- /. FOOTER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME--> -->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>


</body>
</html>

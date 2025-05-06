<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Online Restaurant Management System</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- owl css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- awesome fontfamily -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
        <style type="text/css">
            .custom-width {
    width: 400px; /* Adjust the width as needed */
}

        </style>

        
</head>
<!-- body -->

<body class="main-layout Contact_page">




<?php
$con = mysqli_connect("localhost", "root", "", "restaurant");
$errors = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['Phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    // Check if any field is empty
    if (empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($address) || empty($password)) {
        $errors[] = "Please fill in all fields.";
    } else {
        // Validation for First Name and Last Name (Alphabetic characters only)
        if (!preg_match("/^[a-zA-Z]+$/", $fname) || !preg_match("/^[a-zA-Z]+$/", $lname)) {
            $errors[] = "First name and last name must contain only alphabetic characters.";
        }
        // Validation for Email
        if (!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $email)) {
            $errors[] = "Please enter a valid email.";
        }
        // Validation for Phone Number (10 digits)
        if (!preg_match("/^\d{10}$/", $phone)) {
            $errors[] = "Phone number must contain 10 digits.";
        }
        // Validation for Address
//        if (!preg_match("/^\d+$/", $address)) {
//     $errors[] = "Please enter a valid address. Address field may contain both digits and characters.";
// } 
        if (is_numeric($address)) {
    $errors[] = "Address field cannot contain only digits.";
}

        // If there are no errors, proceed with inserting data into the database
        if (empty($errors)) {
            $q = "INSERT INTO customer(fname, lname, email, phone, address, password)
                    VALUES('$fname', '$lname', '$email', '$phone', '$address', '$password')";
            $result = mysqli_query($con, $q);
            if ($result) {
    // Display an alert indicating successful registration
    echo "<script>alert('Registered successfully!');</script>";

    // Redirect to sign in page
    header("Location: sign in.php");
    exit(); // Stop further execution
} else {
    $errors[] = "Error registering user. Please try again later.";
}

        }
    }
}
?>


<!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="" /></div>
    </div>

    <div class="wrapper">
    <!-- end loader -->

     

    <div id="content">
    <!-- header -->
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- <div class="full">
                        <a class="logo" href="index.html"><img src="images/logo.png" alt="#" /></a>
                    </div> -->
                </div>
                <div class="col-md-9">
                    <div class="full">
                        
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- end header -->
    <!-- footer -->
    <fooetr>
        <div class="footer">
             <?php if (!empty($errors)): ?>
        <script>
            alert("<?php echo implode('\n', $errors); ?>");
        </script>
    <?php endif; ?>
            <div class="container-fluid">
                <div class="row"  style="margin-left: 180px;">
                  <div class=" col-md-12">
                    <h2 style="margin-top: -80px; margin-left: 60px;">Sign Up</h2>
                  </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                      
                      <form method="post" class="main_form">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="width: 400px;">
            <label for="fname">First Name:</label>
            <input class="form-control" placeholder="Enter Firstname" type="text" name="fname" id="fname" pattern="[A-Za-z ]+" title="Please enter only alphabetic characters" required>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <label for="lname">Last Name:</label>
            <input class="form-control" placeholder="Enter Lastname" type="text" name="lname" id="lname" pattern="[A-Za-z ]+" title="Please enter only alphabetic characters" required>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <label for="email">Email:</label>
            <input class="form-control" placeholder="Enter Email" type="email" name="email" id="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Please enter a valid email address" required>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <label for="Phone">Phone No.:</label>
            <input class="form-control" placeholder="Enter Phone no." type="text" name="Phone" id="Phone" maxlength="10" pattern="[0-9]{10}" title="Please enter 10 digits" required>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <label for="address">Address:</label>
            <input class="form-control" placeholder="Enter Address" type="text" name="address" id="address" pattern=".*" title="You can enter any value here that should be valid" required>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <label for="password">Password:</label>
            <input class="form-control" placeholder="Enter Password" type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least 8 characters, including at least one uppercase letter, one lowercase letter, and one digit" required>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <button class="send" type="submit" name="submit">Submit</button>
        </div>
    </div>
</form>


                    </div>
                    
                </div>
               
        </div>
        <div>
            
        </div>
    </fooetr>
    <!-- end footer -->

    </div>
    </div>
    <div class="overlay"></div>
    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>
     <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    
     <script src="js/jquery-3.0.0.min.js"></script>
    <!--  <script>
    // Function to check if a string contains digits
    function containsDigits(str) {
        return /\d/.test(str);
    }

    // Function to handle form submission
    function validateForm() {
        var fname = document.getElementById('fname').value;
        var lname = document.getElementById('lname').value;

        // Check if first name contains digits
        if (containsDigits(fname)) {
            alert('First name cannot contain digits');
            return false; // Prevent form submission
        }

        // Check if last name contains digits
        if (containsDigits(lname)) {
            alert('Last name cannot contain digits');
            return false; // Prevent form submission
        }

        // If everything is fine, allow form submission
        return true;
    }
</script> -->



   <script type="text/javascript">
        $(document).ready(function() {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function() {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            <!-- $('#sidebarCollapse').on('click', function() {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>


</body>

</html>
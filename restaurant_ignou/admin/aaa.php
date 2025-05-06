<?php

$con = mysqli_connect("localhost", "root", "", "home");

session_start();

if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
<?php

if (isset($_POST['submit'])) 
{
   $pro_name=$_POST['pname'];
   $order_id=$_POST['oid'];
   $price=$_POST['amount'];
   $qnty=$_POST['qnty'];
   $total=$_POST['total_amount'];
   $name=$_POST['cname'];
  
  $date = date("Y-m-d");

   $q="insert into payment(pro_name,order_id,price,quantity,total_amount,cname,card_num,exp,cvv,pay_date,status)values('$pro_name','$order_id','$price','$qnty','$total','$name','$date','Paid')";

    if (mysqli_query($con, $q)) {
        // Get the inserted payment table ID (PID)
        $pid = mysqli_insert_id($con);

        echo '<script type="text/javascript">
            alert("Payment successful! Your Payment ID (PID) is: ' . $pid . '");
            window.location.href = "receipt.php?pid=' . $pid . '";
          </script>';
    exit();
} else {
    echo "Error: " . mysqli_error($con);
}

  
}

?>


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
      <title>Evonyee - Responsive HTML5 Template</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- site icons -->
      <link rel="icon" href="img/fevicon.png" type="image/png" />
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css" />
      <!-- site css -->
      <link rel="stylesheet" href="css/style.css" />
      <!-- responsive css -->
      <link rel="stylesheet" href="css/responsive.css" />
      <!-- colors css -->
      <link rel="stylesheet" href="css/colors.css" />
      <!-- custom css -->
      <link rel="stylesheet" href="css/custom.css" />
      <!-- wow animation css -->
      <link rel="stylesheet" href="css/animate.css" />
      <!-- Revolution Loaling Fonts and Icons  -->
      <link rel="stylesheet" href="js/revolution/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css">
      <!-- Revolution style Sheets  -->
      <link rel="stylesheet" href="js/revolution/css/settings.css">
      <link rel="stylesheet" href="js/revolution/css/layers.css">
      <link rel="stylesheet" href="js/revolution/css/navigation.css">
      <!-- owl stylesheets -->
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="css/owl.theme.default.css">
      

    <!-- Your existing scripts and stylesheets -->

    <!-- Add the script here -->
    <!-- <script>
        // Fetch data from sessionStorage
        var orderData = JSON.parse(sessionStorage.getItem('orderData'));
        var username = sessionStorage.getItem('username');

        // Check if orderData and username are available
        if (orderData && username) {
            // Update the form fields with the fetched data
            document.getElementById('pname').value = orderData[0].name; // Assuming the first item in the array
            document.getElementById('amount').value = orderData[0].price; // Assuming the first item in the array
            document.getElementById('qnty').value = orderData[0].quantity; // Assuming the first item in the array
            document.getElementById('total_amount').value = (orderData[0].price * orderData[0].quantity).toFixed(2);
            document.getElementById('cname').value = username;
        }
    </script> -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body id="default_theme" class="contact">
      
      <!-- header -->
      <div id="mySidenav" class="sidenav">
         <ul class="menu_sidebar">
            <li><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></li>
            <li><a href="index.html">01. Home</a></li>
            <li><a href="about.html">02. About</i></a></li>
            <li><a href="what_we_do.html">03. What we do</a></li>
            <li><a href="testimonial.html">04. Testimonial</a></li>
            <li><a href="contact.html">05. Contact Us</a></li>
         </ul>
      </div>
      <header class="header">
         <div class="header_top">
            <div class="container">
               <div class="row">
                  <div class="col-md-4">
                     <div class="full">
                        <span class="toggle_icon" style="cursor:pointer" onclick="openNav()"><img src="img/menu_icon.png" alt="#" /></span>
                        <!-- <div class="logo_circle">
                           <a href="index.html"><img class="img-responsive" src="img/logo.png" alt="#" /></a>
                        </div> -->
                     </div>
                  </div>
                  <!-- <div class="col-md-8">
                     <div class="float-right">
                        <ul class="top_links">
                           <li><a href="#"><img src="images/profile_icon.png" alt="#" /></a></li>
                           <li class="searchbar">
                              <input class="search_input" type="text" name="" placeholder="Search...">
                              <a href="#" class="search_icon"><img src="images/search_icon.png" alt="#" /></a>
                           </li>
                        </ul> 
                     </div>
                  </div> -->
               </div>
            </div>
         </div>
      </header>
      <!-- end header -->
      <!-- Start Banner Slider -->
      <div id="inner_pade" class="banner-slider">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <div class="full">
                      <h2>Payment Page</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- End Banner Slider -->
      
      <!-- section -->
      <section class="layout_padding request_form">
         <div class="container">
            <div class="row">

               <div class="col-md-8 offset-md-2">
                  <div class="full text_align_center">
                     <h3>BUY YOUR ITEM NOW...</h3>
                     
                  </div>
                 <div class="full">
    <h3>Selected Products</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody id="productTableBody">
            <!-- Product information will be dynamically added here -->
        </tbody>
    </table>
</div>
                        <div class="full field">
                            <label>Customer Name</label>
                            <input type="text" name="cname" placeholder="Customer Name" required="" id="cname" />
                        </div>
                                 <div class="full field">
                                    <label>Card Number</label>
                                     <input type="text" name="cnum" placeholder="Card Number" required=""  id="cnum" />
                                 </div>
                                 <div class="full field">
    <label>Expiry</label>
    <input type="month" name="exp" placeholder="Expiry Date" required="" id="exp" />
</div>

                                 <div class="full field">
                                    <label>CVV</label>
                                     <input type="password" name="cvv" id="cvv" placeholder="CVV" required="" />
                                 </div>
                                 <div class="full field">
    <label>Date</label>
    <input type="text" name="date" id="date" placeholder="Date" required="" value="<?php echo date("d-m-Y"); ?>" readonly />
</div>

                                 

                                 
                               
                                 <div class="full field center">
                                   <button  type="submit" name="submit">Make Payment</button> 
                                 </div>
                              </div>
                            </div>
                         
                         </fieldset>
                      </form>
                  </div>
               </div>

            </div>
         </div>
      </section>
      <!-- end section -->

      <!-- end footer -->
      <footer>
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-12">
                  <div class="full footer_top">
                     <div class="container">
                        <div class="row">
                           <div class="col-sm-3">
                              
                              
                           </div>
                           <div class="col-sm-3">
                              
                              <div class="full">
                                 <ul class="footer_link">
                                    <li><a href="index.php">Home</a></li>
                                   
                        
                                    <li><a href="what_we_do.php">What we do</a></li>
                                    <li><a href="products.php">Products</a></li>

                                    <li><a href="testimonial.php">Testimonial</a></li>
                                    <li><a href="contact.php">Contact us</a></li>
                                 </ul>
                              </div>
                           </div>
                           <div class="col-sm-3">
                             
                              <div class="full">
                                 <ul class="footer_link_intas">
                                    <li>
                                       <span><img src="images/f_in_blog.png" alt="#" /></span>
                                       <span>Decorate your life</span>
                                    </li>
                                    <li>
                                       <span><img src="images/f_in_blog2.png" alt="#" /></span>
                                       <span>Decorate your dream</span>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                           
                           <div class="col-md-12">
                              <div class="row margin_top_50">
                                 <div class="col-md-10 offset-md-1">
                                    <div class="row">
                                       <div class="col-sm-4">
                                          <div class="full cont_info">
                                             <i class="fa fa-map-marker"></i>
                                             <span>mysore</span>
                                          </div>
                                       </div>
                                       <div class="col-sm-4">
                                          <div class="full cont_info">
                                             <i class="fa fa-phone"></i>
                                             <span>Call 8593931812</span>
                                          </div>
                                       </div>
                                       <div class="col-sm-4">
                                          <div class="full cont_info">
                                             <i class="fa fa-envelope" style="font-size: 17px;"></i>
                                             <span>dhyankoorara@gmail.com</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- cpy -->
      <div class="cpy">
               <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="full center">
                     
                  </div>
                  
               </div>
            </div>
         </div>
      </div>
      <!-- end cpy -->
      <!-- jQuery (necessary for Bootstrap's JavaScript) -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <!-- javascript -->
      <script src="js/owl.carousel.js"></script>
      <!-- wow animation -->
      <script src="js/wow.js"></script>
      <!-- menumaker -->
      <script src="js/menumaker.js"></script>
      <!-- custom js -->
      <script src="js/custom.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Add the script here -->
<script>
    // Fetch data from sessionStorage
    var orderData = JSON.parse(sessionStorage.getItem('orderData'));
    var username = sessionStorage.getItem('username');

    // Check if orderData and username are available
    if (orderData && username) {
        // Initialize variables to store total
        var total = 0;

        // Update the form fields with the fetched data
        for (var i = 0; i < orderData.length; i++) {
            total += orderData[i].price * orderData[i].quantity;
        }

        // Update the form fields with the data
        document.getElementById('pname').value = orderData.map(item => item.name).join(', ');
        document.getElementById('amount').value = orderData.map(item => item.price).join(', ');
        document.getElementById('qnty').value = orderData.map(item => item.quantity).join(', ');
        document.getElementById('total_amount').value = total.toFixed(2);
        document.getElementById('cname').value = username;

        // Display selected product information in a table
        var tableBody = document.getElementById('productTableBody');
        for (var i = 0; i < orderData.length; i++) {
            var newRow = tableBody.insertRow(-1);
            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);

            cell1.innerHTML = orderData[i].name;
            cell2.innerHTML = orderData[i].price;
            cell3.innerHTML = orderData[i].quantity;
        }
    }

    // Function to calculate total amount
    function calculateTotal(orderData) {
        var total = 0;
        for (var i = 0; i < orderData.length; i++) {
            total += orderData[i].price * orderData[i].quantity;
        }
        return total;
    }
</script>


   </body>
</html>
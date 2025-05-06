<script>
    $(document).ready(function () {
        // Add an event listener to update subtotal when quantity changes
        $('.quantity-input').on('input', function () {
            updateSubtotal(this);
        });

        // Function to update the subtotal
        function updateSubtotal(input) {
            var quantity = $(input).val();
            var price = $(input).closest('tr').find('td:eq(2)').text(); // Assuming the price is in the third column

            var subtotal = (parseFloat(price) * parseInt(quantity)).toFixed(2);

            // Update the subtotal cell in the same row
            $(input).closest('tr').find('td:eq(5)').html(subtotal);
        }
    });
</script>
   <script type="text/javascript">
        $(document).ready(function() {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function() {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>

    <style>
    #owl-demo .item{
        margin: 3px;
    }
    #owl-demo .item img{
        display: block;
        width: 100%;
        height: auto;
    }
    </style>

     
      <script>
         $(document).ready(function() {
           var owl = $('.owl-carousel');
           owl.owlCarousel({
             margin: 10,
             nav: true,
             loop: true,
             responsive: {
               0: {
                 items: 1
               },
               600: {
                 items: 2
               },
               1000: {
                 items: 5
               }
             }
           })
         })
      </script>

</body>

</html>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>

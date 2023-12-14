<?php
include("config.php");

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "http://pospal.jimtech.solutions:5000/customers");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
$response = curl_exec($curl);
curl_close($curl);
$customers = json_decode($response, true);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "http://pospal.jimtech.solutions:5000/products");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
$response = curl_exec($curl);
curl_close($curl);
$products = json_decode($response, true);

?>

<!DOCTYPE html>
<html>

<head>
  <?php include("components/meta.php"); ?>
  <title></title>
  <!-- Favicon -->
  <link href="assets/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">


  <!-- Argon CSS -->
  <link type="text/css" href="assets/css/argon.css?v=1.0.0" rel="stylesheet">

</head>

<body>
  <?php include("components/side_nav.php"); ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <div class=" d-none d-md-flex ml-lg-auto"></div>

        <!-- User -->
        <?php include("components/top_nav.php"); ?>
      </div>
    </nav>
    <!-- Header -->

    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-7">
      <div class="container-fluid">
        <div class="header-body">
        </div>
      </div>

    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7 ">
      <div class="row " style="min-height: 75vh; margin: 0 auto;">
        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-10 mb-3" style="margin: 0 auto;">
          <div class=" card bg-secondary shadow ">
            <div class=" card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Create Order</h3>
                </div>

              </div>
            </div>
            <div class="card-body">
              <span id="alertmsg"></span>
              <form method="POST" id="form">

                <div class="form-group">
                  <label for="customer" class="form-control-label">Customer Name</label>
                  <select name="customer" class="form-control" id="customer">
                    <option selected disabled>Select Customer</option>
                    <?php
                    foreach ($customers as $customer) {
                      $i++;
                      echo '
                        <option value="' . $customer['customer_id'] . '">' . $customer['name'] . '</option>
                      ';
                    } ?>
                  </select>
                </div>
                <div class="row clearfix">
                  <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="tab_logic">
                      <thead>
                        <tr>
                          <th class="text-center"> # </th>
                          <th class="text-center"> Product </th>
                          <th class="text-center"> Qty </th>
                          <th class="text-center"> Price </th>
                          <th class="text-center"> Total </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr id='addr0'>
                          <td>1</td>
                          <td>

                            <select name="product[]" class="form-control">
                              <option selected disabled>Select Product</option>
                              <?php
                              foreach ($products as $product) {
                                $i++;
                                echo '
                        <option value="' . $product['product_id'] . '" price="' . $product['price'] . '">' . $product['name'] . '</option>
                      ';
                              } ?>
                            </select>

                          </td>
                          <td><input type="number" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0" /></td>
                          <td><input type="number" name='price[]' placeholder='Enter Unit Price' class="form-control price" step="0.00" min="0" disabled /></td>
                          <td><input type="number" name='total[]' placeholder='0.00' class="form-control total" readonly /></td>
                        </tr>
                        <tr id='addr1'></tr>
                      </tbody>
                    </table>
                  </div>
                  <div class=" mt-3">
                    <div class="col-md-12">
                      <button id="add_row" class="btn btn-default pull-left" type="button">Add Row</button>
                      <button id='delete_row' class="pull-right btn btn-default" type="button">Delete Row</button>
                    </div>
                  </div>
                </div>
                <div class="form-group mt-4">
                  <label for="quantity" class="form-control-label">Grand Total</label>
                  <input class="form-control" type="number" name='total_amount' id="total_amount" readonly>
                </div>

                <button type="submit" class=" btn btn-primary" submitBtn>Submit</button>

              </form>
            </div>
          </div>
        </div>

      </div>

      <?php include("components/footer.php"); ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Argon JS -->
  <script src="assets/js/argon.js?v=1.0.0"></script>

  <script>
    $('[submitBtn]').on('click', function(event) {
      event.preventDefault();

      if (!$('#form select[name="customer"]').val()) {
        var alertmsg = '<div class="alert alert-danger" role="alert">Customer is not selected.</div>';
        $('#alertmsg').html(alertmsg);
        return;
      }

      var products = [];
      $('#form select[name="product[]"]').each(function(index) {
        var productId = $(this).val();
        var quantity = $('#form input[name="qty[]"]').eq(index).val();

        if (productId && quantity) {
          products.push({
            product_id: parseFloat(productId),
            quantity: parseFloat(quantity)
          });
        } else {
          var alertmsg = '<div class="alert alert-danger" role="alert">There is an empty input in products.</div>';
          $('#alertmsg').html(alertmsg);
          return false;
        }
      });

      // Check if any products were added
      if (products.length === 0) {
        var alertmsg = '<div class="alert alert-danger" role="alert">No products added.</div>';
        $('#alertmsg').html(alertmsg);
        return; // Stop the function if no products are added
      }

      // Get customer ID
      var customerId = $('#form select[name="customer"]').val();

      // Create JSON object from form inputs
      var formData = {
        customer_id: customerId,
        products: products
      };

      console.log(formData);

      $.ajax({
        type: "POST",
        url: "http://pospal.jimtech.solutions:5000/orders",
        data: JSON.stringify(formData),
        contentType: "application/json",
        dataType: "json",
        success: function(response) {
          console.log(response);

          if (response != null) {
            $('#alertmsg').html('<div class="alert alert-success mb-3" role="alert">The order was successfully created. Reloading the page in 3 seconds.</div>');
            window.setTimeout(function() {
              window.location.href = '';
            }, 3000);
          }
        },
        error: function(xhr, status, error) {
          console.error("Error response:", status, error);
          var errorMsg = '<div class="alert alert-danger mb-3" role="alert">There was a problem creating the order. Please try again.</div>';
          $('#alertmsg').html(errorMsg);
        }
      });
    });
  </script>

  <script>
    $(document).ready(function(e) {

      $('#form').on('change', 'select[name="product[]"]', function() {
        var pid = $(this).val();

        var priceField = $(this).parents('tr').find('input[name="price[]"]');

        $.ajax({
          type: "GET",
          url: `http://pospal.jimtech.solutions:5000/products/${pid}`,
          dataType: "json", // Expect a JSON response
          success: function(response) {
            console.log(response);

            priceField.val(response.price);

          },
          error: function(xhr, status, error) {
            console.error("Error response:", status, error);
            var errorMsg = '<div class="alert alert-danger mb-3" role="alert">There was a problem adding the supplier. Please try again.</div>';
            $('#alertmsg').html(errorMsg);
          }
        });
      });

      var i = 1;
      $("#add_row").click(function() {
        b = i - 1;
        $('#addr' + i).html($('#addr' + b).html()).find('td:first-child').html(i + 1);
        $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
        i++;
      });
      $("#delete_row").click(function() {
        if (i > 1) {
          $("#addr" + (i - 1)).html('');
          i--;
        }
        calc();
      });

      $('#tab_logic tbody').on('keyup change', function() {
        calc();
      });
    });

    function calc() {
      $('#tab_logic tbody tr').each(function(i, element) {
        var html = $(this).html();
        if (html != '') {
          var qty = $(this).find('.qty').val();
          var price = $(this).find('.price').val();
          $(this).find('.total').val(qty * price);

          calc_total();
        }
      });
    }

    function calc_total() {
      total = 0;
      $('.total').each(function() {
        total += parseInt($(this).val());
      });
      $('#sub_total').val(total.toFixed(2));
      $('#total_amount').val((total).toFixed(2));
    }
  </script>

</body>



</html>
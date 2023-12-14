<?php
include("config.php");

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "http://http://pospal.jimtech.solutions:5000//suppliers");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
$response = curl_exec($curl);
curl_close($curl);
$suppliers = json_decode($response, true);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "http://http://pospal.jimtech.solutions:5000//products");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
$response = curl_exec($curl);
curl_close($curl);
$products = json_decode($response, true);

if (!isset($_GET['id'])) {
  header("Location: inventory.php");
} else {
  $id = $_GET['id'];

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, "http://http://pospal.jimtech.solutions:5000//inventory/$id");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HEADER, false);
  $response = curl_exec($curl);
  curl_close($curl);

  $data = json_decode($response, true);
  if ($data != null) {
  } else {
    header("Location: inventory.php");
  }
}

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
  <link href="assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
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
        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-6 mb-3" style="margin: 0 auto;">
          <div class=" card bg-secondary shadow ">
            <div class=" card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Edit Inventory</h3>
                </div>

              </div>
            </div>
            <div class="card-body">
              <span id="alertmsg"></span>
              <form method="POST" id="form">

                <input type="hidden" value="<?php echo $id; ?>" name="uid">

                <div class="form-group">
                  <label for="product" class="form-control-label">Product</label>
                  <select name="product" class="form-control" id="product">
                    <option selected disabled>Select Product</option>
                    <?php
                    foreach ($products as $product) {
                      $i++;
                      echo '
                        <option value="' . $product['product_id'] . '" ';
                      if ($data['product_id'] === $product['product_id']) {
                        echo 'selected';
                      }
                      echo
                      '>' . $product['name'] . '</option>
                      ';
                    } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="supplier" class="form-control-label">Supplier</label>
                  <select name="supplier" class="form-control" id="supplier">
                    <option selected disabled>Select Supplier</option>
                    <?php
                    foreach ($suppliers as $supplier) {
                      $i++;
                      echo '
                        <option value="' . $supplier['supplier_id'] .
                        '" ';
                      if ($data['supplier_id'] === $supplier['supplier_id']) {
                        echo 'selected';
                      }
                      echo
                      '>' . $supplier['name'] . ' (' . $supplier['contact_name'] . ')</option>
                      ';
                    } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="quantity" class="form-control-label">Quantity</label>
                  <input class="form-control" type="number" id="quantity" name="quantity" value="<?php echo $data['quantity']; ?>">
                </div>

                <button type="submit" class=" btn btn-primary" submitBtn>Update</button>

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

      $uid = $('#form input[name="uid"]').val();

      // Check if inputs are filled
      if (
        (!$('#form select[name="product"]').val()) ||
        (!$('#form select[name="supplier"]').val()) ||
        (!$('#form input[name="quantity"]').val())
      ) {
        var alertmsg = '<div class="alert alert-danger" role="alert">There is an empty input.</div>';
        $('#alertmsg').html(alertmsg);
        return; // Stop the function if inputs are empty
      }

      // Create JSON object from form inputs
      var formData = {
        product_id: $('#form select[name="product"]').val(),
        supplier_id: $('#form select[name="supplier"]').val(),
        quantity: $('#form input[name="quantity"]').val()
      };

      $.ajax({
        type: "PUT",
        url: `http://http://pospal.jimtech.solutions:5000//inventory/${$uid}`,
        data: JSON.stringify(formData), // Convert formData to a JSON string
        contentType: "application/json", // Set content type to JSON
        dataType: "json", // Expect a JSON response
        success: function(response) {
          console.log(response);

          if (response != null) {
            $('#alertmsg').html('<div class="alert alert-success mb-3" role="alert">The supplier was successfully edited. Reloading the page in 3 seconds.</div>');
            window.setTimeout(function() {
              window.location.href = 'inventory.php';
            }, 3000);
          }
        },
        error: function(xhr, status, error) {
          console.error("Error response:", status, error);
          var errorMsg = '<div class="alert alert-danger mb-3" role="alert">There was a problem editing the supplier. Please try again.</div>';
          $('#alertmsg').html(errorMsg);
        }
      });
    });
  </script>

</body>



</html>
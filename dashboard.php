<?php
include('config.php');
phpinfo();

// Initialize cURL session
$curl = curl_init();

// Set cURL options
curl_setopt($curl, CURLOPT_URL, API_HOST . "/dashboard");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);

// Execute cURL session and get the response
$response = curl_exec($curl);

// Close cURL session
curl_close($curl);

// Decode JSON response
$data = json_decode($response, true);


// Initialize cURL session
$curl = curl_init();

// Set cURL options
curl_setopt($curl, CURLOPT_URL, "http://127.0.0.1:5000/orders");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);

// Execute cURL session and get the response
$response = curl_exec($curl);

// Close cURL session
curl_close($curl);

// Decode JSON response
$orders = json_decode($response, true);

// Initialize cURL session
$curl = curl_init();

// Set cURL options
curl_setopt($curl, CURLOPT_URL, "http://127.0.0.1:5000/products");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);

// Execute cURL session and get the response
$response = curl_exec($curl);

// Close cURL session
curl_close($curl);

// Decode JSON response
$productsData = json_decode($response, true);

?>

<!DOCTYPE html>
<html>

<head>
  <?php include("components/meta.php"); ?>
  <title><?php echo SITE_NAME; ?>- Dashboard</title>
  <!-- Favicon -->
  <link href="./assets/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="./assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
  <link href="./assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
  <!-- Argon CSS -->
  <link type="text/css" href="./assets/css/argon.css?v=1.0.0" rel="stylesheet">
</head>

<body>
  <?php include("components/side_nav.php"); ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="#">Dashboard</a>
        <!-- Form -->

        <?php include("components/top_nav.php"); ?>
      </div>
    </nav>
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Sales</h5>
                      <span class="h2 font-weight-bold mb-0">₱
                        <?php echo $data[0]['total_sales']; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                        <i class="fa fa-home"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-muted">Total sales overall</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Orders</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $data[0]['total_orders']; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                        <i class="fa fa-calendar"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-nowrap">Total orders in the database</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Unique Customers</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $data[0]['unique_customers']; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                        <i class="fa fa-users"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-muted">Unique Customers</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Products</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $data[0]['total_products']; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                        <i class="fa fa-cart-plus"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-muted">Total Available Products</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row mt-5">
        <div class="col-xl-6 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Recent Orders</h3>
                </div>
                <div class="col text-right">
                  <a href="manage_orders.php" class="btn btn-sm btn-primary">See all</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Products</th>
                    <th scope="col">Total</th>
                    <th scope="col">Date Ordered</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0;
                  foreach ($orders as $row) {
                    $i++;

                    $products = explode(', ', $row['products']);
                    $quantities = explode(', ', $row['quantities']);

                    echo '
                    <tr>
                      <td>' . $i . '</td>
                      <td>' . $row['customer_name'] . '</td>
                      <td>
                      <ul class="mb-0 pl-0">';
                    foreach ($products as $index => $product) {
                      echo '<li>' . $product . ' (' . $quantities[$index] . ')</li>';
                    }
                    echo '
                      </ul>
                      </td>
                      <td>₱ ' . $row['total_amount'] . '</td>
                      <td>' . $row['order_date'] . '</td>
                    

                    </tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-xl-6">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3>Products</h3>
                </div>
                <div class="col text-right">
                  <a href="products.php" class="btn btn-sm btn-primary">See all</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price</th>
                    <th scope="col">Stock</th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0;
                  foreach ($productsData as $row) {
                    $i++;
                    echo '
                    <tr>
                      <td>' . $i . '</td>
                      <td>' . $row['name'] . '</td>
                      <td>' . $row['category'] . '</td>
                      <td>' . $row['price'] . '</td>
                      <td>' . $row['stock_quantity'] . '</td>
                      

                    </tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>


      <?php include("components/footer.php"); ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="./assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="./assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Optional JS -->
  <script src="./assets/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="./assets/vendor/chart.js/dist/Chart.extension.js"></script>
  <!-- Argon JS -->
  <script src="./assets/js/argon.js?v=1.0.0"></script>
</body>

</html>
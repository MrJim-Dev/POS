<?php

include("config.php");

// Initialize cURL session
$curl = curl_init();

// Set cURL options
curl_setopt($curl, CURLOPT_URL, "http://pospal.jimtech.solutions:5000/inventory");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);

// Execute cURL session and get the response
$response = curl_exec($curl);

// Close cURL session
curl_close($curl);

// Decode JSON response
$data = json_decode($response, true);

?>


<!DOCTYPE html>
<html>

<head>
  <?php include("components/meta.php"); ?>
  <title><?php echo SITE_NAME; ?> - Inventory</title>
  <!-- Favicon -->
  <link href="assets/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
  <link href="assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

  <link href="assets/css/jquery.dataTables.min.css" rel="stylesheet">

  <!-- Tags Input -->
  <link rel="stylesheet" href="assets/css/bootstrap-tagsinput.css" />

  <!-- Argon CSS -->
  <link type="text/css" href="assets/css/argon.css?v=1.0.0" rel="stylesheet">
  <style>
    td {
      white-space: normal !important;
    }

    .form-group {
      margin-bottom: 10px;
    }
  </style>
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
    <div class="container-fluid mt--7">
      <div class="row " style="min-height: 75vh;">

        <!-- Table -->
        <div class="col-md-12 col-sm-12 col-lg-12">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Manage Inventory</h3>
                </div>
                <div class="col text-right">
                  <a class="btn btn-sm btn-primary" href="add_inventory.php">Add Inventory</a>
                </div>
              </div>
            </div>

            <div class="table-responsive ">
              <table class="table align-items-center table-flush " id="questionTable">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product</th>
                    <th scope="col">Supplier</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Date Added</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0;
                  foreach ($data as $row) {
                    $i++;
                    echo '
                    <tr>
                      <td>' . $i . '</td>
                      <td>' . $row['product_name'] . '</td>
                      <td>' . $row['supplier_name'] . '</td>
                      <td>' . $row['quantity'] . '</td>
                      <td>' . $row['date_added'] . '</td>
                      <td class="text-right">
                        <div class="dropdown">
                          <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" uid="' . $row['inventory_id'] . '">
                            <a class="dropdown-item" href="edit_inventory.php?id=' . $row['inventory_id'] . '" >Edit</a>
                            <a class="dropdown-item" href="#" delItem>Delete</a>
                          </div>
                      </td>

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

  <!-- Add Modal -->
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="addModalLabel">Add Supplier</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <span id="addmsg"></span>
          <form method="POST" id="addModalForm">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Name</label>
                  <input type="text" class="form-control" name="name">
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Contact Name</label>
                  <input type="text" class="form-control" name="contact_name">
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">phone</label>
                  <input type="text" class="form-control" name="phone">
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Address</label>
                  <input type="text" class="form-control" name="address">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer pt-0">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" addModalSubmit>Add Supplier</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="editModalLabel">Editing Supplier</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <span id="editmsg"></span>
          <form method="POST" id="editModalForm">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Name</label>
                  <input type="text" class="form-control" name="name">
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Contact Name</label>
                  <input type="text" class="form-control" name="contact_name">
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">phone</label>
                  <input type="text" class="form-control" name="phone">
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Address</label>
                  <input type="text" class="form-control" name="address">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer pt-0">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" editModalSubmit>Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <script src="assets/js/bootstrap-tagsinput.js"></script>
  <script src="assets/js/jquery.dataTables.min.js"></script>

  <!-- Argon JS -->
  <script src="assets/js/argon.js?v=1.0.0"></script>

  <script>
    $(document).ready(function() {

    });
    // Add Modal
    $('[toggleAddModal]').on('click', function() {
      $('#addModal').modal();
    });

    $('[addModalSubmit]').on('click', function(event) {
      event.preventDefault();

      // Check if inputs are filled
      if (
        (!$('#addModalForm input[name="name"]').val()) ||
        (!$('#addModalForm input[name="contact_name"]').val()) ||
        (!$('#addModalForm input[name="phone"]').val()) ||
        (!$('#addModalForm input[name="address"]').val())
      ) {
        var addmsg = '<div class="alert alert-danger" role="alert">There is an empty input.</div>';
        $('#addmsg').html(addmsg);
        return; // Stop the function if inputs are empty
      }

      // Create JSON object from form inputs
      var formData = {
        name: $('#addModalForm input[name="name"]').val(),
        contact_name: $('#addModalForm input[name="contact_name"]').val(),
        phone: $('#addModalForm input[name="phone"]').val(),
        address: $('#addModalForm input[name="address"]').val(),
      };

      $.ajax({
        type: "POST",
        url: "http://pospal.jimtech.solutions:5000/suppliers",
        data: JSON.stringify(formData), // Convert formData to a JSON string
        contentType: "application/json", // Set content type to JSON
        dataType: "json", // Expect a JSON response
        success: function(response) {
          console.log(response);

          if (response != null) {
            $('#addmsg').html('<div class="alert alert-success mb-3" role="alert">The supplier was successfully added. Reloading the page in 3 seconds.</div>');
            window.setTimeout(function() {
              window.location.href = '';
            }, 3000);
          }
        },
        error: function(xhr, status, error) {
          console.error("Error response:", status, error);
          var errorMsg = '<div class="alert alert-danger mb-3" role="alert">There was a problem adding the supplier. Please try again.</div>';
          $('#addmsg').html(errorMsg);
        }
      });
    });


    $('[toggleEditModal]').on('click', function() {
      var uid = $(this).parent().attr('uid');
      var d1 = $(this).parents('tr').find("td:eq(1)").html();
      var d2 = $(this).parents('tr').find("td:eq(2)").html();
      var d3 = $(this).parents('tr').find("td:eq(3)").html();
      var d4 = $(this).parents('tr').find("td:eq(4)").html();



      $('#editModalForm input[name="name"]').val(d1);
      $('#editModalForm input[name="contact_name"]').val(d2);
      $('#editModalForm input[name="phone"]').val(d3);
      $('#editModalForm input[name="address"]').val(d4);



      $('#editModal').modal();

      $('[editModalSubmit]').on('click', function() {
        event.preventDefault();

        // Check if inputs are filled
        if (
          (!$('#editModalForm input[name="name"]').val()) ||
          (!$('#editModalForm input[name="contact_name"]').val()) ||
          (!$('#editModalForm input[name="phone"]').val()) ||
          (!$('#editModalForm input[name="address"]').val())
        ) {
          var edit = '<div class="alert alert-danger" role="alert">There is an empty input.</div>';
          $('#edit').html(edit);
          return; // Stop the function if inputs are empty
        }

        // Create JSON object from form inputs
        var formData = {
          name: $('#editModalForm input[name="name"]').val(),
          contact_name: $('#editModalForm input[name="contact_name"]').val(),
          phone: $('#editModalForm input[name="phone"]').val(),
          address: $('#editModalForm input[name="address"]').val(),
        };

        $.ajax({
          type: "PUT",
          url: `http://pospal.jimtech.solutions:5000/suppliers/${uid}`,
          data: JSON.stringify(formData), // Convert formData to a JSON string
          contentType: "application/json", // Set content type to JSON
          dataType: "json", // Expect a JSON response
          success: function(response) {
            console.log(response);

            if (response != null) {
              $('#editmsg').html('<div class="alert alert-success mb-3" role="alert">The supplier was successfully edited. Reloading the page in 3 seconds.</div>');
              window.setTimeout(function() {
                window.location.href = '';
              }, 3000);
            }
          },
          error: function(xhr, status, error) {
            console.error("Error response:", status, error);
            var errorMsg = '<div class="alert alert-danger mb-3" role="alert">There was a problem editing the supplier. Please try again.</div>';
            $('#editmsg').html(errorMsg);
          }
        });


      });

    });

    $("[delItem]").on("click", function() {
      var uid = $(this).parent().attr('uid');
      var tr = $(this).parents('tr');

      $.ajax({
        type: "DELETE",
        url: `http://pospal.jimtech.solutions:5000/inventory/${uid}`,
        success: function(response) {
          console.log(response);

          if (response != null) {
            tr.fadeOut(500);
          }
        },
        error: function(xhr, status, error) {
          alert("Error response:", status, error);
        }
      });

    });
  </script>
</body>

</html>
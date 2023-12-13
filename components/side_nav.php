<!-- Sidenav -->
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0 pb-0" href="../index.php">
            <img src="./assets/img/pospal.png" class="navbar-brand-img pb-0 mt-3" alt="..." height="30">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ni ni-bell-55"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="./assets/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome!</h6>
                    </div>
                    <a href="./examples/profile.html" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>My profile</span>
                    </a>
                    <a href="./examples/profile.html" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>Settings</span>
                    </a>
                    <a href="./examples/profile.html" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>Activity</span>
                    </a>
                    <a href="./examples/profile.html" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>Support</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#!" class="dropdown-item">
                        <i class="ni ni-user-run"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="./index.php">
                            <img src="./assets/img/logo.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>

            <h6 class="navbar-heading text-muted">General</h6>

            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">
                        <i class="fa fa-home text-default"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="./products.php">
                        <i class="fa fa-cart-plus text-default"></i> Products
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="./customers.php">
                        <i class="fa fa-users text-default"></i> Customers
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="./suppliers.php">
                        <i class="fa fa-male text-default"></i> Suppliers
                    </a>
                </li>

            </ul>



            <!-- Divider -->
            <hr class="my-3">

            <h6 class="navbar-heading text-muted">Inventory</h6>

            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="add_inventory.php">
                        <i class="fa fa-cube text-default"></i>Add Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inventory.php">
                        <i class="fa fa-cubes text-default"></i> Manage Inventory
                    </a>
                </li>
            </ul>

            <!-- Divider -->
            <hr class="my-3">

            <h6 class="navbar-heading text-muted">Orders</h6>

            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="create_order.php">
                        <i class="fa fa-plus text-default"></i>Add Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_orders.php">
                        <i class="fa fa-calendar text-default"></i> Manage Orders
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>
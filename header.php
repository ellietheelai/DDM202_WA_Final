<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS → -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <title>Bootstrap Exercise</title>
    </head>
    <body>
    <nav class="navbar navbar-expand-sm navbar-light bg-light" aria-label="Third navbar example">
        <div class="container-fluid" bis_skin_checked="1">
            <a class="navbar-brand" href="#">Online Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03"
                aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample03" bis_skin_checked="1">
                <ul class="navbar-nav ms-auto px-5 mb-2 mb-sm-0">
                    <li class="nav-item dropdown px-3">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown"
                            aria-expanded="false">Products</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="products_create.php">Create Product</a></li>
                            <li><a class="dropdown-item" href="products_index.php">Read Product</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown"
                            aria-expanded="false">Category</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="category_create.php">Create Category</a></li>
                            <li><a class="dropdown-item" href="category_index.php">Read Category</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown"
                            aria-expanded="false">Customers</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="customer_create.php">Create Customer</a></li>
                            <li><a class="dropdown-item" href="customer_index.php">Read Customer</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown px-3">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown"
                            aria-expanded="false">Orders</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="order_create.php">Create Order</a></li>
                            <li><a class="dropdown-item" href="order_index.php">Read Order</a></li>
                        </ul>
                    </li>
                    <li>
                    <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    </body>
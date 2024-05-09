<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pay bill</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="/assets/css/style.css" rel="stylesheet">
  <style>
    .card-img-top {
        height: 10px; /* Set a fixed height for the card image */
        max-height: 200px;
        object-fit: cover; /* Ensure the image covers the entire space */
    }
  </style>

</head>
<body>
  <div class="position-absolute top-0 start-50 translate-middle-x mt-3">
    <h1 class="ms-4">Pay Bills</h1>
    <div class="my-5"><img src="/assets/img/paybill1.png" alt="" class="logo"></div>
  </div>

  <div class="row position-absolute top-50 start-50 translate-middle ms-4 mt-5">
    <div class="col-md-5">
      <div class="card flex-grow-1 me-2 h-100"> <!-- Added h-100 class for fixed height -->
        <img src="/assets/img/elec1.png" class="card-img-top w-100 h-100" alt="..."> <!-- Added w-100 and h-100 classes for fixed width and height -->
        <div class="card-body">
          <h5 class="card-title">Electricity</h5>
          <p class="card-text">Pay Electricity</p>
          <a href="#" class="btn btn-primary">Pay</a>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="card flex-grow-1 h-100"> <!-- Added h-100 class for fixed height -->
        <img src="/assets/img/water1.png" class="card-img-top w-100 h-100" alt="..."> <!-- Added w-100 and h-100 classes for fixed width and height -->
        <div class="card-body">
          <h5 class="card-title">Water</h5>
          <p class="card-text">Pay Water</p>
          <a href="#" class="btn btn-primary">Pay</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

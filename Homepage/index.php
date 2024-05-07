<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Account</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <div class="container mt-3">
    <h1>My Account</h1>
    <div class="card mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <h5 class="card-title">Balance</h5>
            <p class="card-text fs-1">$<span id="balance">999</span></p>
          </div>
          <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary">Transfer</button>
            <button type="button" class="btn btn-secondary">Top Up</button>
            <button type="button" class="btn btn-info">Pay Bill</button>
            <button type="button" class="btn btn-dark">Withdraw</button>
          </div>
        </div>
      </div>
    </div>
    
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    // Replace with your JavaScript to fetch balance data from MySQL database
    // and update the #balance element's content
    fetch('/get_balance.php')
      .then(response => response.json())
      .then(data => {
        document.getElementById('balance').textContent = data.balance;
      })
      .catch(error => console.error(error));
  </script>
</body>
</html>

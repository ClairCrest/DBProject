<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0; /* Light grey color */
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100"> <div class="position-absolute top-0 start-50 translate-middle-x">
    <div class="text-center">
        <div class="mt-3">
            <h2 class="mb-1 mx-3">Account</h2>
            <h3 class="mt-0">012-3-***456</h3>
            <h1 class="mx-2 mb-5">999 THB</h1>
        </div>
    </div>

        <div class="mt-5">
            <h2 class="my-0 mx-5">Transfer To</h2>
            <div class="row">
                <div class="col-md-auto">
                    <input type="text" class="form-control mx-3" id="Account_No" name="Account_No" placeholder="Account No">
                </div>
            </div>

            <h2 class="my-3 mx-5">Amount</h2>
            <div class="row">
                <div class="col-md-auto">
                    <input type="text" class="form-control mx-3" id="Amount" name="Amount" placeholder="Amount">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-5">
                    <a class="btn btn-danger btn-primary w-100 mx-1" href="/Homepage/" role="button">Back</a>
                </div>
                <div class="col-md-5">
                    <a class="btn btn-success btn-primary w-100 mx-5" href="/slip/" role="button">Confirm</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

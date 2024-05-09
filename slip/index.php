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
        .centered-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center; /* Center its child elements horizontally */
        }
        .logo {
            max-width: 200px; /* Set maximum width for the logo */
            height: auto; /* Maintain aspect ratio */
        }
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 20px; /* Adjust the top margin as needed */
        }
    </style>
</head>
<body>
    <div class="centered-content">
        <img src="/assets/img/Transfer1.png" alt="" class="logo">
        <h1 class="text-center mt-3">Transaction Successful</h1>
        <h2 class="text-center mt-3">Amount</h2>
        <h1 class="text-center mt-2">20.00 THB</h1>
        <h2 class="text-center mt-5">From Account</h2>
        <h1 class="text-center mt-1">012-3-***456</h1>
        <h2 class="text-center mt-5">To Account</h2>
        <h1 class="text-center mt-1 mb-5">987-6-***543</h1>ฃ
        <a class="btn btn-success btn-primary w-75 position-absolute bottom-0 start-50 translate-middle-x" href="/Homepage/" role="button">Done</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

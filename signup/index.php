<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/assets/css/style.css" rel="stylesheet">
  </head>
  <body>
  <div class="container mt-3">
    <h1>KMUTT666 Registration</h1>
    <form> <div class="row">
        <div class="col-md-6 mb-3">
          <label for="firstname" class="form-label">Name</label>
          <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter Firstname">
        </div>
        <div class="col-md-6 mb-3">
          <label for="lastname" class="form-label">Lastname</label>
          <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Lastname">
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="citizenID" class="form-label">CitizenID</label>
          <input type="text" class="form-control" id="citizenID" name="citizenID" placeholder="Enter Citizen ID">
        </div>
        <div class="col-md-6 mb-3">
          <label for="telephone" class="form-label">Telephone</label>
          <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Telephone">
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
        </div>
        <div class="col-md-6 mb-3">
          <label for="province" class="form-label">Province</label>
          <input type="text" class="form-control" id="province" name="province" placeholder="Enter Province">
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="text" class="form-control" id="password" name="password" placeholder="Enter Password">
        </div>
        <div class="col-md-6 mb-3">
          <label for="confirm_password" class="form-label">Confirm Password</label>
          <input type="text" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
        </div>
      </div>
      
      <button type="submit" class="btn btn-primary position-absolute bottom-0 start-50 translate-middle-x"><a href="/Homepage/">Register</a></button>

    </form>
    <a href="/Homepage/">
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
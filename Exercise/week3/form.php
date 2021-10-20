<!DOCTYPE html>
<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS → -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
  <title>PHP exercise</title>
</head>

<body>

  <?php
  if ($_GET) {
    echo $_GET["fname"];
    echo "</br>";
    echo $_GET["lname"];
    echo "</br>";
    echo $_GET["hobby"];
  }
  ?>

  <h2>HTML Forms</h2>

  <form action="action.php" method="GET">
    <div class="input-group m-3">
      <span class="input-group-text" id="fname">First Name</span>
      <input type="text" class="form-control" name="fname" aria-label="fname" aria-describedby="inputGroup-sizing-default">
    </div>

    <div class="input-group m-3">
      <span class="input-group-text" id="lname">Last Name</span>
      <input type="text" class="form-control" name="lname" aria-label="lname" aria-describedby="inputGroup-sizing-default">
    </div>

    <div class="input-group m-3">
      <span class="input-group-text" id="hobby">Hobby</span>
      <select class="form-select-m px-3" name="hobby" aria-label="hobby">
        <option selected>Select Your Hobby</option>
        <option value="redesign">Redesign</option>
        <option value="gaming">Gaming</option>
        <option value="fishing">Fishing</option>
      </select>
    </div>

    <div class="col-sm-10 m-3">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>


  <p>If you click the "Submit" button, the form-data will be sent to a page called "/action_page.php".</p>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
</body>

</html>
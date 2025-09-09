<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 Page Not Found</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      text-align: center;
    }

  

    .container img {
      width: 100%;
      height: 7rem;
     
      object-fit: contain;
    }

    .message {
      color:black;
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 2rem;
    }
    .btn-secondary{
      background-color: #f15028;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none !important;
      display: inline-block;
      font-weight:700;
      letter-spacing: 1.5px;
      font-size: 1.2rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="{{ env('URL_LOGO') }}" alt="404">
    <h1 style="font-size:3rem !important; font-weight:800 !important; ">Oops</h1>
    <div class="message" >Something went wrong....</div>
    <a href="{{ route('home') }}" class="btn btn-secondary">Back To Homepage</a>
  </div>
</body>
</html>

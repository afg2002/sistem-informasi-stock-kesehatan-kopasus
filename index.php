<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIMALKES Login</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background: #00b3b3;
      background: linear-gradient(45deg, #00b3b3 25%, #00e6e6 75%);
      font-family: Arial, sans-serif;
    }

    .login-container {
      background: #e0f7f7;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
      width: 300px;
    }

    .login-container img {
      width: 100px;
      margin-bottom: 20px;
    }

    .login-container h1 {
      margin: 0;
      font-size: 24px;
      color: #006666;
    }

    .login-container p {
      margin: 5px 0 20px;
      color: #006666;
    }

    .login-container .input-group {
      margin-bottom: 15px;
      position: relative;
    }

    .login-container .input-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .login-container .btn {
      width: 100%;
      padding: 10px;
      background: #007373;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
    }

    .login-container .btn:hover {
      background: #005959;
    }

    .login-container .btn-warning {
      background: #ffaa00;
      color: #fff;
    }

    .login-container .btn-warning:hover {
      background: #cc8800;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <img src="dist/images/logo.png" alt="Logo">
    <h1>SIMALKES</h1>
    <p>Sistem Aplikasi Manajemen Alkes</p>
    <form action="db/proses-login.php" method="POST">
      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Username" name="username">
      </div>
      <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Password" name="password">
      </div>
      <button type="submit" class="btn">Login</button>
    </form>
  </div>
</body>
</html>

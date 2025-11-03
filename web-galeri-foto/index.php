<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Hujan dengan Burung dan Pohon</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #0b0c10;
      font-family: Arial, sans-serif;
      overflow: hidden;
      position: relative;
      height: 100vh;
      color: white;
    }

    /* Efek hujan */
    .rain {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 0;
    }
    .raindrop {
      position: absolute;
      width: 2px;
      height: 15px;
      background: rgba(255, 255, 255, 0.4);
      animation: fall linear infinite;
    }
    @keyframes fall {
      0% {
        transform: translateY(-100px);
        opacity: 0;
      }
      30% {
        opacity: 1;
      }
      100% {
        transform: translateY(100vh);
        opacity: 0;
      }
    }

    /* Burung terbang melintas */
    .bird {
      position: absolute;
      top: 15vh;
      left: -100px;
      width: 100px;
      animation: fly 12s linear infinite;
      z-index: 2;
    }
    @keyframes fly {
      0% {
        left: -120px;
        transform: scaleX(1);
      }
      50% {
        left: 110%;
        transform: scaleX(1);
      }
      50.01% {
        transform: scaleX(-1); /* flip burung balik */
      }
      100% {
        left: -120px;
        transform: scaleX(-1);
      }
    }

    /* Pohon besar di pojok bawah kiri */
    .tree {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 200px;
      z-index: 1;
      user-select: none;
    }

    /* Login Box */
    .login-box {
      position: relative;
      z-index: 3;
      max-width: 350px;
      margin: 100px auto;
      background: rgba(0, 0, 0, 0.7);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px #00f6ff;
      color: white;
    }
    .login-box h2 {
      text-align: center;
      color: #00f6ff;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 5px;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: none;
      border-radius: 5px;
      background: #1c1f26;
      color: white;
    }
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      background: #00f6ff;
      border: none;
      border-radius: 5px;
      color: #000;
      font-weight: bold;
      cursor: pointer;
    }
    input[type="submit"]:hover {
      background: #00d1dd;
    }
  </style>
</head>
<body>

  <!-- Efek hujan -->
  <div class="rain" id="rain"></div>

  <!-- Burung terbang -->
  <img
    src="elang.jpg"
    alt="Burung Terbang"
    class="bird"
  />

  <!-- Pohon besar -->
  <img
    src="pohon.jpg"
    alt="Pohon Besar"
    class="tree"
  />

  <!-- Login Form -->
  <div class="login-box">
    <h2>Login Form</h2>
    <form action="proses_login.php" method="post">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required />

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required />

      <input type="submit" value="Login" />
    </form>
  </div>

  <!-- JS Generate hujan -->
  <script>
    const rain = document.getElementById("rain");
    const jumlahTetes = 150;
    for (let i = 0; i < jumlahTetes; i++) {
      const drop = document.createElement("div");
      drop.classList.add("raindrop");
      drop.style.left = Math.random() * 100 + "vw";
      drop.style.animationDuration = Math.random() * 0.5 + 0.5 + "s";
      drop.style.animationDelay = Math.random() * 5 + "s";
      rain.appendChild(drop);
    }
  </script>
</body>
</html>

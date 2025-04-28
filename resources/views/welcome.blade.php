<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FocusMap - Unlock Your Potential</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        nav {
            background-color: transparent;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.8rem;
            color: #fff;
        }
        .nav-link {
            color: #fff !important;
            font-weight: 500;
        }
        .hero {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            padding: 2rem;
            animation: fadeIn 2s ease;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        .btn-custom {
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-login {
            background: #fff;
            color: #4e54c8;
            border: none;
        }
        .btn-login:hover {
            background: #ddd;
            color: #4e54c8;
        }
        .btn-register {
            background: #4e54c8;
            color: #fff;
            border: none;
            margin-left: 10px;
        }
        .btn-register:hover {
            background: #5d62e1;
            color: #fff;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }
        footer {
            text-align: center;
            padding: 1rem;
            color: #fff;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">FocusMap</a>
    <div class="d-flex">
        <a href="/login" class="btn btn-custom btn-login me-2">Login</a>
        <a href="/register" class="btn btn-custom btn-register">Register</a>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <h1>Unlock Your Full Potential</h1>
    <p>Visualize your goals. Track your progress. Stay focused every step of the way.</p>
    <div>
        <a href="/register" class="btn btn-custom btn-register">Get Started</a>
    </div>
</section>

<!-- Footer -->
<footer>
    &copy; 2025 FocusMap. All Rights Reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

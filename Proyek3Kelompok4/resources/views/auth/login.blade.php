<!doctype html>
<html lang="en">
<head>
  <title>AutoAttend - Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.87.0">

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sign-in/">

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{ asset('assets/css/signin.css') }}" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom right, #4a90e2, #50a3a2);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      font-family: 'Arial', sans-serif;
    }
    .form-signin {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      max-width: 400px;
      width: 100%;
      animation: fadeIn 1s ease-in-out;
    }
    .form-signin img {
      margin-bottom: 20px;
    }
    .form-floating {
      margin-bottom: 15px;
    }
    .form-floating input {
      height: 50px;
      padding: 10px;
    }
    .btn-primary {
      background-color: #4a90e2;
      border: none;
      transition: background-color 0.3s, transform 0.3s;
    }
    .btn-primary:hover {
      background-color: #357ab8;
      transform: scale(1.05);
    }
    .btn-primary:focus {
      box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.5);
    }
    .invalid-feedback {
      color: red;
      font-size: 0.875em;
    }
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body class="text-center">
  <main class="form-signin">
    <form action="{{ route('auth.authenticate') }}" method="POST">
      @csrf
      <img class="mb-4" src="{{ asset('assets/img/Logo.png') }}" alt="Logo" width="150" height="120">

      <div class="form-floating">
        <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email" name="email" placeholder="name@example.com">
        <label for="email">Email</label>
        @error('email')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="form-floating">
        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
        <label for="password">Kata Sandi</label>
        @error('password')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div style="margin-top: 10px;">
        <button class="w-100 btn btn-lg btn-primary" type="submit">Masuk</button>
      </div>
      <p class="mt-5 mb-3 text-muted">Kelompok 4 - &copy; 2024</p>
    </form>
  </main>
</body>
</html>

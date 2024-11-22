<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #FFFFE0; /* Light Yellow Background */
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #FFF; /* White Container */
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333; /* Dark Gray Heading */
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555; /* Gray Label */
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50; /* Green Button */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049; /* Darker Green on Hover */
        }

        a {
            color: #007bff; /* Blue Link */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline; /* Underline on Hover */
        }
    </style>
</head>
<body>
    <div class="container">
           <!-- Menampilkan pesan flash jika ada -->
           @if(session('success'))
           <div class="alert alert-success">
               {{ session('success') }}
           </div>
       @endif

       @if($errors->any())
           <div class="alert alert-danger">
               <ul>
                   @foreach($errors->all() as $error)
                       <li>{{ $error }}</li>
                   @endforeach
               </ul>
           </div>
       @endif
<!-- Form login -->
        <form action="{{ route('auth.login') }}" method="POST"> <!-- Ganti dengan 'auth.login.submit' -->
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        
        <p>Belum punya akun? <a href="{{ route('auth.register') }}">Daftar di sini</a></p>          
    </div>
</body>
</html>

<?php
session_start();
include "function/koneksi_login.php";
?>

<html>

<head>
    <title>Login</title>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('./src/img/boiler/background.png') no-repeat center center fixed;
            background-size: cover;
        }

        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }

        .login-container img {
            width: 150px;
            height: 60px;
        }

        .login-container h1 {
            font-size: 24px;
            margin: 20px 0;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-container button:hover {
            background-color: #333;
        }

        .input-container {
            position: relative;
        }

        .input-container i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="shortcut icon" href="./src/img/wings.png" type="image/x-icon">
</head>

<body>
    <div class="login-container">
        <img alt="Company Logo" height="50" src="./src/img/bas.png" />
        <h2>Login</h2>
        <form action="./function/cek_login.php" method="POST">
            <div class="input-container">
                <input name="username" placeholder="Username" type="text" required />
            </div>
            <div class="input-container">
                <input name="password" id="password" placeholder="Password" type="password" required />
                <i id="togglePassword" class="fas fa-eye toggle-password"></i>
            </div>
            <button>Login</button>
        </form>
    </div>

    <!-- SweetAlert untuk menampilkan pesan error -->
    <?php if (isset($_SESSION['login_error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?php echo $_SESSION['login_error']; ?>',
            });
        </script>
        <?php
        // Hapus pesan error setelah ditampilkan
        unset($_SESSION['login_error']);
        ?>
    <?php endif; ?>

    <!-- Script untuk toggle show/hide password -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            // Toggle tipe input dari password ke text atau sebaliknya
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Ganti ikon sesuai dengan tipe input
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
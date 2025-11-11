<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Clastic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #5a7a5f;
            --primary-green-dark: #4a6a4f;
            --light-bg: #e8f2ea;
        }

        body {
            background: linear-gradient(135deg, #e8f2ea 0%, #d4e7d7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

        .login-container {
            max-width: 450px;
            width: 100%;
        }

        .login-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .login-header {
            background: var(--primary-green);
            color: white;
            padding: 3rem 2rem 2.5rem;
            text-align: center;
        }

        .recycle-icon {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .login-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .login-header p {
            margin: 0;
            opacity: 0.95;
            font-size: 1rem;
        }

        .login-body {
            padding: 2.5rem 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .required {
            color: #e53e3e;
            margin-left: 2px;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f7fafc;
        }

        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(90, 122, 95, 0.1);
            background-color: white;
            outline: none;
        }

        .form-control::placeholder {
            color: #a0aec0;
        }

        .form-check {
            padding-left: 1.75rem;
        }

        .form-check-input {
            width: 1.2rem;
            height: 1.2rem;
            border: 2px solid #cbd5e0;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .form-check-label {
            color: #4a5568;
            font-size: 0.95rem;
            cursor: pointer;
            user-select: none;
        }

        .btn-login {
            background: var(--primary-green);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1.05rem;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
            cursor: pointer;
        }

        .btn-login:hover {
            background: var(--primary-green-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(90, 122, 95, 0.25);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .register-link {
            text-align: center;
            margin-top: 1.75rem;
            color: #4a5568;
            font-size: 0.95rem;
        }

        .register-link a {
            color: var(--primary-green);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: var(--primary-green-dark);
            text-decoration: underline;
        }

        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 1.5rem;
            padding: 1rem 1.25rem;
            font-size: 0.95rem;
        }

        .alert-danger {
            background-color: #fed7d7;
            color: #742a2a;
        }

        .mb-3 {
            margin-bottom: 1.25rem;
        }

        @media (max-width: 576px) {
            .login-header {
                padding: 2.5rem 1.5rem 2rem;
            }

            .login-header h1 {
                font-size: 1.75rem;
            }

            .login-body {
                padding: 2rem 1.5rem;
            }

            .recycle-icon {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="recycle-icon">♻️</div>
                <h1>Clastic</h1>
                <p>Selamat datang kembali!</p>
            </div>
            
            <div class="login-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Oops!</strong> {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email <span class="required">*</span>
                        </label>
                        <input 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="nama@email.com"
                            required 
                            autofocus
                        >
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Password <span class="required">*</span>
                        </label>
                        <input 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan password"
                            required
                        >
                    </div>

                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            class="form-check-input" 
                            id="remember" 
                            name="remember"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>

                    <button type="submit" class="btn-login">
                        Masuk
                    </button>
                </form>

                <div class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur - PrêtConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .admin-login-container {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 400px;
            width: 100%;
        }
        .admin-login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .admin-login-header h2 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .admin-login-header p {
            color: #7f8c8d;
            margin: 0;
        }
        .brand-logo {
            color: #e74c3c;
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 12px 15px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #e74c3c;
            box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.25);
        }
        .btn-admin-login {
            background-color: #e74c3c;
            border-color: #e74c3c;
            color: white;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 4px;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-admin-login:hover {
            background-color: #c0392b;
            border-color: #c0392b;
            color: white;
        }
        .form-label {
            color: #2c3e50;
            font-weight: 500;
            margin-bottom: 8px;
        }
        .alert {
            border-radius: 4px;
            border: none;
        }
        .text-center a {
            color: #3498db;
            text-decoration: none;
        }
        .text-center a:hover {
            color: #2980b9;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-right: none;
            color: #6c757d;
        }
        .input-group .form-control {
            border-left: none;
        }
        .security-notice {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            padding: 15px;
            margin-top: 20px;
        }
        .security-notice h6 {
            color: #856404;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .security-notice p {
            color: #856404;
            margin: 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="admin-login-container">
                    <div class="admin-login-header">
                        <div class="brand-logo">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h2>Administration</h2>
                        <p>Accès sécurisé à l'administration</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

<form method="POST" action="{{ route('admin.login') }}">
    @csrf
    
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Administrateur</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email') }}" 
                                       placeholder="admin@pretconnectloan.com" required>
        </div>
        @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                   id="password" name="password" placeholder="••••••••" required>
        </div>
        @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
            Se souvenir de moi
        </label>
    </div>

                        <button type="submit" class="btn btn-admin-login mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Se connecter
        </button>
                    </form>

                    <div class="text-center">
                        <p class="mb-0">Retour à la connexion utilisateur ? 
                            <a href="{{ route('login') }}">Connexion utilisateur</a>
                        </p>
    </div>

                    <div class="security-notice">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Accès Restreint</h6>
                        <p>Cette zone est réservée aux administrateurs autorisés. Toute tentative d'accès non autorisé sera enregistrée.</p>
        </div>
    </div>
    </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
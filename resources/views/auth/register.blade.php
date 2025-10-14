<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - PrêtConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        .register-container {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .register-header h2 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .register-header p {
            color: #7f8c8d;
            margin: 0;
        }
        .brand-logo {
            color: #3498db;
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
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .btn-register {
            background-color: #3498db;
            border-color: #3498db;
            color: white;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 4px;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-register:hover {
            background-color: #2980b9;
            border-color: #2980b9;
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
        .referral-info {
            background: #e8f4fd;
            border: 1px solid #bee5eb;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .referral-info h6 {
            color: #0c5460;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .referral-info p {
            color: #0c5460;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="register-container">
                    <div class="register-header">
                        <div class="brand-logo">
                            <i class="fas fa-coins"></i>
                        </div>
                        <h2>Créer un compte</h2>
                        <p>Rejoignez PrêtConnect et commencez à investir</p>
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

                    <div class="referral-info">
                        <h6><i class="fas fa-gift me-2"></i>Bonus de parrainage</h6>
                        <p>Gagnez jusqu'à 20% des dépôts de vos affiliés sur 5 niveaux !</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">Prénom</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                </div>
                                @error('first_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Nom</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                </div>
                                @error('last_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-at"></i>
                                </span>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                       id="username" name="username" value="{{ old('username') }}" required>
                            </div>
                            @error('username')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="referral_code" class="form-label">Code de parrainage (optionnel)</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-handshake"></i>
                                </span>
                                <input type="text" class="form-control @error('referral_code') is-invalid @enderror" 
                                       id="referral_code" name="referral_code" value="{{ old('referral_code') }}" 
                                       placeholder="Entrez le code de votre parrain">
                            </div>
                            @error('referral_code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Vous recevrez des commissions sur les investissements de vos filleuls
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-register mb-3">
                            <i class="fas fa-user-plus me-2"></i>Créer mon compte
                        </button>
                    </form>

                    <div class="text-center">
                        <p class="mb-0">Déjà un compte ? 
                            <a href="{{ route('login') }}">Se connecter</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
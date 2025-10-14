<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrêtConnect - Plateforme d'Investissement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-bottom: 1px solid #e9ecef;
        }
        .navbar-brand {
            font-weight: 600;
            color: #2c3e50 !important;
            font-size: 1.5rem;
        }
        .nav-link {
            color: #2c3e50 !important;
            font-weight: 500;
            padding: 10px 20px !important;
            border-radius: 4px;
            transition: all 0.3s;
        }
        .nav-link:hover {
            background-color: #f8f9fa;
            color: #3498db !important;
        }
        .hero-section {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 100px 0;
        }
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        .plan-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 30px;
            overflow: hidden;
        }
        .plan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .plan-header {
            background: #3498db;
            color: white;
            padding: 25px;
            text-align: center;
        }
        .plan-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 1.5rem;
        }
        .plan-body {
            padding: 30px;
        }
        .bonus-section {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 40px;
            margin: 30px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .feature-icon {
            font-size: 3rem;
            color: #3498db;
            margin-bottom: 20px;
        }
        .btn-invest {
            background-color: #3498db;
            border-color: #3498db;
            color: white;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 4px;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-invest:hover {
            background-color: #2980b9;
            border-color: #2980b9;
            color: white;
            transform: translateY(-2px);
        }
        .stats-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            height: 100%;
        }
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 15px 0;
        }
        .section-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .section-subtitle {
            color: #7f8c8d;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }
        .info-box {
            background: #e8f4fd;
            border: 1px solid #bee5eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 2rem;
        }
        .info-box h5 {
            color: #0c5460;
            font-weight: 600;
        }
        .info-box p {
            color: #0c5460;
            margin: 0;
        }
        .badge-custom {
            background-color: #3498db;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 500;
        }
        .badge-warning-custom {
            background-color: #f39c12;
            color: white;
        }
        .badge-success-custom {
            background-color: #27ae60;
            color: white;
        }
        .badge-primary-custom {
            background-color: #3498db;
            color: white;
        }
        .badge-info-custom {
            background-color: #17a2b8;
            color: white;
        }
        .badge-secondary-custom {
            background-color: #6c757d;
            color: white;
        }
        .badge-danger-custom {
            background-color: #e74c3c;
            color: white;
        }
        .badge-dark-custom {
            background-color: #2c3e50;
            color: white;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 40px 0;
        }
        .footer h4 {
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .btn-login {
            background-color: #27ae60;
            border-color: #27ae60;
            color: white;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background-color: #229954;
            border-color: #229954;
            color: white;
        }
        .btn-register {
            background-color: transparent;
            border: 2px solid #3498db;
            color: #3498db;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-register:hover {
            background-color: #3498db;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-coins me-2"></i>PrêtConnect
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#plans">Plans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#bonus">Bonus</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#affiliation">Affiliation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#recompenses">Récompenses</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="{{ route('login') }}" class="btn btn-login me-2">Connexion</a>
                    <a href="{{ route('register') }}" class="btn btn-register">Inscription</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="hero-title">
                <i class="fas fa-globe me-3"></i>PrêtConnect
            </h1>
            <p class="hero-subtitle">Plateforme d'investissement révolutionnaire</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="info-box">
                        <h5><i class="fas fa-info-circle me-2"></i>Conditions d'investissement</h5>
                        <p><strong>Minimum d'investissement :</strong> 100$</p>
                        <p><strong>Dépôts acceptés :</strong> USDT BEP20, USDC BEP20, USDT TRC20</p>
                        <p><strong>Retraits :</strong> USDT BEP20 uniquement (minimum 3$)</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Plans d'Investissement -->
    <section id="plans" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Plans d'Investissement</h2>
                <p class="section-subtitle">Gagnez jusqu'à 300% à 500% de votre investissement</p>
            </div>

            <!-- Plans Standards -->
            <div class="row mb-5">
                <div class="col-12">
                    <h3 class="text-center mb-4 section-title">
                        <i class="fas fa-chart-line me-2"></i>Plans Standards (5 Plans)
                    </h3>
                </div>
                @foreach($standardPlans as $plan)
                <div class="col-lg-4 col-md-6">
                    <div class="plan-card">
                        <div class="plan-header">
                            <h4>{{ $plan->name }}</h4>
                            <p class="mb-0">{{ $plan->description }}</p>
                        </div>
                        <div class="plan-body text-center">
                            <div class="mb-3">
                                <span class="badge-custom">{{ $plan->min_amount }}$ - {{ $plan->max_amount }}$</span>
                            </div>
                            <div class="mb-3">
                                <h5 class="text-success">{{ $plan->daily_percentage }}% par jour</h5>
                                <p class="text-muted">{{ $plan->duration_days }} jours</p>
                            </div>
                            <div class="mb-4">
                                <h4 class="text-primary">{{ $plan->total_percentage }}% total</h4>
                            </div>
                            <a href="{{ route('register') }}" class="btn btn-invest">Investir Maintenant</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Plans Rapides -->
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center mb-4 section-title">
                        <i class="fas fa-bolt me-2"></i>Plans Rapides (2 Plans)
                    </h3>
                </div>
                @foreach($rapidPlans as $plan)
                <div class="col-lg-6 col-md-6">
                    <div class="plan-card">
                        <div class="plan-header">
                            <h4>{{ $plan->name }}</h4>
                            <p class="mb-0">{{ $plan->description }}</p>
                        </div>
                        <div class="plan-body text-center">
                            <div class="mb-3">
                                <span class="badge-custom badge-warning-custom">{{ $plan->min_amount }}$ - {{ $plan->max_amount }}$</span>
                            </div>
                            <div class="mb-3">
                                <h5 class="text-success">{{ $plan->daily_percentage }}% par jour</h5>
                                <p class="text-muted">{{ $plan->duration_days }} jours</p>
                            </div>
                            <div class="mb-4">
                                <h4 class="text-primary">{{ $plan->total_percentage }}% total</h4>
                            </div>
                            <a href="{{ route('register') }}" class="btn btn-invest">Investir Maintenant</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Bonus de la Peur de Perdre -->
    <section id="bonus" class="py-5 bg-light">
        <div class="container">
            <div class="bonus-section">
                <h2 class="text-center mb-5 section-title">
                    <i class="fas fa-shield-alt me-2"></i>Bonus de la Peur de Perdre chez PrêtConnect
                </h2>
                <p class="text-center mb-5 section-subtitle">
                    Lorsqu'un membre rejoint PrêtConnect, il a la possibilité de récupérer 100% à 25% de son investissement entre 4 jours et 14 jours
                </p>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="stats-card">
                            <i class="fas fa-users feature-icon"></i>
                            <h5>1er Exemple</h5>
                            <p>Un membre investit 100$ à PrêtConnect et en 4 jours il a invité 5 personnes directes à investir 100$</p>
                            <div class="stats-number text-success">100%</div>
                            <p>Le membre reçoit la totalité de son investissement</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="stats-card">
                            <i class="fas fa-user-plus feature-icon"></i>
                            <h5>2ème Exemple</h5>
                            <p>Un membre investit 100$ à PrêtConnect et en 8 jours il a invité 6 personnes directes</p>
                            <div class="stats-number text-warning">75%</div>
                            <p>Le membre reçoit 75% de son capital investi</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="stats-card">
                            <i class="fas fa-handshake feature-icon"></i>
                            <h5>3ème Exemple</h5>
                            <p>Un membre investit 100$ à PrêtConnect et en 10 jours 10 personnes directes</p>
                            <div class="stats-number text-info">50%</div>
                            <p>Le membre reçoit 50% de son capital investi</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="stats-card">
                            <i class="fas fa-gift feature-icon"></i>
                            <h5>4ème Exemple</h5>
                            <p>Un membre investit 100$ à PrêtConnect et en 14 jours il a invité 10 personnes directes</p>
                            <div class="stats-number text-primary">25%</div>
                            <p>Le membre reçoit 25% de son capital</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bonus d'Affiliation -->
    <section id="affiliation" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 section-title">
                <i class="fas fa-network-wired me-2"></i>Bonus de l'Affiliation
            </h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="plan-card">
                        <div class="plan-body text-center">
                            <p class="section-subtitle mb-4">
                                Lorsqu'un membre invite un ami à rejoindre PrêtConnect, alors il a la possibilité de gagner jusqu'à 20% des dépôts de ses affiliés
                            </p>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                        <span><strong>Niveau 1</strong></span>
                                        <span class="badge-custom badge-success-custom">10%</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                        <span><strong>Niveau 2</strong></span>
                                        <span class="badge-custom badge-primary-custom">5%</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                        <span><strong>Niveau 3</strong></span>
                                        <span class="badge-custom badge-info-custom">3%</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                        <span><strong>Niveau 4</strong></span>
                                        <span class="badge-custom badge-warning-custom">1.5%</span>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                        <span><strong>Niveau 5</strong></span>
                                        <span class="badge-custom badge-secondary-custom">0.5%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Récompenses de l'Équipe -->
    <section id="recompenses" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 section-title">
                <i class="fas fa-trophy me-2"></i>Récompenses de l'Équipe
            </h2>
            <p class="text-center mb-5 section-subtitle">
                Récompense standard pour les chefs de l'équipe. Vous ne pouvez l'obtenir que lorsque votre propre communauté d'équipe se développera énormément.
            </p>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="plan-card">
                        <div class="plan-body">
                            <h5><i class="fas fa-star me-2"></i>Niveau 1</h5>
                            <p>5 actifs directs et un chiffre d'affaires de 5,000$</p>
                            <div class="text-center">
                                <span class="badge-custom badge-success-custom" style="font-size: 1.2rem;">150$ / mois</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="plan-card">
                        <div class="plan-body">
                            <h5><i class="fas fa-star me-2"></i>Niveau 2</h5>
                            <p>10 actifs directs et un chiffre d'affaires de 10,000$</p>
                            <div class="text-center">
                                <span class="badge-custom badge-primary-custom" style="font-size: 1.2rem;">300$</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="plan-card">
                        <div class="plan-body">
                            <h5><i class="fas fa-star me-2"></i>Niveau 3</h5>
                            <p>15 personnes directes et un chiffre d'affaires de 15,000$</p>
                            <div class="text-center">
                                <span class="badge-custom badge-info-custom" style="font-size: 1.2rem;">450$</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="plan-card">
                        <div class="plan-body">
                            <h5><i class="fas fa-star me-2"></i>Niveau 4</h5>
                            <p>25 personnes directes actives et un chiffre d'affaires de 25,000$</p>
                            <div class="text-center">
                                <span class="badge-custom badge-warning-custom" style="font-size: 1.2rem;">1,000$</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="plan-card">
                        <div class="plan-body">
                            <h5><i class="fas fa-crown me-2"></i>Directeur</h5>
                            <p>50 personnes directes actives et un chiffre d'affaires de 50,000$</p>
                            <div class="text-center">
                                <span class="badge-custom badge-danger-custom" style="font-size: 1.2rem;">2,000$ / mois</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="plan-card">
                        <div class="plan-body">
                            <h5><i class="fas fa-crown me-2"></i>Niveau 6</h5>
                            <p>110 personnes directes actives et un chiffre d'affaires de 100,000$</p>
                            <div class="text-center">
                                <span class="badge-custom badge-dark-custom" style="font-size: 1.2rem;">5,000$</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="plan-card">
                        <div class="plan-body">
                            <h5><i class="fas fa-crown me-2"></i>Niveau 7</h5>
                            <p>120 personnes directes actives et un chiffre d'affaires de 240,000$</p>
                            <div class="text-center">
                                <span class="badge-custom badge-dark-custom" style="font-size: 1.2rem;">12,000$</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="plan-card">
                        <div class="plan-body">
                            <h5><i class="fas fa-crown me-2"></i>Niveau 8</h5>
                            <p>150 personnes actives directes et un chiffre d'affaires de 400,000$</p>
                            <div class="text-center">
                                <span class="badge-custom badge-dark-custom" style="font-size: 1.2rem;">20,000$</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="plan-card">
                        <div class="plan-body text-center">
                            <h5><i class="fas fa-gem me-2"></i>Président</h5>
                            <p>200 personnes actives directes et un chiffre d'affaires de 1,000,000$</p>
                            <div class="text-center">
                                <span class="badge-custom" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); font-size: 1.2rem;">50,000$ / mois</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <h4><i class="fas fa-globe me-2"></i>PrêtConnect</h4>
            <p class="mb-0">&copy; 2024 PrêtConnect. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
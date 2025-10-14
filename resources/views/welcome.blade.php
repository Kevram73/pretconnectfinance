<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PretConnectLoan - Plateforme d'investissement</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'binance-black': '#0b0e11',
                        'binance-dark': '#161a1e',
                        'binance-darker': '#1e2329',
                        'binance-gray': '#2b3139',
                        'binance-light-gray': '#474d57',
                        'binance-yellow': '#f0b90b',
                        'binance-yellow-hover': '#f8d12d',
                        'binance-green': '#02c076',
                        'binance-red': '#f84960',
                        'binance-blue': '#1890ff',
                        'text-primary': '#eaecef',
                        'text-secondary': '#848e9c',
                        'text-tertiary': '#5e6673',
                        'border-color': '#2b3139',
                        'border-hover': '#474d57',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-binance-black text-text-primary font-sans">
    <!-- Navigation -->
    <nav class="bg-binance-dark border-b border-binance-yellow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <div class="w-8 h-8 bg-binance-yellow rounded-lg flex items-center justify-center mr-3">
                            <span class="text-binance-black font-bold text-lg">P</span>
                        </div>
                        <span class="text-text-primary font-bold text-xl">PretConnectLoan</span>
                    </a>
                </div>
                
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/" class="text-text-primary hover:text-binance-yellow px-3 py-2 rounded-md text-sm font-medium transition-colors">Accueil</a>
                        <a href="#plans" class="text-text-primary hover:text-binance-yellow px-3 py-2 rounded-md text-sm font-medium transition-colors">Plans</a>
                        <a href="#support" class="text-text-primary hover:text-binance-yellow px-3 py-2 rounded-md text-sm font-medium transition-colors">Support</a>
                    </div>
                </div>
                
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                    @auth
                            <a href="{{ route('dashboard') }}" class="bg-binance-yellow text-binance-black px-4 py-2 rounded-md text-sm font-medium hover:bg-binance-yellow-hover transition-colors mr-2">
                                Tableau de bord
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-text-primary hover:text-binance-yellow px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                    Déconnexion
                                </button>
                            </form>
                    @else
                            <a href="{{ route('login') }}" class="text-text-primary hover:text-binance-yellow px-3 py-2 rounded-md text-sm font-medium transition-colors mr-2">
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" class="bg-binance-yellow text-binance-black px-4 py-2 rounded-md text-sm font-medium hover:bg-binance-yellow-hover transition-colors mr-2">
                                S'inscrire
                            </a>
                            <a href="{{ route('admin.login') }}" class="text-text-primary hover:text-binance-yellow px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Admin
                            </a>
                    @endauth
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-text-primary hover:text-binance-yellow focus:outline-none focus:text-binance-yellow">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="bg-gradient-to-br from-binance-black to-binance-dark py-24 border-b-2 border-binance-yellow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-text-primary mb-6">
                    Investissez avec <span class="text-binance-yellow">PretConnect</span>
                </h1>
                <p class="text-xl text-text-secondary mb-8 max-w-3xl mx-auto">
                    Plateforme d'investissement sécurisée avec système de parrainage. Gérez vos investissements, suivez vos profits et développez votre réseau.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="bg-binance-yellow text-binance-black px-8 py-4 rounded-lg text-lg font-semibold hover:bg-binance-yellow-hover transition-colors inline-flex items-center">
                        <i class="fas fa-rocket mr-2"></i>
                        Commencer maintenant
                    </a>
                    <a href="{{ route('login') }}" class="border border-binance-yellow text-binance-yellow px-8 py-4 rounded-lg text-lg font-semibold hover:bg-binance-yellow hover:text-binance-black transition-colors inline-flex items-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Se connecter
                    </a>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
                <div class="bg-gradient-to-br from-binance-dark to-binance-darker border border-binance-yellow rounded-xl p-6 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-binance-yellow/20 transition-all duration-300">
                    <div class="text-binance-yellow mb-4">
                        <i class="fas fa-dollar-sign text-3xl"></i>
                    </div>
                    <h5 class="text-text-primary text-xl font-semibold mb-3">Investissements Sécurisés</h5>
                    <p class="text-text-secondary mb-4">Diversifiez votre portefeuille avec nos plans d'investissement sécurisés et rentables.</p>
                    <a href="#plans" class="border border-binance-yellow text-binance-yellow px-4 py-2 rounded-md text-sm font-medium hover:bg-binance-yellow hover:text-binance-black transition-colors">
                        Voir les plans
                    </a>
                </div>

                <div class="bg-gradient-to-br from-binance-dark to-binance-darker border border-binance-yellow rounded-xl p-6 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-binance-yellow/20 transition-all duration-300">
                    <div class="text-binance-yellow mb-4">
                        <i class="fas fa-users text-3xl"></i>
                    </div>
                    <h5 class="text-text-primary text-xl font-semibold mb-3">Système de Parrainage</h5>
                    <p class="text-text-secondary mb-4">Gagnez des commissions en parrainant de nouveaux investisseurs et développez votre réseau.</p>
                    <a href="{{ route('register') }}" class="border border-binance-yellow text-binance-yellow px-4 py-2 rounded-md text-sm font-medium hover:bg-binance-yellow hover:text-binance-black transition-colors">
                        Commencer
                    </a>
                </div>

                <div class="bg-gradient-to-br from-binance-dark to-binance-darker border border-binance-yellow rounded-xl p-6 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-binance-yellow/20 transition-all duration-300">
                    <div class="text-binance-yellow mb-4">
                        <i class="fas fa-chart-line text-3xl"></i>
                    </div>
                    <h5 class="text-text-primary text-xl font-semibold mb-3">Suivi en Temps Réel</h5>
                    <p class="text-text-secondary mb-4">Surveillez vos investissements et profits en temps réel avec notre tableau de bord intuitif.</p>
                    <a href="{{ route('login') }}" class="border border-binance-yellow text-binance-yellow px-4 py-2 rounded-md text-sm font-medium hover:bg-binance-yellow hover:text-binance-black transition-colors">
                        Se connecter
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Investment Plans Section -->
    <section id="plans" class="py-20 bg-binance-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-text-primary mb-6">Plans d'investissement</h2>
                <p class="text-xl text-text-secondary mb-8">
                    <i class="fas fa-globe mr-2 text-binance-yellow"></i>Gagnez jusqu'à 300% à 500% de votre investissement
                </p>
                <div class="flex flex-wrap justify-center gap-6 text-sm">
                    <span class="text-text-secondary flex items-center">
                        <i class="fas fa-coins mr-2 text-binance-yellow"></i>Minimum: 100$
                    </span>
                    <span class="text-text-secondary flex items-center">
                        <i class="fas fa-wallet mr-2 text-binance-yellow"></i>Retrait min: 3$ USDT
                    </span>
                    <span class="text-text-secondary flex items-center">
                        <i class="fas fa-coins mr-2 text-binance-yellow"></i>USDT BEP20, USDC, TRC20
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Plan 1 -->
                <div class="bg-gradient-to-br from-binance-dark to-binance-darker border border-binance-yellow rounded-xl p-6 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-binance-yellow/20 transition-all duration-300">
                    <div class="text-center">
                        <div class="bg-binance-yellow text-binance-black px-4 py-2 rounded-full text-sm font-bold mb-4 inline-block">Plan 1</div>
                        <h5 class="text-2xl font-bold text-text-primary mb-2">100$ - 199$</h5>
                        <p class="text-text-secondary mb-6">1,5% par jour pendant 200 jours</p>
                        <div class="bg-binance-darker rounded-lg p-4">
                            <div class="text-text-secondary text-sm mb-1">Retour total</div>
                            <div class="text-3xl font-bold text-binance-green mb-2">300%</div>
                            <div class="text-text-secondary text-sm">300$ - 597$</div>
                        </div>
                    </div>
                </div>

                <!-- Plan 2 -->
                <div class="bg-gradient-to-br from-binance-dark to-binance-darker border border-binance-yellow rounded-xl p-6 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-binance-yellow/20 transition-all duration-300">
                    <div class="text-center">
                        <div class="bg-binance-yellow text-binance-black px-4 py-2 rounded-full text-sm font-bold mb-4 inline-block">Plan 2</div>
                        <h5 class="text-2xl font-bold text-text-primary mb-2">200$ - 299$</h5>
                        <p class="text-text-secondary mb-6">2% par jour pendant 200 jours</p>
                        <div class="bg-binance-darker rounded-lg p-4">
                            <div class="text-text-secondary text-sm mb-1">Retour total</div>
                            <div class="text-3xl font-bold text-binance-green mb-2">400%</div>
                            <div class="text-text-secondary text-sm">800$ - 1200$</div>
                        </div>
                    </div>
                </div>

                <!-- Plan 3 -->
                <div class="bg-gradient-to-br from-binance-dark to-binance-darker border border-binance-yellow rounded-xl p-6 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-binance-yellow/20 transition-all duration-300">
                    <div class="text-center">
                        <div class="bg-binance-yellow text-binance-black px-4 py-2 rounded-full text-sm font-bold mb-4 inline-block">Plan 3</div>
                        <h5 class="text-2xl font-bold text-text-primary mb-2">300$ - 499$</h5>
                        <p class="text-text-secondary mb-6">2,3% par jour pendant 200 jours</p>
                        <div class="bg-binance-darker rounded-lg p-4">
                            <div class="text-text-secondary text-sm mb-1">Retour total</div>
                            <div class="text-3xl font-bold text-binance-green mb-2">460%</div>
                            <div class="text-text-secondary text-sm">1380$ - 2295$</div>
                        </div>
                    </div>
                </div>

                <!-- Plan 4 -->
                <div class="md:col-span-2 bg-gradient-to-br from-binance-dark to-binance-darker border border-binance-yellow rounded-xl p-6 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-binance-yellow/20 transition-all duration-300">
                    <div class="text-center">
                        <div class="bg-binance-yellow text-binance-black px-4 py-2 rounded-full text-sm font-bold mb-4 inline-block">Plan 4</div>
                        <h5 class="text-2xl font-bold text-text-primary mb-2">500$ - 999$</h5>
                        <p class="text-text-secondary mb-6">2,5% par jour pendant 200 jours</p>
                        <div class="bg-binance-darker rounded-lg p-4">
                            <div class="text-text-secondary text-sm mb-1">Retour total</div>
                            <div class="text-3xl font-bold text-binance-green mb-2">500%</div>
                            <div class="text-text-secondary text-sm">2500$ - 4995$</div>
                        </div>
                    </div>
                </div>

                <!-- Plan 5 -->
                <div class="md:col-span-1 bg-gradient-to-br from-binance-dark to-binance-darker border border-binance-yellow rounded-xl p-6 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-binance-yellow/20 transition-all duration-300">
                    <div class="text-center">
                        <div class="bg-binance-yellow text-binance-black px-4 py-2 rounded-full text-sm font-bold mb-4 inline-block">Plan 5</div>
                        <h5 class="text-2xl font-bold text-text-primary mb-2">1000$ - 5000$</h5>
                        <p class="text-text-secondary mb-6">2,8% par jour pendant 180 jours</p>
                        <div class="bg-binance-darker rounded-lg p-4">
                            <div class="text-text-secondary text-sm mb-1">Retour total</div>
                            <div class="text-3xl font-bold text-binance-green mb-2">500%</div>
                            <div class="text-text-secondary text-sm">5040$ - 25200$</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Investment Plans -->
            <div class="bg-gradient-to-br from-binance-dark to-binance-darker border border-binance-yellow rounded-xl p-8">
                <h3 class="text-2xl font-bold text-binance-yellow mb-8 text-center">
                    <i class="fas fa-bolt mr-2"></i>Plans d'Investissement Rapide
                    </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-binance-yellow/10 border border-binance-yellow/30 rounded-lg p-6">
                        <h5 class="text-text-primary text-xl font-semibold mb-3">Plan Rapide 1</h5>
                        <p class="text-binance-yellow text-2xl font-bold mb-2">100$ - 150$</p>
                        <p class="text-text-secondary mb-2">Gagnez 0.5% chaque 24h</p>
                        <p class="text-binance-green font-semibold">Retour du capital avec le bénéfice</p>
                            </div>
                    <div class="bg-binance-yellow/10 border border-binance-yellow/30 rounded-lg p-6">
                        <h5 class="text-text-primary text-xl font-semibold mb-3">Plan Rapide 2</h5>
                        <p class="text-binance-yellow text-2xl font-bold mb-2">151$ - 199$</p>
                        <p class="text-text-secondary mb-2">Gagnez 6% à 7 jours</p>
                        <p class="text-binance-green font-semibold">Retour du capital avec le bénéfice</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 bg-binance-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="bg-gradient-to-br from-binance-dark to-binance-darker border border-binance-yellow rounded-xl p-12">
                    <h2 class="text-4xl md:text-5xl font-bold text-text-primary mb-6">
                        <i class="fas fa-globe mr-2 text-binance-yellow"></i>Rejoignez PretConnect Aujourd'hui
                        </h2>
                    <p class="text-xl text-text-secondary mb-8 max-w-3xl mx-auto">
                            Commencez votre parcours vers la liberté financière avec notre plateforme innovante
                        </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="bg-binance-yellow text-binance-black px-8 py-4 rounded-lg text-lg font-semibold hover:bg-binance-yellow-hover transition-colors inline-flex items-center">
                            <i class="fas fa-rocket mr-2"></i>
                                Commencer Maintenant
                            </a>
                        <a href="#plans" class="border border-binance-yellow text-binance-yellow px-8 py-4 rounded-lg text-lg font-semibold hover:bg-binance-yellow hover:text-binance-black transition-colors inline-flex items-center">
                            <i class="fas fa-chart-line mr-2"></i>
                                Voir les Plans
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-binance-black border-t-2 border-binance-yellow py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-text-secondary">&copy; 2024 PretConnect. Tous droits réservés.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="{{ route('admin.login') }}" class="text-text-secondary hover:text-binance-yellow transition-colors flex items-center">
                        <i class="fas fa-shield-alt mr-2"></i>Admin
                    </a>
                    <a href="#support" class="text-text-secondary hover:text-binance-yellow transition-colors flex items-center">
                        <i class="fas fa-headset mr-2"></i>Support
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
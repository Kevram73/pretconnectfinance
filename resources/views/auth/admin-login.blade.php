@extends('layouts.auth')

@section('title', 'Connexion Administrateur - PretConnectLoan')
@section('auth-subtitle', 'Accès sécurisé à l\'administration')

@section('content')
<form method="POST" action="{{ route('admin.login') }}">
    @csrf
    
    <div class="mb-6">
        <label for="email" class="block text-text-primary font-semibold mb-2">Email Administrateur</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-envelope text-text-secondary"></i>
            </div>
            <input type="email" 
                   class="w-full bg-binance-darker border border-border-color rounded-lg pl-10 pr-4 py-3 text-text-primary placeholder-text-tertiary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors @error('email') border-binance-red @enderror" 
                   id="email" name="email" value="{{ old('email') }}" 
                   placeholder="admin@pretconnectloan.com" required autofocus>
        </div>
        @error('email')
            <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-6">
        <label for="password" class="block text-text-primary font-semibold mb-2">Mot de Passe</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-lock text-text-secondary"></i>
            </div>
            <input type="password" 
                   class="w-full bg-binance-darker border border-border-color rounded-lg pl-10 pr-12 py-3 text-text-primary placeholder-text-tertiary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors @error('password') border-binance-red @enderror" 
                   id="password" name="password" placeholder="••••••••" required>
            <button type="button" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-text-secondary hover:text-text-primary transition-colors"
                    onclick="togglePassword()">
                <i class="fas fa-eye" id="toggleIcon"></i>
            </button>
        </div>
        @error('password')
            <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-6 flex items-center">
        <input type="checkbox" 
               class="w-4 h-4 bg-binance-darker border-border-color rounded focus:ring-binance-yellow focus:ring-2 text-binance-yellow" 
               id="remember" name="remember">
        <label for="remember" class="ml-2 text-text-secondary text-sm">
            Se souvenir de moi
        </label>
    </div>

    <div class="mb-6">
        <button type="submit" class="w-full bg-binance-yellow text-binance-black py-3 px-6 rounded-lg font-semibold hover:bg-binance-yellow-hover transition-colors flex items-center justify-center">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Se Connecter
        </button>
    </div>

    <div class="relative mb-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-border-color"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-binance-dark text-text-secondary">Ou</span>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('login') }}" class="text-binance-yellow hover:text-binance-yellow-hover font-medium transition-colors flex items-center justify-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la connexion utilisateur
        </a>
    </div>
</form>

<!-- Security Notice -->
<div class="mt-8 p-4 bg-yellow-500/10 border border-yellow-500/30 rounded-lg">
    <div class="flex items-start">
        <i class="fas fa-exclamation-triangle text-yellow-500 text-xl mr-3 mt-1"></i>
        <div>
            <h6 class="text-text-primary font-semibold mb-1">Accès Restreint</h6>
            <p class="text-text-secondary text-sm">
                Cette zone est réservée aux administrateurs autorisés. 
                Toute tentative d'accès non autorisé sera enregistrée.
            </p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>
@endsection

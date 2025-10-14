@extends('layouts.auth')

@section('title', 'Connexion - PretConnectLoan')
@section('auth-subtitle', 'Connectez-vous à votre compte')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    
    <div class="mb-6">
        <label for="email" class="block text-text-primary font-semibold mb-2">Adresse email</label>
        <input type="email" 
               class="w-full bg-binance-darker border border-border-color rounded-lg px-4 py-3 text-text-primary placeholder-text-tertiary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors @error('email') border-binance-red @enderror" 
               id="email" name="email" value="{{ old('email') }}" 
               placeholder="votre@email.com" required autofocus>
        @error('email')
            <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-6">
        <label for="password" class="block text-text-primary font-semibold mb-2">Mot de passe</label>
        <input type="password" 
               class="w-full bg-binance-darker border border-border-color rounded-lg px-4 py-3 text-text-primary placeholder-text-tertiary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors @error('password') border-binance-red @enderror" 
               id="password" name="password" placeholder="Votre mot de passe" required>
        @error('password')
            <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-6 flex justify-between items-center">
        <div class="flex items-center">
            <input type="checkbox" 
                   class="w-4 h-4 bg-binance-darker border-border-color rounded focus:ring-binance-yellow focus:ring-2 text-binance-yellow" 
                   id="remember" name="remember">
            <label for="remember" class="ml-2 text-text-secondary text-sm">
                Se souvenir de moi
            </label>
        </div>
        <a href="#" class="text-binance-yellow hover:text-binance-yellow-hover text-sm font-medium transition-colors">
            Mot de passe oublié ?
        </a>
    </div>

    <div class="mb-6">
        <button type="submit" class="w-full bg-binance-yellow text-binance-black py-3 px-6 rounded-lg font-semibold hover:bg-binance-yellow-hover transition-colors flex items-center justify-center">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Se connecter
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

    <div class="mb-6">
        <button type="button" class="w-full bg-transparent border border-border-color text-text-primary py-3 px-6 rounded-lg font-medium hover:bg-binance-darker hover:border-border-hover transition-colors flex items-center justify-center">
            <i class="fas fa-users mr-2"></i>
            Se connecter avec un code de parrainage
        </button>
    </div>

    <div class="text-center">
        <p class="text-text-secondary text-sm">
            Pas encore de compte ? 
            <a href="{{ route('register') }}" class="text-binance-yellow hover:text-binance-yellow-hover font-medium transition-colors">
                Créer un compte
            </a>
        </p>
    </div>
</form>
@endsection
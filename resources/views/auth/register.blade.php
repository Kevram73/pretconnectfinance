@extends('layouts.auth')

@section('title', 'Créer un compte - PretConnectLoan')
@section('auth-subtitle', 'Rejoignez PretConnect aujourd\'hui')

@section('content')
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <label for="first_name" class="block text-text-primary font-semibold mb-2">
                Prénom <span class="text-binance-yellow">*</span>
            </label>
            <input type="text" 
                   class="w-full bg-binance-darker border border-border-color rounded-lg px-4 py-3 text-text-primary placeholder-text-tertiary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors @error('first_name') border-binance-red @enderror" 
                           id="first_name" name="first_name" value="{{ old('first_name') }}" 
                           placeholder="Votre prénom" required>
                    @error('first_name')
                <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

        <div>
            <label for="last_name" class="block text-text-primary font-semibold mb-2">
                Nom de famille <span class="text-binance-yellow">*</span>
            </label>
            <input type="text" 
                   class="w-full bg-binance-darker border border-border-color rounded-lg px-4 py-3 text-text-primary placeholder-text-tertiary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors @error('last_name') border-binance-red @enderror" 
                           id="last_name" name="last_name" value="{{ old('last_name') }}" 
                           placeholder="Votre nom" required>
                    @error('last_name')
                <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

    <div class="mb-6">
        <label for="username" class="block text-text-primary font-semibold mb-2">
            Nom d'utilisateur <span class="text-binance-yellow">*</span>
        </label>
        <input type="text" 
               class="w-full bg-binance-darker border border-border-color rounded-lg px-4 py-3 text-text-primary placeholder-text-tertiary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors @error('username') border-binance-red @enderror" 
                       id="username" name="username" value="{{ old('username') }}" 
                       placeholder="Choisissez un nom d'utilisateur" required>
                @error('username')
            <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

    <div class="mb-6">
        <label for="email" class="block text-text-primary font-semibold mb-2">
            Email <span class="text-binance-yellow">*</span>
        </label>
        <input type="email" 
               class="w-full bg-binance-darker border border-border-color rounded-lg px-4 py-3 text-text-primary placeholder-text-tertiary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors @error('email') border-binance-red @enderror" 
                       id="email" name="email" value="{{ old('email') }}" 
                       placeholder="votre@email.com" required>
                @error('email')
            <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <label for="password" class="block text-text-primary font-semibold mb-2">
                Mot de passe <span class="text-binance-yellow">*</span>
            </label>
            <input type="password" 
                   class="w-full bg-binance-darker border border-border-color rounded-lg px-4 py-3 text-text-primary placeholder-text-tertiary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors @error('password') border-binance-red @enderror" 
                           id="password" name="password" placeholder="Minimum 6 caractères" required>
                    @error('password')
                <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

        <div>
            <label for="password_confirmation" class="block text-text-primary font-semibold mb-2">
                Confirmer le mot de passe <span class="text-binance-yellow">*</span>
            </label>
            <input type="password" 
                   class="w-full bg-binance-darker border border-border-color rounded-lg px-4 py-3 text-text-primary placeholder-text-tertiary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors" 
                           id="password_confirmation" name="password_confirmation" 
                           placeholder="Répétez votre mot de passe" required>
                </div>
            </div>

    <div class="mb-6">
        <label for="referred_by" class="block text-text-primary font-semibold mb-2">Code de parrainage (optionnel)</label>
        <input type="text" 
               class="w-full bg-binance-darker border border-border-color rounded-lg px-4 py-3 text-text-primary placeholder-text-tertiary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors @error('referred_by') border-binance-red @enderror" 
                       id="referred_by" name="referred_by" value="{{ old('referred_by') }}" 
                       placeholder="Entrez le code de parrainage">
                @error('referred_by')
            <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

    <div class="mb-6">
        <label for="country" class="block text-text-primary font-semibold mb-2">
            Pays <span class="text-binance-yellow">*</span>
        </label>
        <select class="w-full bg-binance-darker border border-border-color rounded-lg px-4 py-3 text-text-primary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors @error('country') border-binance-red @enderror" 
                        id="country" name="country" required>
                    <option value="">Sélectionnez votre pays</option>
                    <option value="FR" {{ old('country') == 'FR' ? 'selected' : '' }}>France</option>
                    <option value="BE" {{ old('country') == 'BE' ? 'selected' : '' }}>Belgique</option>
                    <option value="CH" {{ old('country') == 'CH' ? 'selected' : '' }}>Suisse</option>
                    <option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>Canada</option>
                    <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>États-Unis</option>
                    <option value="GB" {{ old('country') == 'GB' ? 'selected' : '' }}>Royaume-Uni</option>
                    <option value="DE" {{ old('country') == 'DE' ? 'selected' : '' }}>Allemagne</option>
                    <option value="ES" {{ old('country') == 'ES' ? 'selected' : '' }}>Espagne</option>
                    <option value="IT" {{ old('country') == 'IT' ? 'selected' : '' }}>Italie</option>
                    <option value="NL" {{ old('country') == 'NL' ? 'selected' : '' }}>Pays-Bas</option>
                    <option value="OTHER" {{ old('country') == 'OTHER' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('country')
            <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

    <div class="mb-6">
        <div class="flex items-start">
            <input type="checkbox" 
                   class="w-4 h-4 bg-binance-darker border-border-color rounded focus:ring-binance-yellow focus:ring-2 text-binance-yellow mt-1 @error('terms') border-binance-red @enderror" 
                           id="terms" name="terms" required>
            <label for="terms" class="ml-3 text-text-secondary text-sm">
                J'accepte les <a href="#" class="text-binance-yellow hover:text-binance-yellow-hover transition-colors">conditions d'utilisation</a> et la <a href="#" class="text-binance-yellow hover:text-binance-yellow-hover transition-colors">politique de confidentialité</a>
                    </label>
        </div>
                    @error('terms')
            <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
                    @enderror
            </div>

    <div class="mb-6">
        <button type="submit" class="w-full bg-binance-yellow text-binance-black py-3 px-6 rounded-lg font-semibold hover:bg-binance-yellow-hover transition-colors">
                    Créer mon compte
                </button>
            </div>

    <div class="text-center">
        <p class="text-text-secondary text-sm">
                    Déjà un compte ? 
            <a href="{{ route('login') }}" class="text-binance-yellow hover:text-binance-yellow-hover font-medium transition-colors">
                Se connecter
            </a>
                </p>
            </div>
        </form>
@endsection
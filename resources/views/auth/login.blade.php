@extends('layouts.auth')

@section('title', 'Connexion - PretConnect Financial')
@section('subtitle', 'Connectez-vous à votre compte')

@section('content')
<form method="POST" action="{{ route('login') }}" class="auth-form">
    @csrf
    
    <div class="form-group">
        <label for="email" class="form-label">
            <i class="fas fa-envelope"></i>
            Adresse email
        </label>
        <input id="email" 
               type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               name="email" 
               value="{{ old('email') }}" 
               required 
               autocomplete="email" 
               autofocus
               placeholder="votre@email.com">
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password" class="form-label">
            <i class="fas fa-lock"></i>
            Mot de passe
        </label>
        <div class="password-field">
            <input id="password" 
                   type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   name="password" 
                   required 
                   autocomplete="current-password"
                   placeholder="••••••••">
            <button type="button" class="password-toggle" onclick="togglePassword()">
                <i class="fas fa-eye" id="password-icon"></i>
            </button>
        </div>
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-check">
            <input class="form-check-input" 
                   type="checkbox" 
                   name="remember" 
                   id="remember" 
                   {{ old('remember') ? 'checked' : '' }}>
            <span class="form-check-label">
                Se souvenir de moi
            </span>
        </label>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-sign-in-alt"></i>
        Se connecter
    </button>
</form>

<div class="auth-links">
    <p class="text-muted mb-3">Pas encore de compte ?</p>
    <a href="{{ route('register') }}" class="btn btn-outline">
        <i class="fas fa-user-plus"></i>
        Créer un compte
    </a>
    
    @if (Route::has('password.request'))
        <div class="mt-3">
            <a href="{{ route('password.request') }}">
                Mot de passe oublié ?
            </a>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .password-field {
        position: relative;
    }
    
    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-secondary);
        cursor: pointer;
        padding: 0;
        font-size: 1rem;
    }
    
    .password-toggle:hover {
        color: var(--primary-gold);
    }
    
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    
    .form-check-input {
        width: 18px;
        height: 18px;
        accent-color: var(--primary-gold);
    }
    
    .form-check-label {
        user-select: none;
        color: var(--text-secondary);
    }
    
    .invalid-feedback {
        color: var(--warning);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: block;
    }
    
    .is-invalid {
        border-color: var(--warning) !important;
    }
</style>
@endsection

@section('scripts')
<script>
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    }
    
    // Auto-focus first input with error
    document.addEventListener('DOMContentLoaded', function() {
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.focus();
        }
    });
</script>
@endsection
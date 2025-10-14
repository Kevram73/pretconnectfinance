@extends('layouts.auth')

@section('title', 'Inscription - PretConnect Financial')
@section('subtitle', 'Créez votre compte d\'investissement')

@section('content')
<form method="POST" action="{{ route('register') }}" class="auth-form">
    @csrf
    
    <div class="form-group">
        <label for="name" class="form-label">
            <i class="fas fa-user"></i>
            Nom complet
        </label>
        <input id="name" 
               type="text" 
               class="form-control @error('name') is-invalid @enderror" 
               name="name" 
               value="{{ old('name') }}" 
               required 
               autocomplete="name" 
               autofocus
               placeholder="Votre nom complet">
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

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
               placeholder="votre@email.com">
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="phone" class="form-label">
            <i class="fas fa-phone"></i>
            Téléphone
        </label>
        <input id="phone" 
               type="tel" 
               class="form-control @error('phone') is-invalid @enderror" 
               name="phone" 
               value="{{ old('phone') }}" 
               required
               placeholder="+33 6 12 34 56 78">
        @error('phone')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="referral_code" class="form-label">
            <i class="fas fa-users"></i>
            Code de parrainage (optionnel)
        </label>
        <input id="referral_code" 
               type="text" 
               class="form-control @error('referral_code') is-invalid @enderror" 
               name="referral_code" 
               value="{{ old('referral_code', request('ref')) }}"
               placeholder="Code de votre parrain">
        @error('referral_code')
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
                   autocomplete="new-password"
                   placeholder="••••••••">
            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                <i class="fas fa-eye" id="password-icon"></i>
            </button>
        </div>
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
        <small class="form-text">
            Minimum 8 caractères avec lettres et chiffres
        </small>
    </div>

    <div class="form-group">
        <label for="password_confirmation" class="form-label">
            <i class="fas fa-lock"></i>
            Confirmer le mot de passe
        </label>
        <div class="password-field">
            <input id="password_confirmation" 
                   type="password" 
                   class="form-control" 
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password"
                   placeholder="••••••••">
            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                <i class="fas fa-eye" id="password_confirmation-icon"></i>
            </button>
        </div>
    </div>

    <div class="form-group">
        <label class="form-check">
            <input class="form-check-input" 
                   type="checkbox" 
                   name="terms" 
                   id="terms" 
                   required>
            <span class="form-check-label">
                J'accepte les <a href="#" class="text-gold">conditions d'utilisation</a> et la <a href="#" class="text-gold">politique de confidentialité</a>
            </span>
        </label>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-user-plus"></i>
        Créer mon compte
    </button>
</form>

<div class="auth-links">
    <p class="text-muted mb-3">Déjà membre ?</p>
    <a href="{{ route('login') }}" class="btn btn-outline">
        <i class="fas fa-sign-in-alt"></i>
        Se connecter
    </a>
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
        align-items: flex-start;
        gap: 0.5rem;
        cursor: pointer;
    }
    
    .form-check-input {
        width: 18px;
        height: 18px;
        accent-color: var(--primary-gold);
        margin-top: 2px;
        flex-shrink: 0;
    }
    
    .form-check-label {
        user-select: none;
        color: var(--text-secondary);
        line-height: 1.4;
    }
    
    .form-text {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: block;
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
    
    .password-strength {
        margin-top: 0.5rem;
    }
    
    .strength-meter {
        height: 4px;
        background: var(--border-color);
        border-radius: 2px;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }
    
    .strength-fill {
        height: 100%;
        transition: all 0.3s ease;
        border-radius: 2px;
    }
    
    .strength-weak { background: var(--warning); width: 25%; }
    .strength-fair { background: #FFA500; width: 50%; }
    .strength-good { background: #FFD700; width: 75%; }
    .strength-strong { background: var(--success); width: 100%; }
</style>
@endsection

@section('scripts')
<script>
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const passwordIcon = document.getElementById(fieldId + '-icon');
        
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
    
    // Password strength indicator
    function checkPasswordStrength(password) {
        let strength = 0;
        const checks = [
            password.length >= 8,
            /[a-z]/.test(password),
            /[A-Z]/.test(password),
            /[0-9]/.test(password),
            /[^A-Za-z0-9]/.test(password)
        ];
        
        strength = checks.filter(Boolean).length;
        return strength;
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        
        // Add password strength meter
        const strengthMeter = document.createElement('div');
        strengthMeter.className = 'password-strength';
        strengthMeter.innerHTML = `
            <div class="strength-meter">
                <div class="strength-fill" id="strength-fill"></div>
            </div>
            <small class="strength-text" id="strength-text">Entrez un mot de passe</small>
        `;
        passwordInput.parentNode.appendChild(strengthMeter);
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            const fill = document.getElementById('strength-fill');
            const text = document.getElementById('strength-text');
            
            fill.className = 'strength-fill';
            
            if (password.length === 0) {
                text.textContent = 'Entrez un mot de passe';
                fill.style.width = '0%';
            } else if (strength <= 2) {
                fill.classList.add('strength-weak');
                text.textContent = 'Mot de passe faible';
            } else if (strength === 3) {
                fill.classList.add('strength-fair');
                text.textContent = 'Mot de passe moyen';
            } else if (strength === 4) {
                fill.classList.add('strength-good');
                text.textContent = 'Bon mot de passe';
            } else {
                fill.classList.add('strength-strong');
                text.textContent = 'Mot de passe fort';
            }
        });
        
        // Password confirmation validation
        confirmPasswordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.setCustomValidity('Les mots de passe ne correspondent pas');
            } else {
                this.setCustomValidity('');
            }
        });
        
        // Auto-focus first input with error
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.focus();
        }
    });
</script>
@endsection
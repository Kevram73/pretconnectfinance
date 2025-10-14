@extends('layouts.app')

@section('title', 'Profil - PretConnectLoan')
@section('page-title', 'Mon Profil')

@section('content')
<div class="row">
    <!-- Profile Information -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>
                    Informations du Profil
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">Prénom</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                   id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Nom</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                   id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" 
                               id="username" name="username" value="{{ old('username', $user->username) }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Mettre à Jour le Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-lock me-2"></i>
                    Changer le Mot de Passe
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('change-password') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key me-2"></i>
                            Changer le Mot de Passe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Account Information -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informations du Compte
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Code de Parrainage</label>
                    <div class="input-group">
                        <input type="text" class="form-control" value="{{ $user->referral_code }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyReferralCode()">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Membre depuis</label>
                    <p class="form-control-plaintext">{{ $user->created_at->format('d/m/Y') }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Statut du compte</label>
                    <p>
                        <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                            {{ $user->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Rôle</label>
                    <p>
                        <span class="badge bg-{{ $user->isAdmin() ? 'primary' : 'secondary' }}">
                            {{ $user->isAdmin() ? 'Administrateur' : 'Utilisateur' }}
                        </span>
                    </p>
                </div>

                @if($user->referrer)
                <div class="mb-3">
                    <label class="form-label fw-bold">Parrainé par</label>
                    <p class="form-control-plaintext">{{ $user->referrer->full_name }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Wallet Summary -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-wallet me-2"></i>
                    Résumé du Portefeuille
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border-end">
                            <h6 class="text-primary">${{ number_format($user->wallet->balance, 2) }}</h6>
                            <small class="text-muted">Solde Principal</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <h6 class="text-success">${{ number_format($user->wallet->total_deposited, 2) }}</h6>
                        <small class="text-muted">Total Dépôts</small>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border-end">
                            <h6 class="text-info">${{ number_format($user->wallet->total_invested, 2) }}</h6>
                            <small class="text-muted">Total Investi</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <h6 class="text-warning">${{ number_format($user->wallet->total_profits, 2) }}</h6>
                        <small class="text-muted">Total Profits</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Tips -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shield-alt me-2"></i>
                    Conseils de Sécurité
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Utilisez un mot de passe fort
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Ne partagez jamais vos identifiants
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Vérifiez régulièrement votre compte
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-check text-success me-2"></i>
                        Contactez le support en cas de problème
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function copyReferralCode() {
    const referralCode = document.querySelector('input[value="{{ $user->referral_code }}"]');
    referralCode.select();
    referralCode.setSelectionRange(0, 99999);
    document.execCommand('copy');
    
    // Show success message
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    button.innerHTML = '<i class="fas fa-check"></i>';
    button.classList.add('btn-success');
    button.classList.remove('btn-outline-secondary');
    
    setTimeout(() => {
        button.innerHTML = originalHTML;
        button.classList.remove('btn-success');
        button.classList.add('btn-outline-secondary');
    }, 2000);
}
</script>
@endsection

@extends('layouts.app')

@section('title', 'Parrainages - PretConnectLoan')
@section('page-title', 'Mes Parrainages')

@section('content')
<!-- Referral Stats -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x mb-2"></i>
                <h3>{{ $referrals->count() }}</h3>
                <p class="mb-0">Filleuls Totaux</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-chart-line fa-2x mb-2"></i>
                <h3>${{ number_format($referrals->sum(function($ref) { return $ref->wallet ? $ref->wallet->total_invested : 0; }), 0) }}</h3>
                <p class="mb-0">Investissements Équipe</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-percentage fa-2x mb-2"></i>
                <h3>${{ number_format($referrals->sum(function($ref) { return $ref->wallet ? $ref->wallet->total_commissions : 0; }), 0) }}</h3>
                <p class="mb-0">Commissions Générées</p>
            </div>
        </div>
    </div>
</div>

<!-- Referral Code -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-share-alt me-2"></i>
                    Mon Code de Parrainage
                </h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ auth()->user()->referral_code }}" readonly id="referralCode">
                            <button class="btn btn-outline-secondary" type="button" onclick="copyReferralCode()">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                        <small class="text-muted">Partagez ce code avec vos amis pour gagner des commissions sur leurs investissements</small>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="qr-code-placeholder bg-light p-3 rounded">
                            <i class="fas fa-qrcode fa-3x text-muted"></i>
                            <p class="mb-0 mt-2 small text-muted">QR Code</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Referrals Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-users me-2"></i>
            Mes Filleuls
        </h5>
    </div>
    <div class="card-body">
        @if($referrals->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Date d'Inscription</th>
                            <th>Statut</th>
                            <th>Investissements</th>
                            <th>Commissions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($referrals as $referral)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($referral->first_name, 0, 1)) }}{{ strtoupper(substr($referral->last_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $referral->full_name }}</strong>
                                        <br>
                                        <small class="text-muted">@{{ $referral->username }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $referral->email }}</td>
                            <td>{{ $referral->created_at->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $referral->is_active ? 'success' : 'danger' }}">
                                    {{ $referral->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-primary fw-bold">
                                    ${{ number_format($referral->wallet ? $referral->wallet->total_invested : 0, 2) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-success fw-bold">
                                    ${{ number_format($referral->wallet ? $referral->wallet->total_commissions : 0, 2) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucun filleul trouvé</h5>
                <p class="text-muted">Commencez à parrainer des amis pour construire votre équipe et gagner des commissions.</p>
                <div class="mt-3">
                    <button class="btn btn-primary" onclick="shareReferralCode()">
                        <i class="fas fa-share me-2"></i>
                        Partager mon Code
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Referral Tips -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    Conseils pour Parrainer
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-target me-2"></i>Comment Parrainer</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Partagez votre code de parrainage</li>
                            <li><i class="fas fa-check text-success me-2"></i>Expliquez les avantages de la plateforme</li>
                            <li><i class="fas fa-check text-success me-2"></i>Assistez vos filleuls dans leurs premiers pas</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-gift me-2"></i>Bénéfices</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>10% de commission sur chaque investissement</li>
                            <li><i class="fas fa-check text-success me-2"></i>Commissions multi-niveau jusqu'au niveau 5</li>
                            <li><i class="fas fa-check text-success me-2"></i>Récompenses d'équipe mensuelles</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function copyReferralCode() {
    const referralCode = document.getElementById('referralCode');
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

function shareReferralCode() {
    const referralCode = '{{ auth()->user()->referral_code }}';
    const shareText = `Rejoignez PretConnectLoan avec mon code de parrainage: ${referralCode}. Une plateforme d'investissement fiable avec des profits quotidiens garantis!`;
    
    if (navigator.share) {
        navigator.share({
            title: 'PretConnectLoan - Code de Parrainage',
            text: shareText,
            url: window.location.origin + '/register?ref=' + referralCode
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(shareText + '\n' + window.location.origin + '/register?ref=' + referralCode);
        alert('Lien de parrainage copié dans le presse-papiers!');
    }
}
</script>
@endsection

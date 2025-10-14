@extends('layouts.app')

@section('title', 'Parrainage')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-users me-2"></i>Parrainage
                </h4>
            </div>
        </div>
    </div>

    <!-- Statistiques de Parrainage -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Total Filleuls</h6>
                        <h3 class="stats-number mb-0">{{ $referralStats['total_referrals'] }}</h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Filleuls Actifs</h6>
                        <h3 class="stats-number mb-0">{{ $referralStats['active_referrals'] }}</h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Commissions Gagnées</h6>
                        <h3 class="stats-number mb-0">${{ number_format($referralStats['total_commission_earned'], 2) }}</h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Code de Parrainage -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-share-alt me-2"></i>Votre Code de Parrainage
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <h2 class="text-primary">{{ Auth::user()->referral_code }}</h2>
                    </div>
                    <p class="text-muted mb-3">Partagez ce code avec vos amis pour gagner des commissions !</p>
                    <button class="btn btn-primary" onclick="copyReferralCode()">
                        <i class="fas fa-copy me-2"></i>Copier le code
                    </button>
                </div>
            </div>

            <!-- Lien de Parrainage -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-link me-2"></i>Lien de Parrainage
                    </h5>
                </div>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" id="referralLink" 
                               value="{{ url('/register?ref=' . Auth::user()->referral_code) }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyReferralLink()">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Commissions par Niveau -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Commissions par Niveau
                    </h5>
                </div>
                <div class="card-body">
                    @if($commissionByLevel->count() > 0)
                        @foreach($commissionByLevel as $level)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Niveau {{ $level->level }}</span>
                            <div class="text-end">
                                <strong class="text-success">${{ number_format($level->total_amount, 2) }}</strong>
                                <br>
                                <small class="text-muted">{{ $level->count }} commission(s)</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">Aucune commission encore</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Liste des Filleuls -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Mes Filleuls
                    </h5>
                </div>
                <div class="card-body">
                    @if($referrals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Filleul</th>
                                        <th>Email</th>
                                        <th>Statut</th>
                                        <th>Investissements</th>
                                        <th>Date d'inscription</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($referrals as $referral)
                                    <tr>
                                        <td>
                                            <strong>{{ $referral->username }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $referral->first_name }} {{ $referral->last_name }}</small>
                                        </td>
                                        <td>{{ $referral->email }}</td>
                                        <td>
                                            @if($referral->is_active)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Actif
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>Inactif
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($referral->wallet)
                                                <strong>${{ number_format($referral->wallet->total_invested, 2) }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $referral->wallet->balance > 0 ? 'Solde: $' . number_format($referral->wallet->balance, 2) : 'Aucun solde' }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $referral->created_at->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            {{ $referrals->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun filleul</h5>
                            <p class="text-muted">Commencez à parrainer des amis pour gagner des commissions !</p>
                            <div class="mt-3">
                                <button class="btn btn-primary" onclick="copyReferralCode()">
                                    <i class="fas fa-copy me-2"></i>Copier mon code
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyReferralCode() {
    const referralCode = '{{ Auth::user()->referral_code }}';
    navigator.clipboard.writeText(referralCode).then(function() {
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check me-2"></i>Copié !';
        button.classList.remove('btn-primary');
        button.classList.add('btn-success');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-primary');
        }, 2000);
    });
}

function copyReferralLink() {
    const referralLink = document.getElementById('referralLink').value;
    navigator.clipboard.writeText(referralLink).then(function() {
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i>';
        button.classList.remove('btn-outline-secondary');
        button.classList.add('btn-success');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-secondary');
        }, 2000);
    });
}
</script>
@endsection
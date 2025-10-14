@extends('layouts.app')

@section('title', 'Commissions - PretConnectLoan')
@section('page-title', 'Mes Commissions')

@section('content')
<!-- Commission Stats -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-percentage fa-2x mb-2"></i>
                <h3>${{ number_format($commissionStats['total_commissions'], 2) }}</h3>
                <p class="mb-0">Total Commissions</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-user-friends fa-2x mb-2"></i>
                <h3>${{ number_format($commissionStats['total_referral_commissions'], 2) }}</h3>
                <p class="mb-0">Commissions Parrainage</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-layer-group fa-2x mb-2"></i>
                <h3>${{ number_format($commissionStats['total_multi_level_commissions'], 2) }}</h3>
                <p class="mb-0">Commissions Multi-Niveau</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h3>${{ number_format($commissionStats['pending_referral_commissions'] + $commissionStats['pending_multi_level_commissions'], 2) }}</h3>
                <p class="mb-0">En Attente</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Referral Commissions -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-friends me-2"></i>
                    Commissions de Parrainage
                </h5>
            </div>
            <div class="card-body">
                @if($referralCommissions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Montant</th>
                                    <th>Pourcentage</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($referralCommissions as $commission)
                                <tr>
                                    <td>
                                        <strong>{{ $commission->user->full_name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $commission->user->email }}</small>
                                    </td>
                                    <td>
                                        <span class="text-success">
                                            ${{ number_format($commission->amount, 2) }}
                                        </span>
                                    </td>
                                    <td>{{ $commission->percentage }}%</td>
                                    <td>
                                        <span class="badge bg-{{ $commission->status === 'COMPLETED' ? 'success' : ($commission->status === 'PENDING' ? 'warning' : 'danger') }}">
                                            {{ $commission->status }}
                                        </span>
                                    </td>
                                    <td>{{ $commission->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucune commission de parrainage</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Multi-Level Commissions -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-layer-group me-2"></i>
                    Commissions Multi-Niveau
                </h5>
            </div>
            <div class="card-body">
                @if($multiLevelCommissions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Niveau</th>
                                    <th>Montant</th>
                                    <th>Pourcentage</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($multiLevelCommissions as $commission)
                                <tr>
                                    <td>
                                        <strong>{{ $commission->user->full_name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $commission->user->email }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">Niveau {{ $commission->level }}</span>
                                    </td>
                                    <td>
                                        <span class="text-success">
                                            ${{ number_format($commission->amount, 2) }}
                                        </span>
                                    </td>
                                    <td>{{ $commission->percentage }}%</td>
                                    <td>
                                        <span class="badge bg-{{ $commission->status === 'COMPLETED' ? 'success' : ($commission->status === 'PENDING' ? 'warning' : 'danger') }}">
                                            {{ $commission->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-layer-group fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucune commission multi-niveau</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Commission Info -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informations sur les Commissions
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-user-friends me-2"></i>Commissions de Parrainage</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>10% sur chaque investissement de vos filleuls directs</li>
                            <li><i class="fas fa-check text-success me-2"></i>Paiement automatique après validation</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-layer-group me-2"></i>Commissions Multi-Niveau</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Niveau 1: 5% sur les investissements de vos filleuls</li>
                            <li><i class="fas fa-check text-success me-2"></i>Niveau 2: 3% sur les investissements de vos petits-filleuls</li>
                            <li><i class="fas fa-check text-success me-2"></i>Niveau 3: 2% sur les investissements de vos arrière-petits-filleuls</li>
                            <li><i class="fas fa-check text-success me-2"></i>Niveau 4: 1% sur les investissements de vos arrière-arrière-petits-filleuls</li>
                            <li><i class="fas fa-check text-success me-2"></i>Niveau 5: 0.5% sur les investissements de vos arrière-arrière-arrière-petits-filleuls</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

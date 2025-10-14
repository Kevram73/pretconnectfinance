@extends('layouts.app')

@section('title', 'Commissions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-handshake me-2"></i>Mes Commissions
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Commissions de Parrainage
                    </h5>
                </div>
                <div class="card-body">
                    @if($commissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Filleul</th>
                                        <th>Montant</th>
                                        <th>Pourcentage</th>
                                        <th>Type</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commissions as $commission)
                                    <tr>
                                        <td>
                                            <strong>{{ $commission->user->username }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $commission->user->email }}</small>
                                        </td>
                                        <td>
                                            <strong class="text-success">${{ number_format($commission->amount, 2) }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $commission->percentage }}%</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $commission->type }}</span>
                                        </td>
                                        <td>
                                            @switch($commission->status)
                                                @case('PENDING')
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>En attente
                                                    </span>
                                                    @break
                                                @case('COMPLETED')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Complété
                                                    </span>
                                                    @break
                                                @case('CANCELLED')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times me-1"></i>Annulé
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-light text-dark">{{ $commission->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            {{ $commission->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            {{ $commissions->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-handshake fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune commission</h5>
                            <p class="text-muted">Parrainez des amis pour gagner des commissions !</p>
                            <a href="{{ route('referrals') }}" class="btn btn-primary">
                                <i class="fas fa-users me-2"></i>Voir le Parrainage
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Commissions Multi-Niveaux -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-sitemap me-2"></i>Commissions Multi-Niveaux
                    </h5>
                </div>
                <div class="card-body">
                    @if($multiLevelCommissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Filleul</th>
                                        <th>Niveau</th>
                                        <th>Montant</th>
                                        <th>Pourcentage</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($multiLevelCommissions as $commission)
                                    <tr>
                                        <td>
                                            <strong>{{ $commission->user->username }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $commission->user->email }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">Niveau {{ $commission->level }}</span>
                                        </td>
                                        <td>
                                            <strong class="text-success">${{ number_format($commission->amount, 2) }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $commission->percentage }}%</span>
                                        </td>
                                        <td>
                                            @switch($commission->status)
                                                @case('PENDING')
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>En attente
                                                    </span>
                                                    @break
                                                @case('COMPLETED')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Complété
                                                    </span>
                                                    @break
                                                @case('CANCELLED')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times me-1"></i>Annulé
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-light text-dark">{{ $commission->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            {{ $commission->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            {{ $multiLevelCommissions->links() }}
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-sitemap fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Aucune commission multi-niveau</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
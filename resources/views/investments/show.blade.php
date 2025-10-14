@extends('layouts.app')

@section('title', 'Détails de l\'Investissement - PretConnectLoan')
@section('page-title', 'Détails de l\'Investissement')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <!-- Investment Overview -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <i class="fas fa-dollar-sign fa-2x mb-2"></i>
                        <h3>${{ number_format($investment->amount, 2) }}</h3>
                        <p class="mb-0">Montant Investi</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-2x mb-2"></i>
                        <h3>${{ number_format($investment->daily_profit, 2) }}</h3>
                        <p class="mb-0">Profit Quotidien</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <i class="fas fa-trophy fa-2x mb-2"></i>
                        <h3>${{ number_format($investment->total_profit, 2) }}</h3>
                        <p class="mb-0">Profit Total</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <i class="fas fa-percentage fa-2x mb-2"></i>
                        <h3>{{ $investment->daily_percentage }}%</h3>
                        <p class="mb-0">% Quotidien</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Investment Details -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Détails de l'Investissement
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Plan d'Investissement</label>
                            <p class="form-control-plaintext">{{ $investment->plan->name }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Montant Investi</label>
                            <p class="form-control-plaintext h5 text-primary">${{ number_format($investment->amount, 2) }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pourcentage Quotidien</label>
                            <p class="form-control-plaintext">{{ $investment->daily_percentage }}%</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Profit Quotidien</label>
                            <p class="form-control-plaintext h5 text-success">${{ number_format($investment->daily_profit, 2) }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Durée</label>
                            <p class="form-control-plaintext">{{ $investment->duration_days }} jours</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Date de Début</label>
                            <p class="form-control-plaintext">{{ $investment->start_date->format('d/m/Y') }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Date de Fin</label>
                            <p class="form-control-plaintext">{{ $investment->end_date->format('d/m/Y') }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Statut</label>
                            <p>
                                <span class="badge bg-{{ $investment->status === 'ACTIVE' ? 'success' : ($investment->status === 'COMPLETED' ? 'info' : 'danger') }} fs-6">
                                    {{ $investment->status }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Progression</label>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ ($investment->days_elapsed / $investment->duration_days) * 100 }}%">
                            {{ $investment->days_elapsed }}/{{ $investment->duration_days }} jours
                        </div>
                    </div>
                    <small class="text-muted">
                        {{ round(($investment->days_elapsed / $investment->duration_days) * 100, 1) }}% complété
                    </small>
                </div>

                <!-- Profit Summary -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="card-title">Profit Total Actuel</h6>
                                <h4 class="text-success">${{ number_format($investment->total_profit, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="card-title">Montant Final Estimé</h6>
                                <h4 class="text-primary">${{ number_format($investment->amount + $investment->total_profit, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Investment Timeline -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-timeline me-2"></i>
                    Historique de l'Investissement
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Investissement Créé</h6>
                            <p class="timeline-text">L'investissement a été créé dans le plan "{{ $investment->plan->name }}".</p>
                            <small class="text-muted">{{ $investment->created_at->format('d/m/Y H:i:s') }}</small>
                        </div>
                    </div>

                    @if($investment->status === 'ACTIVE')
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Investissement Actif</h6>
                            <p class="timeline-text">L'investissement génère des profits quotidiens de ${{ number_format($investment->daily_profit, 2) }}.</p>
                            <small class="text-muted">En cours</small>
                        </div>
                    </div>
                    @elseif($investment->status === 'COMPLETED')
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Investissement Terminé</h6>
                            <p class="timeline-text">L'investissement a été complété avec succès. Profit total: ${{ number_format($investment->total_profit, 2) }}.</p>
                            <small class="text-muted">{{ $investment->updated_at->format('d/m/Y H:i:s') }}</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card mt-4">
            <div class="card-body text-center">
                <a href="{{ route('investments') }}" class="btn btn-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>
                    Retour aux Investissements
                </a>
                
                @if($investment->status === 'ACTIVE')
                <a href="{{ route('investments.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Nouvel Investissement
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.timeline-title {
    margin-bottom: 5px;
    font-weight: 600;
}

.timeline-text {
    margin-bottom: 5px;
    color: #6c757d;
}
</style>
@endsection

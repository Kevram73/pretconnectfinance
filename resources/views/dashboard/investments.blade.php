@extends('layouts.app')

@section('title', 'Investissements')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-chart-line me-2"></i>Mes Investissements
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Historique des Investissements
                    </h5>
                </div>
                <div class="card-body">
                    @if($investments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Plan</th>
                                        <th>Montant</th>
                                        <th>Profit/Jour</th>
                                        <th>Durée</th>
                                        <th>Progression</th>
                                        <th>Statut</th>
                                        <th>Date de début</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($investments as $investment)
                                    <tr>
                                        <td>
                                            <strong>{{ $investment->plan->name }}</strong>
                                            @if($investment->plan->is_rapid)
                                                <span class="badge bg-warning ms-2">RAPIDE</span>
                                            @endif
                                            <br>
                                            <small class="text-muted">{{ $investment->plan->description }}</small>
                                        </td>
                                        <td>
                                            <strong>${{ number_format($investment->amount, 2) }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-success">${{ number_format($investment->daily_profit, 2) }}</span>
                                            <br>
                                            <small class="text-muted">{{ $investment->daily_percentage }}%</small>
                                        </td>
                                        <td>
                                            {{ $investment->days_elapsed }}/{{ $investment->duration_days }} jours
                                            <br>
                                            <small class="text-muted">Fin: {{ $investment->end_date->format('d/m/Y') }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $progress = ($investment->days_elapsed / $investment->duration_days) * 100;
                                            @endphp
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar {{ $progress >= 100 ? 'bg-success' : 'bg-primary' }}" 
                                                     role="progressbar" 
                                                     style="width: {{ min($progress, 100) }}%">
                                                    {{ number_format($progress, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @switch($investment->status)
                                                @case('ACTIVE')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-play me-1"></i>Actif
                                                    </span>
                                                    @break
                                                @case('COMPLETED')
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-check me-1"></i>Terminé
                                                    </span>
                                                    @break
                                                @case('CANCELLED')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times me-1"></i>Annulé
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-light text-dark">{{ $investment->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            {{ $investment->start_date->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('investments.show', $investment) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            {{ $investments->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun investissement</h5>
                            <p class="text-muted">Commencez à investir pour voir vos investissements ici.</p>
                            <a href="{{ route('investments.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Investir Maintenant
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Investissements - PretConnectLoan')
@section('page-title', 'Mes Investissements')

@section('content')
<!-- Filter Buttons -->
<div class="row mb-4">
    <div class="col-12">
        <div class="btn-group" role="group">
            <a href="{{ route('investments') }}" class="btn btn-outline-primary {{ !request('status') ? 'active' : '' }}">
                Tous
            </a>
            <a href="{{ route('investments', ['status' => 'ACTIVE']) }}" class="btn btn-outline-success {{ request('status') === 'ACTIVE' ? 'active' : '' }}">
                Actifs
            </a>
            <a href="{{ route('investments', ['status' => 'COMPLETED']) }}" class="btn btn-outline-info {{ request('status') === 'COMPLETED' ? 'active' : '' }}">
                Terminés
            </a>
        </div>
    </div>
</div>

<!-- Investments Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-chart-line me-2"></i>
            Mes Investissements
        </h5>
        <a href="{{ route('investments.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Nouvel Investissement
        </a>
    </div>
    <div class="card-body">
        @if($investments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Montant</th>
                            <th>Profit Quotidien</th>
                            <th>Profit Total</th>
                            <th>Progression</th>
                            <th>Statut</th>
                            <th>Date de Début</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($investments as $investment)
                        <tr>
                            <td>
                                <strong>{{ $investment->plan->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $investment->plan->daily_percentage }}% / jour</small>
                            </td>
                            <td>
                                <strong class="text-primary">
                                    ${{ number_format($investment->amount, 2) }}
                                </strong>
                            </td>
                            <td>
                                <span class="text-success">
                                    ${{ number_format($investment->daily_profit, 2) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-success">
                                    ${{ number_format($investment->total_profit, 2) }}
                                </span>
                            </td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: {{ ($investment->days_elapsed / $investment->duration_days) * 100 }}%">
                                        {{ $investment->days_elapsed }}/{{ $investment->duration_days }} jours
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $investment->status === 'ACTIVE' ? 'success' : ($investment->status === 'COMPLETED' ? 'info' : 'danger') }}">
                                    {{ $investment->status }}
                                </span>
                            </td>
                            <td>{{ $investment->start_date->format('d/m/Y') }}</td>
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

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $investments->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucun investissement trouvé</h5>
                <p class="text-muted">Commencez votre premier investissement pour générer des profits.</p>
                <a href="{{ route('investments.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Créer un Investissement
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

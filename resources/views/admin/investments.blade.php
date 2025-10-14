@extends('layouts.admin')

@section('title', 'Gestion des Investissements - PretConnectLoan')
@section('page-title', 'Gestion des Investissements')

@section('content')
<!-- Search and Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.investments') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Rechercher</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Nom, email utilisateur...">
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Statut</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Tous les statuts</option>
                            <option value="ACTIVE" {{ request('status') === 'ACTIVE' ? 'selected' : '' }}>Actif</option>
                            <option value="COMPLETED" {{ request('status') === 'COMPLETED' ? 'selected' : '' }}>Terminé</option>
                            <option value="CANCELLED" {{ request('status') === 'CANCELLED' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="plan" class="form-label">Plan</label>
                        <select class="form-select" id="plan" name="plan">
                            <option value="">Tous les plans</option>
                            @foreach(\App\Models\Plan::all() as $plan)
                                <option value="{{ $plan->id }}" {{ request('plan') == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-2"></i>
                            Rechercher
                        </button>
                        <a href="{{ route('admin.investments') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>
                            Effacer
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Investments Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-chart-line me-2"></i>
            Liste des Investissements
        </h5>
        <span class="badge bg-primary fs-6">{{ $investments->total() }} investissements</span>
    </div>
    <div class="card-body">
        @if($investments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
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
                                <div class="d-flex align-items-center">
                                    <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                        {{ strtoupper(substr($investment->user->first_name, 0, 1)) }}{{ strtoupper(substr($investment->user->last_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $investment->user->full_name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $investment->user->email }}</small>
                                    </div>
                                </div>
                            </td>
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
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="viewInvestment({{ $investment->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($investment->status === 'ACTIVE')
                                    <button type="button" class="btn btn-sm btn-outline-warning" 
                                            onclick="updateInvestmentStatus({{ $investment->id }}, 'COMPLETED')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="updateInvestmentStatus({{ $investment->id }}, 'CANCELLED')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @endif
                                </div>
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
                <p class="text-muted">Aucun investissement ne correspond à vos critères de recherche.</p>
            </div>
        @endif
    </div>
</div>

<!-- Investment Details Modal -->
<div class="modal fade" id="investmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de l'Investissement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="investmentDetails">
                <!-- Investment details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Update Investment Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le Statut</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateStatusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_status" class="form-label">Nouveau Statut</label>
                        <select class="form-select" id="new_status" name="status" required>
                            <option value="ACTIVE">Actif</option>
                            <option value="COMPLETED">Terminé</option>
                            <option value="CANCELLED">Annulé</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (optionnel)</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Mettre à Jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function viewInvestment(investmentId) {
    // Load investment details
    fetch(`/admin/investments/${investmentId}`)
        .then(response => response.json())
        .then(data => {
            const investment = data.investment;
            const user = data.user;
            const plan = data.plan;
            
            document.getElementById('investmentDetails').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations de l'Investissement</h6>
                        <p><strong>Plan:</strong> ${plan.name}</p>
                        <p><strong>Montant:</strong> $${parseFloat(investment.amount).toFixed(2)}</p>
                        <p><strong>Profit Quotidien:</strong> $${parseFloat(investment.daily_profit).toFixed(2)}</p>
                        <p><strong>Profit Total:</strong> $${parseFloat(investment.total_profit).toFixed(2)}</p>
                        <p><strong>Statut:</strong> <span class="badge bg-${investment.status === 'ACTIVE' ? 'success' : (investment.status === 'COMPLETED' ? 'info' : 'danger')}">${investment.status}</span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Informations de l'Utilisateur</h6>
                        <p><strong>Nom:</strong> ${user.first_name} ${user.last_name}</p>
                        <p><strong>Email:</strong> ${user.email}</p>
                        <p><strong>Username:</strong> @${user.username}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Détails du Plan</h6>
                        <p><strong>Pourcentage Quotidien:</strong> ${plan.daily_percentage}%</p>
                        <p><strong>Durée:</strong> ${plan.duration_days} jours</p>
                        <p><strong>Retour Total:</strong> ${plan.total_percentage}%</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Progression</h6>
                        <p><strong>Jours Écoulés:</strong> ${investment.days_elapsed}/${investment.duration_days}</p>
                        <p><strong>Date de Début:</strong> ${new Date(investment.start_date).toLocaleDateString()}</p>
                        <p><strong>Date de Fin:</strong> ${new Date(investment.end_date).toLocaleDateString()}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: ${(investment.days_elapsed / investment.duration_days) * 100}%">
                                ${Math.round((investment.days_elapsed / investment.duration_days) * 100)}% complété
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            new bootstrap.Modal(document.getElementById('investmentModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors du chargement des détails de l\'investissement');
        });
}

function updateInvestmentStatus(investmentId, status) {
    document.getElementById('new_status').value = status;
    document.getElementById('updateStatusForm').action = `/admin/investments/${investmentId}`;
    
    new bootstrap.Modal(document.getElementById('updateStatusModal')).show();
}
</script>
@endsection

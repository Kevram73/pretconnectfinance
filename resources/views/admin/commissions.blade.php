@extends('layouts.admin')

@section('title', 'Gestion des Commissions - PretConnectLoan')
@section('page-title', 'Gestion des Commissions')

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
                <h3>${{ number_format($commissionStats['pending_commissions'], 2) }}</h3>
                <p class="mb-0">En Attente</p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.commissions') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Rechercher</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Nom, email utilisateur...">
                    </div>
                    <div class="col-md-2">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type">
                            <option value="">Tous les types</option>
                            <option value="REFERRAL" {{ request('type') === 'REFERRAL' ? 'selected' : '' }}>Parrainage</option>
                            <option value="MULTI_LEVEL" {{ request('type') === 'MULTI_LEVEL' ? 'selected' : '' }}>Multi-Niveau</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Statut</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Tous les statuts</option>
                            <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>En Attente</option>
                            <option value="COMPLETED" {{ request('status') === 'COMPLETED' ? 'selected' : '' }}>Terminé</option>
                            <option value="CANCELLED" {{ request('status') === 'CANCELLED' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-2"></i>
                            Rechercher
                        </button>
                        <a href="{{ route('admin.commissions') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>
                            Effacer
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Commissions Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-percentage me-2"></i>
            Liste des Commissions
        </h5>
        <span class="badge bg-primary fs-6">{{ $commissions->total() }} commissions</span>
    </div>
    <div class="card-body">
        @if($commissions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Type</th>
                            <th>Niveau</th>
                            <th>Montant</th>
                            <th>Pourcentage</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commissions as $commission)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                        {{ strtoupper(substr($commission->user->first_name, 0, 1)) }}{{ strtoupper(substr($commission->user->last_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $commission->user->full_name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $commission->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $commission->type === 'REFERRAL' ? 'success' : 'info' }}">
                                    {{ $commission->type === 'REFERRAL' ? 'Parrainage' : 'Multi-Niveau' }}
                                </span>
                            </td>
                            <td>
                                @if($commission->type === 'MULTI_LEVEL')
                                    <span class="badge bg-info">Niveau {{ $commission->level }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <strong class="text-success">
                                    ${{ number_format($commission->amount, 2) }}
                                </strong>
                            </td>
                            <td>{{ $commission->percentage }}%</td>
                            <td>
                                <span class="badge bg-{{ $commission->status === 'COMPLETED' ? 'success' : ($commission->status === 'PENDING' ? 'warning' : 'danger') }}">
                                    {{ $commission->status }}
                                </span>
                            </td>
                            <td>{{ $commission->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="viewCommission({{ $commission->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($commission->status === 'PENDING')
                                    <button type="button" class="btn btn-sm btn-outline-success" 
                                            onclick="updateCommissionStatus({{ $commission->id }}, 'COMPLETED')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="updateCommissionStatus({{ $commission->id }}, 'CANCELLED')">
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
                {{ $commissions->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-percentage fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune commission trouvée</h5>
                <p class="text-muted">Aucune commission ne correspond à vos critères de recherche.</p>
            </div>
        @endif
    </div>
</div>

<!-- Commission Details Modal -->
<div class="modal fade" id="commissionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de la Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="commissionDetails">
                <!-- Commission details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Update Commission Status Modal -->
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
                            <option value="PENDING">En Attente</option>
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
function viewCommission(commissionId) {
    // Load commission details
    fetch(`/admin/commissions/${commissionId}`)
        .then(response => response.json())
        .then(data => {
            const commission = data.commission;
            const user = data.user;
            const referrer = data.referrer;
            
            document.getElementById('commissionDetails').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations de la Commission</h6>
                        <p><strong>Type:</strong> ${commission.type === 'REFERRAL' ? 'Parrainage' : 'Multi-Niveau'}</p>
                        <p><strong>Montant:</strong> $${parseFloat(commission.amount).toFixed(2)}</p>
                        <p><strong>Pourcentage:</strong> ${commission.percentage}%</p>
                        <p><strong>Statut:</strong> <span class="badge bg-${commission.status === 'COMPLETED' ? 'success' : (commission.status === 'PENDING' ? 'warning' : 'danger')}">${commission.status}</span></p>
                        ${commission.type === 'MULTI_LEVEL' ? `<p><strong>Niveau:</strong> ${commission.level}</p>` : ''}
                    </div>
                    <div class="col-md-6">
                        <h6>Informations de l'Utilisateur</h6>
                        <p><strong>Nom:</strong> ${user.first_name} ${user.last_name}</p>
                        <p><strong>Email:</strong> ${user.email}</p>
                        <p><strong>Username:</strong> @${user.username}</p>
                        ${referrer ? `<p><strong>Parrain:</strong> ${referrer.first_name} ${referrer.last_name}</p>` : ''}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h6>Dates</h6>
                        <p><strong>Créé le:</strong> ${new Date(commission.created_at).toLocaleString()}</p>
                        <p><strong>Modifié le:</strong> ${new Date(commission.updated_at).toLocaleString()}</p>
                    </div>
                </div>
            `;
            
            new bootstrap.Modal(document.getElementById('commissionModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors du chargement des détails de la commission');
        });
}

function updateCommissionStatus(commissionId, status) {
    document.getElementById('new_status').value = status;
    document.getElementById('updateStatusForm').action = `/admin/commissions/${commissionId}`;
    
    new bootstrap.Modal(document.getElementById('updateStatusModal')).show();
}
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Gestion des Transactions - PretConnectLoan')
@section('page-title', 'Gestion des Transactions')

@section('content')
<!-- Search and Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.transactions') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Rechercher</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Nom, email utilisateur...">
                    </div>
                    <div class="col-md-2">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type">
                            <option value="">Tous les types</option>
                            <option value="DEPOSIT" {{ request('type') === 'DEPOSIT' ? 'selected' : '' }}>Dépôt</option>
                            <option value="WITHDRAWAL" {{ request('type') === 'WITHDRAWAL' ? 'selected' : '' }}>Retrait</option>
                            <option value="INVESTMENT" {{ request('type') === 'INVESTMENT' ? 'selected' : '' }}>Investissement</option>
                            <option value="PROFIT" {{ request('type') === 'PROFIT' ? 'selected' : '' }}>Profit</option>
                            <option value="COMMISSION" {{ request('type') === 'COMMISSION' ? 'selected' : '' }}>Commission</option>
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
                        <a href="{{ route('admin.transactions') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>
                            Effacer
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-exchange-alt me-2"></i>
            Liste des Transactions
        </h5>
        <span class="badge bg-primary fs-6">{{ $transactions->total() }} transactions</span>
    </div>
    <div class="card-body">
        @if($transactions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Type</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                        {{ strtoupper(substr($transaction->user->first_name, 0, 1)) }}{{ strtoupper(substr($transaction->user->last_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $transaction->user->full_name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $transaction->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $transaction->type === 'DEPOSIT' ? 'success' : ($transaction->type === 'WITHDRAWAL' ? 'warning' : ($transaction->type === 'INVESTMENT' ? 'primary' : 'info')) }}">
                                    <i class="fas fa-{{ $transaction->type === 'DEPOSIT' ? 'arrow-down' : ($transaction->type === 'WITHDRAWAL' ? 'arrow-up' : 'chart-line') }} me-1"></i>
                                    {{ $transaction->type }}
                                </span>
                            </td>
                            <td>
                                <strong class="text-{{ $transaction->type === 'DEPOSIT' ? 'success' : ($transaction->type === 'WITHDRAWAL' ? 'warning' : 'primary') }}">
                                    ${{ number_format($transaction->amount, 2) }}
                                </strong>
                            </td>
                            <td>
                                <span class="badge bg-{{ $transaction->status === 'COMPLETED' ? 'success' : ($transaction->status === 'PENDING' ? 'warning' : 'danger') }}">
                                    {{ $transaction->status }}
                                </span>
                            </td>
                            <td>{{ Str::limit($transaction->description, 50) }}</td>
                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="viewTransaction({{ $transaction->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($transaction->status === 'PENDING')
                                    <button type="button" class="btn btn-sm btn-outline-success" 
                                            onclick="updateTransactionStatus({{ $transaction->id }}, 'COMPLETED')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="updateTransactionStatus({{ $transaction->id }}, 'CANCELLED')">
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
                {{ $transactions->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-exchange-alt fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune transaction trouvée</h5>
                <p class="text-muted">Aucune transaction ne correspond à vos critères de recherche.</p>
            </div>
        @endif
    </div>
</div>

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de la Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="transactionDetails">
                <!-- Transaction details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Update Transaction Status Modal -->
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
function viewTransaction(transactionId) {
    // Load transaction details
    fetch(`/admin/transactions/${transactionId}`)
        .then(response => response.json())
        .then(data => {
            const transaction = data.transaction;
            const user = data.user;
            
            document.getElementById('transactionDetails').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations de la Transaction</h6>
                        <p><strong>Type:</strong> ${transaction.type}</p>
                        <p><strong>Montant:</strong> $${parseFloat(transaction.amount).toFixed(2)}</p>
                        <p><strong>Statut:</strong> <span class="badge bg-${transaction.status === 'COMPLETED' ? 'success' : (transaction.status === 'PENDING' ? 'warning' : 'danger')}">${transaction.status}</span></p>
                        <p><strong>Référence:</strong> ${transaction.reference}</p>
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
                    <div class="col-12">
                        <h6>Description</h6>
                        <p>${transaction.description || 'Aucune description'}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Dates</h6>
                        <p><strong>Créé le:</strong> ${new Date(transaction.created_at).toLocaleString()}</p>
                        <p><strong>Modifié le:</strong> ${new Date(transaction.updated_at).toLocaleString()}</p>
                    </div>
                </div>
            `;
            
            new bootstrap.Modal(document.getElementById('transactionModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors du chargement des détails de la transaction');
        });
}

function updateTransactionStatus(transactionId, status) {
    document.getElementById('new_status').value = status;
    document.getElementById('updateStatusForm').action = `/admin/transactions/${transactionId}`;
    
    new bootstrap.Modal(document.getElementById('updateStatusModal')).show();
}
</script>
@endsection

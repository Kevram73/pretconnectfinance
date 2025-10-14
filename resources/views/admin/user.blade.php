@extends('layouts.admin')

@section('title', 'Détails Utilisateur - PretConnectLoan')
@section('page-title', 'Détails de l\'Utilisateur')

@section('content')
<div class="row">
    <!-- User Information -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>
                    Informations de l'Utilisateur
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nom Complet</label>
                            <p class="form-control-plaintext">{{ $user->full_name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nom d'utilisateur</label>
                            <p class="form-control-plaintext">@{{ $user->username }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <p class="form-control-plaintext">{{ $user->email }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Code de Parrainage</label>
                            <p class="form-control-plaintext font-monospace">{{ $user->referral_code }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Rôle</label>
                            <p>
                                <span class="badge bg-{{ $user->isAdmin() ? 'primary' : 'secondary' }} fs-6">
                                    {{ $user->isAdmin() ? 'Administrateur' : 'Utilisateur' }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Statut</label>
                            <p>
                                <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }} fs-6">
                                    {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Membre depuis</label>
                            <p class="form-control-plaintext">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($user->referrer)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Parrainé par</label>
                            <p class="form-control-plaintext">{{ $user->referrer->full_name }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Wallet Information -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-wallet me-2"></i>
                    Informations du Portefeuille
                </h5>
            </div>
            <div class="card-body">
                @if($user->wallet)
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <h6 class="text-primary">${{ number_format($user->wallet->balance, 2) }}</h6>
                                <small class="text-muted">Solde Principal</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <h6 class="text-success">${{ number_format($user->wallet->total_deposited, 2) }}</h6>
                                <small class="text-muted">Total Dépôts</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <h6 class="text-warning">${{ number_format($user->wallet->total_withdrawn, 2) }}</h6>
                                <small class="text-muted">Total Retraits</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <h6 class="text-info">${{ number_format($user->wallet->total_invested, 2) }}</h6>
                                <small class="text-muted">Total Investi</small>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-wallet fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Aucun portefeuille associé</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>
                    Transactions Récentes
                </h5>
            </div>
            <div class="card-body">
                @if($user->transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->transactions->take(10) as $transaction)
                                <tr>
                                    <td>
                                        <span class="badge bg-{{ $transaction->type === 'DEPOSIT' ? 'success' : ($transaction->type === 'WITHDRAWAL' ? 'warning' : 'primary') }}">
                                            {{ $transaction->type }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($transaction->amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->status === 'COMPLETED' ? 'success' : ($transaction->status === 'PENDING' ? 'warning' : 'danger') }}">
                                            {{ $transaction->status }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-history fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Aucune transaction</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4 mb-4">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Actions Rapides
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-warning" onclick="editUser({{ $user->id }})">
                        <i class="fas fa-edit me-2"></i>
                        Modifier l'Utilisateur
                    </button>
                    @if($user->is_active)
                        <button type="button" class="btn btn-danger" onclick="toggleUserStatus({{ $user->id }}, false)">
                            <i class="fas fa-ban me-2"></i>
                            Désactiver le Compte
                        </button>
                    @else
                        <button type="button" class="btn btn-success" onclick="toggleUserStatus({{ $user->id }}, true)">
                            <i class="fas fa-check me-2"></i>
                            Activer le Compte
                        </button>
                    @endif
                    <a href="{{ route('admin.transactions', ['search' => $user->email]) }}" class="btn btn-info">
                        <i class="fas fa-exchange-alt me-2"></i>
                        Voir les Transactions
                    </a>
                </div>
            </div>
        </div>

        <!-- User Stats -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistiques
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Transactions:</span>
                        <strong>{{ $user->transactions->count() }}</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Investissements:</span>
                        <strong>{{ $user->investments->count() }}</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Filleuls:</span>
                        <strong>{{ $user->referrals->count() }}</strong>
                    </div>
                </div>
                <div class="mb-0">
                    <div class="d-flex justify-content-between">
                        <span>Dernière activité:</span>
                        <strong>{{ $user->updated_at->format('d/m/Y') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Referrals -->
        @if($user->referrals->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>
                    Filleuls ({{ $user->referrals->count() }})
                </h5>
            </div>
            <div class="card-body">
                @foreach($user->referrals->take(5) as $referral)
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar-placeholder bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                        {{ strtoupper(substr($referral->first_name, 0, 1)) }}{{ strtoupper(substr($referral->last_name, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="small">{{ $referral->full_name }}</div>
                        <div class="small text-muted">{{ $referral->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
                @endforeach
                @if($user->referrals->count() > 5)
                <div class="text-center">
                    <small class="text-muted">+{{ $user->referrals->count() - 5 }} autres filleuls</small>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier l'Utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_first_name" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_last_name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_role" class="form-label">Rôle</label>
                        <select class="form-select" id="edit_role" name="role" required>
                            <option value="USER">Utilisateur</option>
                            <option value="ADMIN">Administrateur</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active" value="1">
                            <label class="form-check-label" for="edit_is_active">
                                Compte actif
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function editUser(userId) {
    // Populate modal with current user data
    document.getElementById('edit_first_name').value = '{{ $user->first_name }}';
    document.getElementById('edit_last_name').value = '{{ $user->last_name }}';
    document.getElementById('edit_username').value = '{{ $user->username }}';
    document.getElementById('edit_email').value = '{{ $user->email }}';
    document.getElementById('edit_role').value = '{{ $user->role }}';
    document.getElementById('edit_is_active').checked = {{ $user->is_active ? 'true' : 'false' }};
    
    document.getElementById('editUserForm').action = '{{ route("admin.users.update", $user) }}';
    
    new bootstrap.Modal(document.getElementById('editUserModal')).show();
}

function toggleUserStatus(userId, status) {
    if (confirm(status ? 'Activer ce compte ?' : 'Désactiver ce compte ?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.users.update", $user) }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        
        const statusField = document.createElement('input');
        statusField.type = 'hidden';
        statusField.name = 'is_active';
        statusField.value = status ? '1' : '0';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        form.appendChild(statusField);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection

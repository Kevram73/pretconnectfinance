@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs - PretConnectLoan')
@section('page-title', 'Gestion des Utilisateurs')

@section('content')
<!-- Search and Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.users') }}" class="row g-3">
                    <div class="col-md-6">
                        <label for="search" class="form-label">Rechercher</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Nom, email, username...">
                    </div>
                    <div class="col-md-3">
                        <label for="role" class="form-label">Rôle</label>
                        <select class="form-select" id="role" name="role">
                            <option value="">Tous les rôles</option>
                            <option value="USER" {{ request('role') === 'USER' ? 'selected' : '' }}>Utilisateur</option>
                            <option value="ADMIN" {{ request('role') === 'ADMIN' ? 'selected' : '' }}>Administrateur</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-2"></i>
                            Rechercher
                        </button>
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>
                            Effacer
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-users me-2"></i>
            Liste des Utilisateurs
        </h5>
        <span class="badge bg-primary fs-6">{{ $users->total() }} utilisateurs</span>
    </div>
    <div class="card-body">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Portefeuille</th>
                            <th>Inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $user->full_name }}</strong>
                                        <br>
                                        <small class="text-muted">@{{ $user->username }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->isAdmin() ? 'primary' : 'secondary' }}">
                                    {{ $user->isAdmin() ? 'Admin' : 'User' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                    {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td>
                                @if($user->wallet)
                                    <div class="small">
                                        <div>Solde: ${{ number_format($user->wallet->balance, 2) }}</div>
                                        <div>Dépôts: ${{ number_format($user->wallet->total_deposited, 2) }}</div>
                                    </div>
                                @else
                                    <span class="text-muted">Aucun portefeuille</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-warning" 
                                            onclick="editUser({{ $user->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucun utilisateur trouvé</h5>
                <p class="text-muted">Aucun utilisateur ne correspond à vos critères de recherche.</p>
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
    // Fetch user data and populate modal
    fetch(`/admin/users/${userId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_first_name').value = data.user.first_name;
            document.getElementById('edit_last_name').value = data.user.last_name;
            document.getElementById('edit_username').value = data.user.username;
            document.getElementById('edit_email').value = data.user.email;
            document.getElementById('edit_role').value = data.user.role;
            document.getElementById('edit_is_active').checked = data.user.is_active;
            
            document.getElementById('editUserForm').action = `/admin/users/${userId}`;
            
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors du chargement des données utilisateur');
        });
}
</script>
@endsection

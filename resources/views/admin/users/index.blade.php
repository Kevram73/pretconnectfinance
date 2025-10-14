@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')
@section('page-title', 'Gestion des Utilisateurs')
@section('page-subtitle', 'Créer, modifier et gérer les utilisateurs')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>Liste des Utilisateurs
                </h5>
            </div>
            <div class="admin-card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <button class="btn btn-admin" data-bs-toggle="modal" data-bs-target="#createUserModal">
                            <i class="fas fa-plus me-2"></i>Nouvel Utilisateur
                        </button>
                    </div>
                    <div>
                        <span class="badge badge-primary-admin">{{ $users->count() }} utilisateurs</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-admin data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Statut</th>
                                <th>Inscription</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <i class="fas fa-user text-white"></i>
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
                                    @if($user->role === 'ADMIN')
                                        <span class="badge badge-danger-admin">Admin</span>
                                    @else
                                        <span class="badge badge-info-admin">Utilisateur</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge badge-success-admin">Actif</span>
                                    @else
                                        <span class="badge badge-warning-admin">Inactif</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-admin-info" onclick="viewUser({{ $user->id }})" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-admin" onclick="editUser({{ $user->id }})" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($user->id !== Auth::id())
                                        <button class="btn btn-sm btn-admin-danger" onclick="deleteUser({{ $user->id }})" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Créer Utilisateur -->
<div class="modal fade modal-admin" id="createUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>Nouvel Utilisateur
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createUserForm" method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" class="form-control form-control-admin" name="first_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control form-control-admin" name="last_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control form-control-admin" name="username" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control form-control-admin" name="email" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" class="form-control form-control-admin" name="password" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control form-control-admin" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rôle</label>
                            <select class="form-control form-control-admin" name="role" required>
                                <option value="USER">Utilisateur</option>
                                <option value="ADMIN">Administrateur</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Statut</label>
                            <select class="form-control form-control-admin" name="is_active" required>
                                <option value="1">Actif</option>
                                <option value="0">Inactif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-admin">
                        <i class="fas fa-save me-2"></i>Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Modifier Utilisateur -->
<div class="modal fade modal-admin" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-edit me-2"></i>Modifier l'Utilisateur
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" class="form-control form-control-admin" name="first_name" id="edit_first_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control form-control-admin" name="last_name" id="edit_last_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control form-control-admin" name="username" id="edit_username" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control form-control-admin" name="email" id="edit_email" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mot de passe (laisser vide pour ne pas changer)</label>
                            <input type="password" class="form-control form-control-admin" name="password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control form-control-admin" name="password_confirmation">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rôle</label>
                            <select class="form-control form-control-admin" name="role" id="edit_role" required>
                                <option value="USER">Utilisateur</option>
                                <option value="ADMIN">Administrateur</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Statut</label>
                            <select class="form-control form-control-admin" name="is_active" id="edit_is_active" required>
                                <option value="1">Actif</option>
                                <option value="0">Inactif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-admin">
                        <i class="fas fa-save me-2"></i>Modifier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function viewUser(userId) {
    // Implémenter la vue détaillée de l'utilisateur
    window.location.href = `/admin/users/${userId}`;
}

function editUser(userId) {
    // Charger les données de l'utilisateur
    fetch(`/admin/users/${userId}/json`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_first_name').value = data.first_name;
            document.getElementById('edit_last_name').value = data.last_name;
            document.getElementById('edit_username').value = data.username;
            document.getElementById('edit_email').value = data.email;
            document.getElementById('edit_role').value = data.role;
            document.getElementById('edit_is_active').value = data.is_active ? '1' : '0';
            
            document.getElementById('editUserForm').action = `/admin/users/${userId}`;
            
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors du chargement des données');
        });
}

function deleteUser(userId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        fetch(`/admin/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur lors de la suppression');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la suppression');
        });
    }
}
</script>
@endpush

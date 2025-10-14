@extends('layouts.admin')

@section('title', 'Gestion des Plans - PretConnectLoan')
@section('page-title', 'Gestion des Plans d\'Investissement')

@section('content')
<!-- Plans Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>
            Liste des Plans d'Investissement
        </h5>
        <button type="button" class="btn btn-primary" onclick="createPlan()">
            <i class="fas fa-plus me-2"></i>
            Nouveau Plan
        </button>
    </div>
    <div class="card-body">
        @if($plans->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Pourcentage Quotidien</th>
                            <th>Durée</th>
                            <th>Retour Total</th>
                            <th>Montant Min/Max</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plans as $plan)
                        <tr>
                            <td>
                                <strong>{{ $plan->name }}</strong>
                                @if($plan->is_rapid)
                                    <span class="badge bg-warning ms-2">RAPIDE</span>
                                @endif
                                @if($plan->description)
                                    <br>
                                    <small class="text-muted">{{ $plan->description }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="text-primary fw-bold">{{ $plan->daily_percentage }}%</span>
                                <br>
                                <small class="text-muted">par jour</small>
                            </td>
                            <td>{{ $plan->duration_days }} jours</td>
                            <td>
                                <span class="text-success fw-bold">{{ $plan->total_percentage }}%</span>
                            </td>
                            <td>
                                <div class="small">
                                    <div>Min: ${{ number_format($plan->min_amount, 0) }}</div>
                                    <div>Max: ${{ number_format($plan->max_amount, 0) }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $plan->status === 'ACTIVE' ? 'success' : 'danger' }}">
                                    {{ $plan->status }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="viewPlan({{ $plan->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-warning" 
                                            onclick="editPlan({{ $plan->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="deletePlan({{ $plan->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-list fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucun plan trouvé</h5>
                <p class="text-muted">Créez votre premier plan d'investissement.</p>
                <button type="button" class="btn btn-primary" onclick="createPlan()">
                    <i class="fas fa-plus me-2"></i>
                    Créer un Plan
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Create/Edit Plan Modal -->
<div class="modal fade" id="planModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="planModalTitle">Nouveau Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="planForm" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom du Plan</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="daily_percentage" class="form-label">Pourcentage Quotidien (%)</label>
                                <input type="number" class="form-control" id="daily_percentage" name="daily_percentage" 
                                       step="0.01" min="0" max="100" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration_days" class="form-label">Durée (jours)</label>
                                <input type="number" class="form-control" id="duration_days" name="duration_days" 
                                       min="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="total_percentage" class="form-label">Retour Total (%)</label>
                                <input type="number" class="form-control" id="total_percentage" name="total_percentage" 
                                       step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="min_amount" class="form-label">Montant Minimum ($)</label>
                                <input type="number" class="form-control" id="min_amount" name="min_amount" 
                                       step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_amount" class="form-label">Montant Maximum ($)</label>
                                <input type="number" class="form-control" id="max_amount" name="max_amount" 
                                       step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Statut</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="ACTIVE">Actif</option>
                                    <option value="INACTIVE">Inactif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" id="is_rapid" name="is_rapid" value="1">
                                    <label class="form-check-label" for="is_rapid">
                                        Plan Rapide
                                    </label>
                                </div>
                            </div>
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

<!-- Plan Details Modal -->
<div class="modal fade" id="planDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails du Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="planDetails">
                <!-- Plan details will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function createPlan() {
    document.getElementById('planModalTitle').textContent = 'Nouveau Plan';
    document.getElementById('planForm').action = '{{ route("admin.plans.store") }}';
    document.getElementById('methodField').innerHTML = '';
    
    // Reset form
    document.getElementById('planForm').reset();
    
    new bootstrap.Modal(document.getElementById('planModal')).show();
}

function editPlan(planId) {
    // Load plan data and populate modal
    fetch(`/admin/plans/${planId}`)
        .then(response => response.json())
        .then(data => {
            const plan = data.plan;
            
            document.getElementById('planModalTitle').textContent = 'Modifier le Plan';
            document.getElementById('planForm').action = `/admin/plans/${planId}`;
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            
            // Populate form
            document.getElementById('name').value = plan.name;
            document.getElementById('daily_percentage').value = plan.daily_percentage;
            document.getElementById('duration_days').value = plan.duration_days;
            document.getElementById('total_percentage').value = plan.total_percentage;
            document.getElementById('min_amount').value = plan.min_amount;
            document.getElementById('max_amount').value = plan.max_amount;
            document.getElementById('description').value = plan.description || '';
            document.getElementById('status').value = plan.status;
            document.getElementById('is_rapid').checked = plan.is_rapid;
            
            new bootstrap.Modal(document.getElementById('planModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors du chargement des données du plan');
        });
}

function viewPlan(planId) {
    // Load plan details
    fetch(`/admin/plans/${planId}`)
        .then(response => response.json())
        .then(data => {
            const plan = data.plan;
            
            document.getElementById('planDetails').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations du Plan</h6>
                        <p><strong>Nom:</strong> ${plan.name}</p>
                        <p><strong>Pourcentage Quotidien:</strong> ${plan.daily_percentage}%</p>
                        <p><strong>Durée:</strong> ${plan.duration_days} jours</p>
                        <p><strong>Retour Total:</strong> ${plan.total_percentage}%</p>
                        <p><strong>Statut:</strong> <span class="badge bg-${plan.status === 'ACTIVE' ? 'success' : 'danger'}">${plan.status}</span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Montants</h6>
                        <p><strong>Minimum:</strong> $${parseFloat(plan.min_amount).toFixed(2)}</p>
                        <p><strong>Maximum:</strong> $${parseFloat(plan.max_amount).toFixed(2)}</p>
                        <p><strong>Type:</strong> ${plan.is_rapid ? 'Plan Rapide' : 'Plan Standard'}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h6>Description</h6>
                        <p>${plan.description || 'Aucune description'}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h6>Statistiques</h6>
                        <p><strong>Investissements Actifs:</strong> ${plan.investments ? plan.investments.length : 0}</p>
                        <p><strong>Créé le:</strong> ${new Date(plan.created_at).toLocaleDateString()}</p>
                        <p><strong>Modifié le:</strong> ${new Date(plan.updated_at).toLocaleDateString()}</p>
                    </div>
                </div>
            `;
            
            new bootstrap.Modal(document.getElementById('planDetailsModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors du chargement des détails du plan');
        });
}

function deletePlan(planId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce plan ? Cette action est irréversible.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/plans/${planId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Auto-calculate total percentage when daily percentage or duration changes
document.getElementById('daily_percentage').addEventListener('input', calculateTotal);
document.getElementById('duration_days').addEventListener('input', calculateTotal);

function calculateTotal() {
    const dailyPercentage = parseFloat(document.getElementById('daily_percentage').value) || 0;
    const durationDays = parseInt(document.getElementById('duration_days').value) || 0;
    const totalPercentage = dailyPercentage * durationDays;
    
    document.getElementById('total_percentage').value = totalPercentage.toFixed(2);
}
</script>
@endsection

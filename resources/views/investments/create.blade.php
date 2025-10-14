@extends('layouts.app')

@section('title', 'Nouvel Investissement - PretConnectLoan')
@section('page-title', 'Nouvel Investissement')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <!-- Available Plans -->
        <div class="row mb-4">
            @foreach($plans as $plan)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 plan-card" data-plan-id="{{ $plan->id }}">
                    <div class="card-header text-center">
                        <h5 class="card-title mb-0">{{ $plan->name }}</h5>
                        @if($plan->is_rapid)
                            <span class="badge bg-warning">RAPIDE</span>
                        @endif
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <h3 class="text-primary">{{ $plan->daily_percentage }}%</h3>
                            <small class="text-muted">par jour</small>
                        </div>
                        
                        <div class="mb-3">
                            <p class="mb-1"><strong>Durée:</strong> {{ $plan->duration_days }} jours</p>
                            <p class="mb-1"><strong>Retour total:</strong> {{ $plan->total_percentage }}%</p>
                        </div>
                        
                        <div class="mb-3">
                            <p class="mb-1"><strong>Min:</strong> ${{ number_format($plan->min_amount, 0) }}</p>
                            <p class="mb-0"><strong>Max:</strong> ${{ number_format($plan->max_amount, 0) }}</p>
                        </div>
                        
                        @if($plan->description)
                        <p class="text-muted small">{{ $plan->description }}</p>
                        @endif
                        
                        <button class="btn btn-outline-primary select-plan-btn" data-plan="{{ $plan->id }}">
                            Sélectionner
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Investment Form -->
        <div class="card" id="investment-form" style="display: none;">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Créer un Investissement
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('investments.store') }}">
                    @csrf
                    
                    <input type="hidden" id="selected_plan_id" name="plan_id" value="">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Plan Sélectionné</label>
                                <p id="selected-plan-name" class="form-control-plaintext"></p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pourcentage Quotidien</label>
                                <p id="selected-plan-daily" class="form-control-plaintext"></p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Durée</label>
                                <p id="selected-plan-duration" class="form-control-plaintext"></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Retour Total</label>
                                <p id="selected-plan-total" class="form-control-plaintext"></p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Montant Minimum</label>
                                <p id="selected-plan-min" class="form-control-plaintext"></p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Montant Maximum</label>
                                <p id="selected-plan-max" class="form-control-plaintext"></p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-4">
                        <label for="amount" class="form-label">Montant à Investir (USD)</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" value="{{ old('amount') }}" 
                                   min="100" step="0.01" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Montant minimum: $100.00</small>
                    </div>
                    
                    <!-- Investment Preview -->
                    <div class="alert alert-info" id="investment-preview" style="display: none;">
                        <h6><i class="fas fa-calculator me-2"></i>Aperçu de l'Investissement</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Profit Quotidien:</strong> $<span id="daily-profit">0.00</span></p>
                                <p><strong>Profit Total:</strong> $<span id="total-profit">0.00</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Montant Final:</strong> $<span id="final-amount">0.00</span></p>
                                <p><strong>ROI:</strong> <span id="roi">0</span>%</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Wallet Balance Check -->
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-wallet me-2"></i>Solde Disponible</h6>
                        <p class="mb-0">Votre solde actuel: <strong>${{ number_format(auth()->user()->wallet->balance, 2) }}</strong></p>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary me-md-2" onclick="resetForm()">
                            <i class="fas fa-arrow-left me-2"></i>
                            Changer de Plan
                        </button>
                        <button type="submit" class="btn btn-primary" id="submit-btn" disabled>
                            <i class="fas fa-check me-2"></i>
                            Confirmer l'Investissement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.plan-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.plan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.plan-card.selected {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.select-plan-btn {
    width: 100%;
}
</style>
@endsection

@section('scripts')
<script>
let selectedPlan = null;
const plans = @json($plans);

function selectPlan(planId) {
    // Remove previous selection
    document.querySelectorAll('.plan-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Add selection to current card
    const card = document.querySelector(`[data-plan-id="${planId}"]`);
    card.classList.add('selected');
    
    // Find plan data
    selectedPlan = plans.find(plan => plan.id == planId);
    
    // Update form
    document.getElementById('selected_plan_id').value = planId;
    document.getElementById('selected-plan-name').textContent = selectedPlan.name;
    document.getElementById('selected-plan-daily').textContent = selectedPlan.daily_percentage + '% par jour';
    document.getElementById('selected-plan-duration').textContent = selectedPlan.duration_days + ' jours';
    document.getElementById('selected-plan-total').textContent = selectedPlan.total_percentage + '%';
    document.getElementById('selected-plan-min').textContent = '$' + selectedPlan.min_amount;
    document.getElementById('selected-plan-max').textContent = '$' + selectedPlan.max_amount;
    
    // Show form
    document.getElementById('investment-form').style.display = 'block';
    
    // Scroll to form
    document.getElementById('investment-form').scrollIntoView({ behavior: 'smooth' });
    
    // Set amount limits
    const amountInput = document.getElementById('amount');
    amountInput.min = selectedPlan.min_amount;
    amountInput.max = selectedPlan.max_amount;
    amountInput.value = selectedPlan.min_amount;
    
    // Calculate preview
    calculatePreview();
}

function calculatePreview() {
    if (!selectedPlan) return;
    
    const amount = parseFloat(document.getElementById('amount').value) || 0;
    
    if (amount >= selectedPlan.min_amount && amount <= selectedPlan.max_amount) {
        const dailyProfit = amount * (selectedPlan.daily_percentage / 100);
        const totalProfit = amount * (selectedPlan.total_percentage / 100);
        const finalAmount = amount + totalProfit;
        const roi = selectedPlan.total_percentage;
        
        document.getElementById('daily-profit').textContent = dailyProfit.toFixed(2);
        document.getElementById('total-profit').textContent = totalProfit.toFixed(2);
        document.getElementById('final-amount').textContent = finalAmount.toFixed(2);
        document.getElementById('roi').textContent = roi;
        
        document.getElementById('investment-preview').style.display = 'block';
        document.getElementById('submit-btn').disabled = false;
    } else {
        document.getElementById('investment-preview').style.display = 'none';
        document.getElementById('submit-btn').disabled = true;
    }
}

function resetForm() {
    document.querySelectorAll('.plan-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    document.getElementById('investment-form').style.display = 'none';
    selectedPlan = null;
}

// Event listeners
document.querySelectorAll('.select-plan-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const planId = this.getAttribute('data-plan');
        selectPlan(planId);
    });
});

document.getElementById('amount').addEventListener('input', calculatePreview);
</script>
@endsection

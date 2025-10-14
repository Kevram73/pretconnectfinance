@extends('layouts.app')

@section('title', 'Investir')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-chart-line me-2"></i>Investir
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-coins me-2"></i>Choisir un Plan d'Investissement
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                        @endif

                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Informations importantes</h6>
                        <ul class="mb-0">
                            <li>Minimum d'investissement : <strong>100$</strong></li>
                            <li>Les profits sont calculés quotidiennement</li>
                            <li>Vous pouvez retirer vos profits à tout moment</li>
                            <li>Le capital est retourné à la fin du plan</li>
                        </ul>
                    </div>

                    <form method="POST" action="{{ route('investments.store') }}" id="investmentForm">
                        @csrf
                        
                        <div class="row">
                            @foreach($plans as $plan)
                            <div class="col-lg-6 mb-4">
                                <div class="card plan-card h-100" data-plan-id="{{ $plan->id }}" 
                                     data-min-amount="{{ $plan->min_amount }}" 
                                     data-max-amount="{{ $plan->max_amount }}"
                                     data-daily-percentage="{{ $plan->daily_percentage }}"
                                     data-duration="{{ $plan->duration_days }}"
                                     data-total-percentage="{{ $plan->total_percentage }}">
                                    <div class="card-header {{ $plan->is_rapid ? 'bg-warning' : 'bg-primary' }} text-white">
                                        <h5 class="card-title mb-0 text-center">
                                            {{ $plan->name }}
                                            @if($plan->is_rapid)
                                                <span class="badge bg-light text-dark ms-2">RAPIDE</span>
                                            @endif
                                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                                            <h6 class="text-muted">Montant d'investissement</h6>
                                            <h4 class="text-primary">${{ number_format($plan->min_amount) }} - ${{ number_format($plan->max_amount) }}</h4>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <h6 class="text-muted">Profit quotidien</h6>
                                            <h3 class="text-success">{{ $plan->daily_percentage }}%</h3>
                        </div>
                        
                        <div class="mb-3">
                                            <h6 class="text-muted">Durée</h6>
                                            <h5>{{ $plan->duration_days }} jours</h5>
                        </div>
                        
                        <div class="mb-3">
                                            <h6 class="text-muted">Rendement total</h6>
                                            <h4 class="text-info">{{ $plan->total_percentage }}%</h4>
                        </div>
                        
                        <p class="text-muted small">{{ $plan->description }}</p>
                                        
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="plan_id" 
                                                   id="plan_{{ $plan->id }}" value="{{ $plan->id }}" required>
                                            <label class="form-check-label" for="plan_{{ $plan->id }}">
                                                Choisir ce plan
                                            </label>
                                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

                        <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                    <label for="amount" class="form-label">Montant d'investissement ($)</label>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                           id="amount" name="amount" value="{{ old('amount') }}" 
                                           min="100" max="100000" step="0.01" required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Solde disponible : <strong>${{ number_format($wallet->balance, 2) }}</strong>
                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                            <div class="mb-3">
                                    <label class="form-label">Calcul du profit</label>
                                    <div class="alert alert-light">
                                        <div id="profit-calculation">
                                            <p class="mb-1">Sélectionnez un plan pour voir le calcul</p>
                                        </div>
                                    </div>
                            </div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-chart-line me-2"></i>Investir Maintenant
                            </button>
                        </div>
                    </form>
                </div>
            </div>
                            </div>
                            
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-wallet me-2"></i>Votre Portefeuille
                    </h5>
                            </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">${{ number_format($wallet->balance, 2) }}</h4>
                                <small class="text-muted">Solde actuel</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-1">${{ number_format($wallet->total_invested, 2) }}</h4>
                            <small class="text-muted">Total investi</small>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h5 class="text-info mb-1">${{ number_format($wallet->total_profits, 2) }}</h5>
                                <small class="text-muted">Total profits</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="text-warning mb-1">${{ number_format($wallet->total_commissions, 2) }}</h5>
                            <small class="text-muted">Total commissions</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Comment ça marche ?
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6><i class="fas fa-1 me-2"></i>Choisissez un plan</h6>
                        <p class="small text-muted">Sélectionnez le plan qui correspond à votre budget et vos objectifs.</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6><i class="fas fa-2 me-2"></i>Investissez</h6>
                        <p class="small text-muted">Le montant sera débité de votre portefeuille et l'investissement commencera.</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6><i class="fas fa-3 me-2"></i>Gagnez des profits</h6>
                        <p class="small text-muted">Recevez vos profits quotidiens directement dans votre portefeuille.</p>
                    </div>
                    
                    <div class="mb-0">
                        <h6><i class="fas fa-4 me-2"></i>Récupérez votre capital</h6>
                        <p class="small text-muted">À la fin du plan, récupérez votre capital investi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const planCards = document.querySelectorAll('.plan-card');
    const amountInput = document.getElementById('amount');
    const profitCalculation = document.getElementById('profit-calculation');
    
    planCards.forEach(card => {
        card.addEventListener('click', function() {
            // Désélectionner toutes les cartes
            planCards.forEach(c => c.classList.remove('border-primary'));
            
            // Sélectionner la carte cliquée
            this.classList.add('border-primary');
            
            // Cocher le radio button
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            
            // Mettre à jour les limites du montant
            const minAmount = parseFloat(this.dataset.minAmount);
            const maxAmount = parseFloat(this.dataset.maxAmount);
            amountInput.min = minAmount;
            amountInput.max = maxAmount;
            
            // Calculer le profit si un montant est saisi
            if (amountInput.value) {
                calculateProfit();
            }
        });
    });
    
    amountInput.addEventListener('input', calculateProfit);
    
    function calculateProfit() {
        const selectedPlan = document.querySelector('input[name="plan_id"]:checked');
        const amount = parseFloat(amountInput.value);
        
        if (selectedPlan && amount) {
            const planCard = selectedPlan.closest('.plan-card');
            const dailyPercentage = parseFloat(planCard.dataset.dailyPercentage);
            const duration = parseInt(planCard.dataset.duration);
            const totalPercentage = parseFloat(planCard.dataset.totalPercentage);
            
            const dailyProfit = amount * (dailyPercentage / 100);
            const totalProfit = amount * (totalPercentage / 100);
            const totalReturn = amount + totalProfit;
            
            profitCalculation.innerHTML = `
                <div class="row">
                    <div class="col-6">
                        <strong>Profit/jour:</strong><br>
                        <span class="text-success">$${dailyProfit.toFixed(2)}</span>
                    </div>
                    <div class="col-6">
                        <strong>Profit total:</strong><br>
                        <span class="text-info">$${totalProfit.toFixed(2)}</span>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <strong>Retour total:</strong><br>
                    <span class="text-primary h5">$${totalReturn.toFixed(2)}</span>
                </div>
            `;
        }
    }
});
</script>
@endsection
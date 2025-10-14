@extends('layouts.app')

@section('title', 'Détails de la Transaction')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-eye me-2"></i>Détails de la Transaction
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informations de la Transaction
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Type de transaction</label>
                                <div>
                                    @switch($transaction->type)
                                        @case('DEPOSIT')
                                            <span class="badge bg-success fs-6">
                                                <i class="fas fa-arrow-down me-1"></i>Dépôt
                                            </span>
                                            @break
                                        @case('WITHDRAWAL')
                                            <span class="badge bg-warning fs-6">
                                                <i class="fas fa-arrow-up me-1"></i>Retrait
                                            </span>
                                            @break
                                        @case('INVESTMENT')
                                            <span class="badge bg-primary fs-6">
                                                <i class="fas fa-chart-line me-1"></i>Investissement
                                            </span>
                                            @break
                                        @case('PROFIT')
                                            <span class="badge bg-info fs-6">
                                                <i class="fas fa-coins me-1"></i>Profit
                                            </span>
                                            @break
                                        @case('COMMISSION')
                                            <span class="badge bg-secondary fs-6">
                                                <i class="fas fa-handshake me-1"></i>Commission
                                            </span>
                                            @break
                                        @case('BONUS')
                                            <span class="badge bg-dark fs-6">
                                                <i class="fas fa-gift me-1"></i>Bonus
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-light text-dark fs-6">{{ $transaction->type }}</span>
                                    @endswitch
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Montant</label>
                                <div>
                                    <h4 class="{{ $transaction->type === 'WITHDRAWAL' ? 'text-warning' : 'text-success' }}">
                                        ${{ number_format($transaction->amount, 2) }}
                                    </h4>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Statut</label>
                                <div>
                                    @switch($transaction->status)
                                        @case('PENDING')
                                            <span class="badge bg-warning fs-6">
                                                <i class="fas fa-clock me-1"></i>En attente
                                            </span>
                                            @break
                                        @case('COMPLETED')
                                            <span class="badge bg-success fs-6">
                                                <i class="fas fa-check me-1"></i>Complété
                                            </span>
                                            @break
                                        @case('CANCELLED')
                                            <span class="badge bg-danger fs-6">
                                                <i class="fas fa-times me-1"></i>Annulé
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-light text-dark fs-6">{{ $transaction->status }}</span>
                                    @endswitch
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Date de création</label>
                                <div>
                                    <strong>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</strong>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Dernière mise à jour</label>
                                <div>
                                    <strong>{{ $transaction->updated_at->format('d/m/Y H:i:s') }}</strong>
                                </div>
                            </div>

                            @if($transaction->reference)
                            <div class="mb-3">
                                <label class="form-label">Référence</label>
                                <div>
                                    <code>{{ $transaction->reference }}</code>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($transaction->description)
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <div class="alert alert-light">
                            {{ $transaction->description }}
                        </div>
                    </div>
                    @endif

                    @if($transaction->payment_method)
                    <div class="mb-3">
                        <label class="form-label">Méthode de paiement</label>
                        <div>
                            <span class="badge bg-info">{{ $transaction->payment_method }}</span>
                        </div>
                    </div>
                    @endif

                    @if($transaction->transaction_hash)
                    <div class="mb-3">
                        <label class="form-label">Hash de la transaction</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ $transaction->transaction_hash }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard(this)">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    @endif

                    @if($transaction->payment_hash)
                    <div class="mb-3">
                        <label class="form-label">Adresse de paiement</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ $transaction->payment_hash }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard(this)">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    @endif

                    @if($transaction->deposit_type)
                    <div class="mb-3">
                        <label class="form-label">Type de dépôt</label>
                        <div>
                            <span class="badge bg-info">{{ $transaction->deposit_type }}</span>
                        </div>
                    </div>
                    @endif

                    @if($transaction->screenshot_path)
                    <div class="mb-3">
                        <label class="form-label">Capture d'écran</label>
                        <div>
                            <img src="{{ asset('storage/' . $transaction->screenshot_path) }}" 
                                 alt="Capture d'écran" class="img-fluid" style="max-width: 300px; border-radius: 8px;">
                        </div>
                    </div>
                    @endif

                    @if($transaction->admin_notes)
                    <div class="mb-3">
                        <label class="form-label">Notes de l'administrateur</label>
                        <div class="alert alert-info">
                            {{ $transaction->admin_notes }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Utilisateur
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-circle fa-3x text-muted"></i>
                        </div>
                        <h5>{{ $transaction->user->username }}</h5>
                        <p class="text-muted">{{ $transaction->user->email }}</p>
                        <p class="text-muted">{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</p>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('transactions') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Retour aux transactions
                        </a>
                        
                        @if($transaction->type === 'DEPOSIT' && $transaction->status === 'PENDING')
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Votre dépôt est en attente de validation par l'administrateur.
                        </div>
                        @endif
                        
                        @if($transaction->type === 'WITHDRAWAL' && $transaction->status === 'PENDING')
                        <div class="alert alert-warning">
                            <i class="fas fa-clock me-2"></i>
                            Votre retrait est en cours de traitement.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(button) {
    const input = button.parentElement.querySelector('input');
    input.select();
    document.execCommand('copy');
    
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-check"></i>';
    button.classList.remove('btn-outline-secondary');
    button.classList.add('btn-success');
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.classList.remove('btn-success');
        button.classList.add('btn-outline-secondary');
    }, 2000);
}
</script>
@endsection
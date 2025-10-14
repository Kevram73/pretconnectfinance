@extends('layouts.app')

@section('title', 'Détails de la Transaction - PretConnectLoan')
@section('page-title', 'Détails de la Transaction')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-receipt me-2"></i>
                    Détails de la Transaction
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Type de Transaction</label>
                            <p>
                                <span class="badge bg-{{ $transaction->type === 'DEPOSIT' ? 'success' : ($transaction->type === 'WITHDRAWAL' ? 'warning' : ($transaction->type === 'INVESTMENT' ? 'primary' : 'info')) }} fs-6">
                                    <i class="fas fa-{{ $transaction->type === 'DEPOSIT' ? 'arrow-down' : ($transaction->type === 'WITHDRAWAL' ? 'arrow-up' : 'chart-line') }} me-1"></i>
                                    {{ $transaction->type }}
                                </span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Montant</label>
                            <p class="h4 text-{{ $transaction->type === 'DEPOSIT' ? 'success' : ($transaction->type === 'WITHDRAWAL' ? 'warning' : 'primary') }}">
                                ${{ number_format($transaction->amount, 2) }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Statut</label>
                            <p>
                                <span class="badge bg-{{ $transaction->status === 'COMPLETED' ? 'success' : ($transaction->status === 'PENDING' ? 'warning' : 'danger') }} fs-6">
                                    {{ $transaction->status }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Référence</label>
                            <p class="font-monospace">{{ $transaction->reference }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Date de Création</label>
                            <p>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Dernière Mise à Jour</label>
                            <p>{{ $transaction->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>

                @if($transaction->description)
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <p>{{ $transaction->description }}</p>
                </div>
                @endif

                @if($transaction->payment_method)
                <div class="mb-3">
                    <label class="form-label fw-bold">Méthode de Paiement</label>
                    <p>
                        <i class="fas fa-{{ $transaction->payment_method === 'CRYPTO' ? 'coins' : 'university' }} me-2"></i>
                        {{ $transaction->payment_method === 'CRYPTO' ? 'Cryptomonnaie' : 'Virement Bancaire' }}
                    </p>
                </div>
                @endif

                @if($transaction->transaction_hash)
                <div class="mb-3">
                    <label class="form-label fw-bold">Hash de Transaction</label>
                    <p class="font-monospace small">{{ $transaction->transaction_hash }}</p>
                </div>
                @endif

                @if($transaction->payment_hash)
                <div class="mb-3">
                    <label class="form-label fw-bold">Hash de Paiement</label>
                    <p class="font-monospace small">{{ $transaction->payment_hash }}</p>
                </div>
                @endif

                <hr>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('transactions') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Retour aux Transactions
                    </a>
                    
                    @if($transaction->status === 'PENDING')
                    <div class="text-muted">
                        <i class="fas fa-clock me-2"></i>
                        En attente de traitement
                    </div>
                    @elseif($transaction->status === 'COMPLETED')
                    <div class="text-success">
                        <i class="fas fa-check-circle me-2"></i>
                        Transaction terminée
                    </div>
                    @else
                    <div class="text-danger">
                        <i class="fas fa-times-circle me-2"></i>
                        Transaction annulée
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Transaction Timeline -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-timeline me-2"></i>
                    Historique de la Transaction
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Transaction Créée</h6>
                            <p class="timeline-text">La transaction a été créée et est en attente de traitement.</p>
                            <small class="text-muted">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</small>
                        </div>
                    </div>

                    @if($transaction->status === 'COMPLETED')
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Transaction Complétée</h6>
                            <p class="timeline-text">La transaction a été traitée avec succès.</p>
                            <small class="text-muted">{{ $transaction->updated_at->format('d/m/Y H:i:s') }}</small>
                        </div>
                    </div>
                    @elseif($transaction->status === 'CANCELLED')
                    <div class="timeline-item">
                        <div class="timeline-marker bg-danger"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Transaction Annulée</h6>
                            <p class="timeline-text">La transaction a été annulée.</p>
                            <small class="text-muted">{{ $transaction->updated_at->format('d/m/Y H:i:s') }}</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.timeline-title {
    margin-bottom: 5px;
    font-weight: 600;
}

.timeline-text {
    margin-bottom: 5px;
    color: #6c757d;
}
</style>
@endsection

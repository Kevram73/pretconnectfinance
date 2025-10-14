@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
<div class="container-fluid">
    <div class="row">
    <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-exchange-alt me-2"></i>Mes Transactions
                </h4>
            </div>
    </div>
</div>

    <div class="row">
        <div class="col-12">
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Historique des Transactions
        </h5>
    </div>
    <div class="card-body">
        @if($transactions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
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
                                            @switch($transaction->type)
                                                @case('DEPOSIT')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-arrow-down me-1"></i>Dépôt
                                                    </span>
                                                    @if($transaction->deposit_type)
                                                        <br><small class="text-muted">{{ $transaction->deposit_type }}</small>
                                                    @endif
                                                    @break
                                                @case('WITHDRAWAL')
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-arrow-up me-1"></i>Retrait
                                                    </span>
                                                    @break
                                                @case('INVESTMENT')
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-chart-line me-1"></i>Investissement
                                                    </span>
                                                    @break
                                                @case('PROFIT')
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-coins me-1"></i>Profit
                                                    </span>
                                                    @break
                                                @case('COMMISSION')
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-handshake me-1"></i>Commission
                                                    </span>
                                                    @break
                                                @case('BONUS')
                                                    <span class="badge bg-dark">
                                                        <i class="fas fa-gift me-1"></i>Bonus
                                </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-light text-dark">{{ $transaction->type }}</span>
                                            @endswitch
                            </td>
                            <td>
                                            <strong class="{{ $transaction->type === 'WITHDRAWAL' ? 'text-warning' : 'text-success' }}">
                                    ${{ number_format($transaction->amount, 2) }}
                                </strong>
                            </td>
                            <td>
                                            @switch($transaction->status)
                                                @case('PENDING')
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>En attente
                                                    </span>
                                                    @break
                                                @case('COMPLETED')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Complété
                                                    </span>
                                                    @break
                                                @case('CANCELLED')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times me-1"></i>Annulé
                                </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-light text-dark">{{ $transaction->status }}</span>
                                            @endswitch
                            </td>
                            <td>{{ $transaction->description }}</td>
                                        <td>
                                            {{ $transaction->created_at->format('d/m/Y H:i') }}
                                        </td>
                            <td>
                                <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="text-center py-5">
                            <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune transaction</h5>
                            <p class="text-muted">Vos transactions apparaîtront ici.</p>
                <div class="mt-3">
                    <a href="{{ route('deposit.create') }}" class="btn btn-success me-2">
                                    <i class="fas fa-plus-circle me-2"></i>Déposer
                    </a>
                    <a href="{{ route('investments.create') }}" class="btn btn-primary">
                                    <i class="fas fa-chart-line me-2"></i>Investir
                    </a>
                </div>
            </div>
        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
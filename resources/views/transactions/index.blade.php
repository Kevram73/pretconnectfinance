@extends('layouts.app')

@section('title', 'Transactions - PretConnectLoan')
@section('page-title', 'Mes Transactions')

@section('content')
<!-- Filter Buttons -->
<div class="row mb-4">
    <div class="col-12">
        <div class="btn-group" role="group">
            <a href="{{ route('transactions') }}" class="btn btn-outline-primary {{ !request('type') && !request('status') ? 'active' : '' }}">
                Toutes
            </a>
            <a href="{{ route('transactions', ['type' => 'DEPOSIT']) }}" class="btn btn-outline-success {{ request('type') === 'DEPOSIT' ? 'active' : '' }}">
                Dépôts
            </a>
            <a href="{{ route('transactions', ['type' => 'WITHDRAWAL']) }}" class="btn btn-outline-warning {{ request('type') === 'WITHDRAWAL' ? 'active' : '' }}">
                Retraits
            </a>
            <a href="{{ route('transactions', ['type' => 'INVESTMENT']) }}" class="btn btn-outline-info {{ request('type') === 'INVESTMENT' ? 'active' : '' }}">
                Investissements
            </a>
            <a href="{{ route('transactions', ['status' => 'PENDING']) }}" class="btn btn-outline-secondary {{ request('status') === 'PENDING' ? 'active' : '' }}">
                En Attente
            </a>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-history me-2"></i>
            Historique des Transactions
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
                            <td>{{ $transaction->description }}</td>
                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
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

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-history fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune transaction trouvée</h5>
                <p class="text-muted">Vous n'avez pas encore effectué de transactions.</p>
                <div class="mt-3">
                    <a href="{{ route('deposit.create') }}" class="btn btn-success me-2">
                        <i class="fas fa-plus me-2"></i>
                        Faire un Dépôt
                    </a>
                    <a href="{{ route('investments.create') }}" class="btn btn-primary">
                        <i class="fas fa-chart-line me-2"></i>
                        Investir
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Demander un Retrait - PretConnectLoan')
@section('page-title', 'Demander un Retrait')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Wallet Balance -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-wallet me-2"></i>
                    Solde Disponible
                </h5>
            </div>
            <div class="card-body text-center">
                <h2 class="text-primary mb-0">${{ number_format($user->wallet->balance, 2) }}</h2>
                <p class="text-muted mb-0">Montant disponible pour retrait</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-minus me-2"></i>
                    Nouvelle Demande de Retrait
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('withdrawal.store') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="amount" class="form-label">Montant du Retrait (USD)</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" value="{{ old('amount') }}" 
                                   min="50" max="{{ $user->wallet->balance }}" step="0.01" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Montant minimum: $50.00 | Maximum: ${{ number_format($user->wallet->balance, 2) }}</small>
                    </div>

                    <div class="mb-4">
                        <label for="payment_method" class="form-label">Méthode de Retrait</label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" 
                                id="payment_method" name="payment_method" required>
                            <option value="">Sélectionnez une méthode</option>
                            <option value="CRYPTO" {{ old('payment_method') === 'CRYPTO' ? 'selected' : '' }}>
                                <i class="fas fa-coins me-2"></i>Cryptomonnaie
                            </option>
                            <option value="BANK_TRANSFER" {{ old('payment_method') === 'BANK_TRANSFER' ? 'selected' : '' }}>
                                <i class="fas fa-university me-2"></i>Virement Bancaire
                            </option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description (optionnel)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" 
                                  placeholder="Ajoutez une description pour ce retrait...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Withdrawal Instructions -->
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Important</h6>
                        <ul class="mb-0">
                            <li>Le montant sera déduit immédiatement de votre solde</li>
                            <li>Votre retrait sera traité dans les 24-48 heures</li>
                            <li>Vous recevrez une confirmation par email</li>
                            <li>Les frais de retrait peuvent s'appliquer selon la méthode choisie</li>
                        </ul>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left me-2"></i>
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-warning" 
                                {{ $user->wallet->balance < 50 ? 'disabled' : '' }}>
                            <i class="fas fa-paper-plane me-2"></i>
                            Envoyer la Demande
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Withdrawal History -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>
                    Historique des Retraits
                </h5>
            </div>
            <div class="card-body">
                @php
                    $withdrawals = auth()->user()->transactions()->withdrawals()->latest()->limit(5)->get();
                @endphp
                
                @if($withdrawals->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Montant</th>
                                    <th>Méthode</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($withdrawals as $withdrawal)
                                <tr>
                                    <td>
                                        <strong class="text-warning">
                                            ${{ number_format($withdrawal->amount, 2) }}
                                        </strong>
                                    </td>
                                    <td>{{ $withdrawal->payment_method }}</td>
                                    <td>
                                        <span class="badge bg-{{ $withdrawal->status === 'COMPLETED' ? 'success' : ($withdrawal->status === 'PENDING' ? 'warning' : 'danger') }}">
                                            {{ $withdrawal->status }}
                                        </span>
                                    </td>
                                    <td>{{ $withdrawal->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('transactions', ['type' => 'WITHDRAWAL']) }}" class="btn btn-outline-primary btn-sm">
                            Voir tous les retraits
                        </a>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-history fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Aucun retrait effectué</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

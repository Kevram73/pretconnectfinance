@extends('layouts.app')

@section('title', 'Retrait')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-minus-circle me-2"></i>Retrait de fonds
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-money-bill-wave me-2"></i>Effectuer un retrait
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
                            <li>Minimum de retrait : <strong>3$</strong></li>
                            <li>Maximum de retrait : <strong>100,000$</strong></li>
                            <li>Votre retrait sera traité par l'administrateur</li>
                            <li>Les fonds seront débités de votre portefeuille une fois validés</li>
                        </ul>
                    </div>

                    <form method="POST" action="{{ route('withdrawal.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="amount" class="form-label">Montant du retrait ($)</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" value="{{ old('amount') }}" 
                                   min="3" max="{{ $wallet->balance }}" step="0.01" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Solde disponible : <strong>${{ number_format($wallet->balance, 2) }}</strong>
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Méthode de retrait</label>
                            <select class="form-select @error('payment_method') is-invalid @enderror" 
                                    id="payment_method" name="payment_method" required>
                                <option value="USDT_BEP20" {{ old('payment_method') == 'USDT_BEP20' ? 'selected' : '' }}>
                                    USDT BEP20 (Seule méthode disponible)
                                </option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Les retraits ne sont possibles qu'en USDT BEP20
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="wallet_address" class="form-label">Adresse de votre wallet</label>
                            <input type="text" class="form-control @error('wallet_address') is-invalid @enderror" 
                                   id="wallet_address" name="wallet_address" value="{{ old('wallet_address') }}" 
                                   placeholder="Entrez l'adresse de votre wallet" required>
                            @error('wallet_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Assurez-vous que l'adresse correspond à la méthode de retrait sélectionnée
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Soumettre le retrait
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-wallet me-2"></i>Votre portefeuille
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
                            <h4 class="text-warning mb-1">${{ number_format($wallet->total_withdrawn, 2) }}</h4>
                            <small class="text-muted">Total retiré</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Statistiques
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Total déposé :</span>
                            <strong>${{ number_format($wallet->total_deposited, 2) }}</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Total investi :</span>
                            <strong>${{ number_format($wallet->total_invested, 2) }}</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Total profits :</span>
                            <strong class="text-success">${{ number_format($wallet->total_profits, 2) }}</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Total commissions :</span>
                            <strong class="text-info">${{ number_format($wallet->total_commissions, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
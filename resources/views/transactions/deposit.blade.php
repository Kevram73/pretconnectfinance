@extends('layouts.app')

@section('title', 'Dépôt')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-plus-circle me-2"></i>Dépôt de fonds
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-credit-card me-2"></i>Effectuer un dépôt
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
                            <li>Minimum de dépôt : <strong>100$</strong></li>
                            <li>Maximum de dépôt : <strong>100,000$</strong></li>
                            <li>Votre dépôt sera validé par l'administrateur</li>
                            <li>Les fonds seront ajoutés à votre portefeuille une fois validés</li>
                        </ul>
                    </div>

                    <form method="POST" action="{{ route('deposit.store') }}" enctype="multipart/form-data" id="depositForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label">Type de dépôt</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="deposit_type" 
                                               id="automatic" value="AUTOMATIC" checked onchange="toggleDepositType()">
                                        <label class="form-check-label" for="automatic">
                                            <strong>Dépôt Automatique</strong>
                                            <br>
                                            <small class="text-muted">Validation automatique par le système</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="deposit_type" 
                                               id="manual" value="MANUAL" onchange="toggleDepositType()">
                                        <label class="form-check-label" for="manual">
                                            <strong>Dépôt Manuel</strong>
                                            <br>
                                            <small class="text-muted">Validation par l'administrateur</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Montant du dépôt ($)</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" value="{{ old('amount') }}" 
                                   min="100" max="100000" step="0.01" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Méthode de paiement</label>
                            <select class="form-select @error('payment_method') is-invalid @enderror" 
                                    id="payment_method" name="payment_method" required onchange="updateDepositInfo()">
                                <option value="">Sélectionnez une méthode</option>
                                <option value="USDT_BEP20" {{ old('payment_method') == 'USDT_BEP20' ? 'selected' : '' }}>
                                    USDT BEP20 (Recommandé)
                                </option>
                                <option value="USDC_BEP20" {{ old('payment_method') == 'USDC_BEP20' ? 'selected' : '' }}>
                                    USDC BEP20
                                </option>
                                <option value="USDT_TRC20" {{ old('payment_method') == 'USDT_TRC20' ? 'selected' : '' }}>
                                    USDT TRC20
                                </option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Informations de dépôt (affichées pour le dépôt manuel) -->
                        <div id="depositInfo" class="mb-3" style="display: none;">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Informations de dépôt</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Adresse de dépôt</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="depositAddress" readonly>
                                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('depositAddress')">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">QR Code</label>
                                            <div class="text-center">
                                                <div id="qrCode" class="border p-3">
                                                    <p class="text-muted">Sélectionnez une méthode de paiement</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="transaction_hash" class="form-label">Hash de la transaction</label>
                            <input type="text" class="form-control @error('transaction_hash') is-invalid @enderror" 
                                   id="transaction_hash" name="transaction_hash" value="{{ old('transaction_hash') }}" 
                                   placeholder="Entrez le hash de votre transaction" required>
                            @error('transaction_hash')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Copiez le hash de la transaction depuis votre wallet
                            </small>
                        </div>

                        <!-- Capture d'écran (optionnelle pour le dépôt manuel) -->
                        <div id="screenshotSection" class="mb-3" style="display: none;">
                            <label for="screenshot" class="form-label">Capture d'écran (optionnel)</label>
                            <input type="file" class="form-control @error('screenshot') is-invalid @enderror" 
                                   id="screenshot" name="screenshot" accept="image/*">
                            @error('screenshot')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Ajoutez une capture d'écran de votre transaction pour faciliter la validation
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Soumettre le dépôt
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
                            <h4 class="text-success mb-1">${{ number_format($wallet->total_deposited, 2) }}</h4>
                            <small class="text-muted">Total déposé</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Types de dépôt
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6><i class="fas fa-robot me-2"></i>Dépôt Automatique</h6>
                        <p class="small text-muted">Le système valide automatiquement votre dépôt après vérification de la blockchain.</p>
                    </div>
                    
                    <div class="mb-0">
                        <h6><i class="fas fa-user-check me-2"></i>Dépôt Manuel</h6>
                        <p class="small text-muted">Un administrateur valide manuellement votre dépôt. Plus sécurisé mais plus lent.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Adresses de dépôt
const depositAddresses = {
    'USDT_BEP20': '0x280Cf95cC70600c4d4883600CA908324F963e7d5',
    'USDC_BEP20': '0x280Cf95cC70600c4d4883600CA908324F963e7d5',
    'USDT_TRC20': 'TPfkAE4M5g9h6wrkndnErNC8v5RSAZeCBk'
};

// QR Codes (en réalité, vous devriez générer des vrais QR codes)
const qrCodes = {
    'USDT_BEP20': 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2ZmZiIvPjx0ZXh0IHg9IjUwIiB5PSI1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEwIiBmaWxsPSIjMDAwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5VU0RUIEJFUDA8L3RleHQ+PC9zdmc+',
    'USDC_BEP20': 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2ZmZiIvPjx0ZXh0IHg9IjUwIiB5PSI1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEwIiBmaWxsPSIjMDAwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5VU0RDIEJFUDA8L3RleHQ+PC9zdmc+',
    'USDT_TRC20': 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2ZmZiIvPjx0ZXh0IHg9IjUwIiB5PSI1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEwIiBmaWxsPSIjMDAwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5VU0RUIE1UQzA8L3RleHQ+PC9zdmc+'
};

function toggleDepositType() {
    const manualDeposit = document.getElementById('manual').checked;
    const depositInfo = document.getElementById('depositInfo');
    const screenshotSection = document.getElementById('screenshotSection');
    
    if (manualDeposit) {
        depositInfo.style.display = 'block';
        screenshotSection.style.display = 'block';
        updateDepositInfo();
    } else {
        depositInfo.style.display = 'none';
        screenshotSection.style.display = 'none';
    }
}

function updateDepositInfo() {
    const paymentMethod = document.getElementById('payment_method').value;
    const depositAddress = document.getElementById('depositAddress');
    const qrCode = document.getElementById('qrCode');
    
    if (paymentMethod && depositAddresses[paymentMethod]) {
        depositAddress.value = depositAddresses[paymentMethod];
        qrCode.innerHTML = `<img src="${qrCodes[paymentMethod]}" alt="QR Code" class="img-fluid">`;
    } else {
        depositAddress.value = '';
        qrCode.innerHTML = '<p class="text-muted">Sélectionnez une méthode de paiement</p>';
    }
}

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    element.select();
    document.execCommand('copy');
    
    const button = event.target.closest('button');
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

// Initialiser l'affichage
document.addEventListener('DOMContentLoaded', function() {
    toggleDepositType();
});
</script>
@endsection
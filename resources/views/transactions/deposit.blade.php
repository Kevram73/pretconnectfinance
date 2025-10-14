@extends('layouts.app')

@section('title', 'Faire un Dépôt - PretConnectLoan')
@section('page-title', 'Faire un Dépôt')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-binance-dark border border-border-color rounded-xl overflow-hidden">
        <div class="bg-gradient-to-r from-binance-darker to-binance-dark border-b border-border-color p-6">
            <h5 class="text-xl font-semibold text-text-primary flex items-center">
                <i class="fas fa-plus mr-3 text-binance-yellow"></i>
                Nouveau Dépôt
            </h5>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('deposit.store') }}">
                @csrf
                
                <div class="mb-6">
                    <label for="amount" class="block text-text-primary font-semibold mb-2">Montant du Dépôt (USD)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-text-secondary">$</span>
                        </div>
                        <input type="number" 
                               class="w-full bg-binance-darker border border-border-color rounded-lg pl-8 pr-4 py-3 text-text-primary placeholder-text-tertiary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors @error('amount') border-binance-red @enderror" 
                               id="amount" name="amount" value="{{ old('amount') }}" 
                               min="10" step="0.01" placeholder="0.00" required>
                    </div>
                    @error('amount')
                        <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
                    @enderror
                    <p class="text-text-secondary text-sm mt-2">Montant minimum: $10.00</p>
                </div>

                <div class="mb-6">
                    <label for="payment_method" class="block text-text-primary font-semibold mb-2">Méthode de Paiement</label>
                    <select class="w-full bg-binance-darker border border-border-color rounded-lg px-4 py-3 text-text-primary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors @error('payment_method') border-binance-red @enderror" 
                            id="payment_method" name="payment_method" required>
                        <option value="">Sélectionnez une méthode</option>
                        <option value="CRYPTO" {{ old('payment_method') === 'CRYPTO' ? 'selected' : '' }}>
                            Cryptomonnaie
                        </option>
                        <option value="BANK_TRANSFER" {{ old('payment_method') === 'BANK_TRANSFER' ? 'selected' : '' }}>
                            Virement Bancaire
                        </option>
                    </select>
                    @error('payment_method')
                        <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-text-primary font-semibold mb-2">Description (optionnel)</label>
                    <textarea class="w-full bg-binance-darker border border-border-color rounded-lg px-4 py-3 text-text-primary placeholder-text-tertiary focus:border-binance-yellow focus:ring-2 focus:ring-binance-yellow/20 transition-colors @error('description') border-binance-red @enderror" 
                              id="description" name="description" rows="3" 
                              placeholder="Ajoutez une description pour ce dépôt...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-binance-red text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Payment Instructions -->
                <div class="bg-blue-500/10 border border-blue-500/30 rounded-lg p-4 mb-6">
                    <h6 class="text-text-primary font-semibold mb-3 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>Instructions de Paiement
                    </h6>
                    <ul class="text-text-secondary text-sm space-y-1">
                        <li>• Votre dépôt sera traité dans les 24 heures</li>
                        <li>• Vous recevrez une confirmation par email</li>
                        <li>• Le montant sera ajouté à votre solde principal après validation</li>
                    </ul>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('dashboard') }}" class="bg-binance-gray text-text-primary px-6 py-3 rounded-lg font-medium hover:bg-binance-light-gray transition-colors flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit" class="bg-binance-green text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Envoyer la Demande
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Deposit History -->
    <div class="bg-binance-dark border border-border-color rounded-xl overflow-hidden mt-6">
        <div class="bg-gradient-to-r from-binance-darker to-binance-dark border-b border-border-color p-6">
            <h5 class="text-xl font-semibold text-text-primary flex items-center">
                <i class="fas fa-history mr-3 text-binance-yellow"></i>
                Historique des Dépôts
            </h5>
        </div>
        <div class="p-6">
            @php
                $deposits = auth()->user()->transactions()->deposits()->latest()->limit(5)->get();
            @endphp
            
            @if($deposits->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-border-color">
                                <th class="text-left py-3 px-4 text-text-secondary font-medium">Montant</th>
                                <th class="text-left py-3 px-4 text-text-secondary font-medium">Méthode</th>
                                <th class="text-left py-3 px-4 text-text-secondary font-medium">Statut</th>
                                <th class="text-left py-3 px-4 text-text-secondary font-medium">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deposits as $deposit)
                            <tr class="border-b border-border-color/50 hover:bg-binance-darker/50 transition-colors">
                                <td class="py-3 px-4">
                                    <span class="text-binance-green font-semibold">
                                        ${{ number_format($deposit->amount, 2) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-text-secondary">{{ $deposit->payment_method }}</td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $deposit->status === 'COMPLETED' ? 'bg-green-500/10 text-green-500' : 
                                           ($deposit->status === 'PENDING' ? 'bg-yellow-500/10 text-yellow-500' : 'bg-red-500/10 text-red-500') }}">
                                        {{ $deposit->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-text-secondary">{{ $deposit->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('transactions', ['type' => 'DEPOSIT']) }}" class="bg-binance-yellow/10 border border-binance-yellow/30 text-binance-yellow px-4 py-2 rounded-lg text-sm font-medium hover:bg-binance-yellow/20 transition-colors">
                        Voir tous les dépôts
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-history text-4xl text-text-tertiary mb-4"></i>
                    <p class="text-text-secondary">Aucun dépôt effectué</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\InvestmentController;
use App\Http\Controllers\Web\TransactionController;
use App\Http\Controllers\Web\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    $standardPlans = \App\Models\Plan::where('is_rapid', false)->get();
    $rapidPlans = \App\Models\Plan::where('is_rapid', true)->get();
    return view('welcome', compact('standardPlans', 'rapidPlans'));
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth', 'active.user'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
    Route::get('/investments', [DashboardController::class, 'investments'])->name('investments');
    Route::get('/commissions', [DashboardController::class, 'commissions'])->name('commissions');
    Route::get('/team-rewards', [DashboardController::class, 'teamRewards'])->name('team-rewards');
    Route::get('/referrals', [DashboardController::class, 'referrals'])->name('referrals');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile']);
    Route::post('/change-password', [DashboardController::class, 'changePassword'])->name('change-password');

    // Investments
    Route::get('/investments/create', [InvestmentController::class, 'create'])->name('investments.create');
    Route::post('/investments', [InvestmentController::class, 'store'])->name('investments.store');
    Route::get('/investments/{investment}', [InvestmentController::class, 'show'])->name('investments.show');

    // Transactions
    Route::get('/deposit', [TransactionController::class, 'createDeposit'])->name('deposit.create');
    Route::post('/deposit', [TransactionController::class, 'storeDeposit'])->name('deposit.store');
    Route::get('/withdrawal', [TransactionController::class, 'createWithdrawal'])->name('withdrawal.create');
    Route::post('/withdrawal', [TransactionController::class, 'storeWithdrawal'])->name('withdrawal.store');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
});

// Admin authentication routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Web\AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Web\AdminAuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\Web\AdminAuthController::class, 'logout'])->name('logout');
});

// Admin routes
Route::middleware(['auth', 'active.user', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Users management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}', [AdminController::class, 'user'])->name('users.show');
    Route::get('/users/{user}/json', [AdminController::class, 'showUser'])->name('users.json');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Transactions management
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
    Route::get('/transactions/{transaction}/json', [AdminController::class, 'showTransaction'])->name('transactions.json');
    Route::put('/transactions/{transaction}', [AdminController::class, 'updateTransaction'])->name('transactions.update');
    
    // Investments management
    Route::get('/investments', [AdminController::class, 'investments'])->name('investments');
    Route::get('/investments/{investment}/json', [AdminController::class, 'showInvestment'])->name('investments.json');
    
    // Plans management
    Route::get('/plans', [AdminController::class, 'plans'])->name('plans');
    Route::get('/plans/{plan}/json', [AdminController::class, 'showPlan'])->name('plans.json');
    Route::post('/plans', [AdminController::class, 'storePlan'])->name('plans.store');
    Route::put('/plans/{plan}', [AdminController::class, 'updatePlan'])->name('plans.update');
    Route::delete('/plans/{plan}', [AdminController::class, 'deletePlan'])->name('plans.delete');
    
    // Commissions management
    Route::get('/commissions', [AdminController::class, 'commissions'])->name('commissions');
    Route::get('/commissions/{commission}/json', [AdminController::class, 'showCommission'])->name('commissions.json');
    Route::put('/commissions/{commission}', [AdminController::class, 'updateCommission'])->name('commissions.update');
    
    // Team rewards management
    Route::get('/team-rewards', [AdminController::class, 'teamRewards'])->name('team-rewards');
    Route::get('/team-rewards/{teamReward}/json', [AdminController::class, 'showTeamReward'])->name('team-rewards.json');
    Route::put('/team-rewards/{teamReward}', [AdminController::class, 'updateTeamReward'])->name('team-rewards.update');
    
    // Wallets management
    Route::get('/wallets', [AdminController::class, 'wallets'])->name('wallets');
    Route::get('/wallets/{wallet}/json', [AdminController::class, 'showWallet'])->name('wallets.json');
    Route::put('/wallets/{wallet}', [AdminController::class, 'updateWallet'])->name('wallets.update');
});

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🏆 PretConnect Financial

**Plateforme d'investissement financier avec système de parrainage multi-niveaux**

Une application Laravel moderne avec un design inspiré d'Upwork utilisant une palette noir et doré pour une expérience utilisateur premium.

![Laravel](https://img.shields.io/badge/Laravel-10.x-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange?style=for-the-badge&logo=mysql)

## ✨ Fonctionnalités

### 💰 **Gestion Financière**
- Portefeuilles utilisateurs avec transactions en temps réel
- Plans d'investissement multiples avec rendements variables
- Système de dépôt et retrait sécurisé
- Historique complet des transactions

### 🎯 **Système MLM Avancé**
- Commissions de parrainage multi-niveaux
- Récompenses d'équipe basées sur la performance
- Tableau de bord analytique pour les parrains
- Bonus et challenges mensuels

### 👥 **Interface Utilisateur**
- Design moderne inspiré d'Upwork
- Palette noir et doré pour un look premium
- Dashboard interactif avec graphiques en temps réel
- Interface responsive et accessible

### 🔐 **Sécurité & Administration**
- Authentification sécurisée avec middleware
- Panel administrateur complet
- Logs et audit trails
- Protection CSRF et validation stricte

## 🚀 Installation Rapide

### Prérequis
- **PHP** 8.1 ou supérieur
- **Composer** 2.x
- **Node.js** 18.x ou supérieur
- **MySQL** 8.0 ou supérieur
- **Git**

### 1. Cloner le Projet
```bash
git clone https://github.com/votre-repo/pretconnectfinanc.git
cd pretconnectfinanc
```

### 2. Installation des Dépendances
```bash
# Dépendances PHP
composer install

# Dépendances JavaScript
npm install
```

### 3. Configuration de l'Environnement
```bash
# Copier le fichier d'environnement
copy .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 4. Configuration de la Base de Données
Éditez le fichier `.env` avec vos paramètres MySQL :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pretconnect_financial
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

### 5. Créer la Base de Données
```bash
# Créer la base de données
mysql -u root -p -e "CREATE DATABASE pretconnect_financial CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Exécuter les migrations
php artisan migrate

# Peupler avec des données de test
php artisan db:seed
```

### 6. Compilation des Assets
```bash
# Développement
npm run dev

# Production
npm run build
```

### 7. Démarrer le Serveur
```bash
# Serveur Laravel
php artisan serve

# Compilation en temps réel (nouveau terminal)
npm run dev
```

🎉 **Votre application est maintenant accessible sur** `http://localhost:8000`

## 👤 Comptes de Test

### Administrateur
- **Email :** admin@pretconnect.financial
- **Mot de passe :** admin123

### Utilisateur Test
- **Email :** user@example.com
- **Mot de passe :** password

## 📱 Fonctionnalités par Page

### 🏠 **Dashboard Utilisateur**
- Vue d'ensemble des investissements
- Graphiques de performance
- Statistiques de l'équipe
- Activité récente

### 💹 **Investissements**
- Catalogue des plans disponibles
- Historique des investissements
- Calculateur de rendements
- Gestion des renouvellements

### 💳 **Transactions**
- Dépôts par virement/carte
- Demandes de retrait
- Historique complet
- Statuts en temps réel

### 👥 **Équipe & Parrainage**
- Arbre généalogique
- Commissions gagnées
- Statistiques de l'équipe
- Outils de parrainage

### ⚙️ **Administration**
- Gestion des utilisateurs
- Configuration des plans
- Suivi des transactions
- Rapports analytiques

## 🛠️ Commandes Utiles

```bash
# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Optimisation pour la production
php artisan optimize

# Créer un nouvel utilisateur admin
php artisan make:user --admin

# Backup de la base de données
php artisan backup:run

# Tests
php artisan test
```

## 🎨 Personnalisation du Design

### Variables CSS Principales
```css
:root {
    --primary-gold: #FFD700;
    --secondary-gold: #FFA500;
    --dark-bg: #0D1117;
    --card-bg: #161B22;
    --border-color: #30363D;
}
```

### Modification des Couleurs
1. Éditez `resources/css/app.css`
2. Modifiez les variables CSS
3. Recompilez avec `npm run dev`

## 📊 Structure de la Base de Données

### Tables Principales
- **users** - Comptes utilisateurs
- **wallets** - Portefeuilles et soldes
- **plans** - Plans d'investissement
- **investments** - Investissements actifs
- **transactions** - Mouvements financiers
- **commissions** - Commissions gagnées
- **team_rewards** - Récompenses d'équipe

## 🔒 Sécurité

### Mesures Implémentées
- ✅ Authentification Laravel Sanctum
- ✅ Validation CSRF sur tous les formulaires
- ✅ Middleware de protection des routes
- ✅ Chiffrement des mots de passe (bcrypt)
- ✅ Validation stricte des données
- ✅ Logs des activités sensibles

### Recommandations
- 🔐 Utilisez HTTPS en production
- 🔑 Changez les clés secrètes
- 📝 Activez les logs détaillés
- 🛡️ Configurez un firewall
- 📧 Surveillez les alertes email

## 📈 Performance

### Optimisations Incluses
- ⚡ Cache des vues Blade
- 🗄️ Cache des configurations
- 📊 Requêtes optimisées avec Eloquent
- 🎯 Lazy loading des relations
- 📱 Assets compressés et minifiés

## 🤝 Contribution

1. **Fork** le projet
2. **Créer** une branche feature (`git checkout -b feature/AmazingFeature`)
3. **Commit** vos changements (`git commit -m 'Add AmazingFeature'`)
4. **Push** vers la branche (`git push origin feature/AmazingFeature`)
5. **Ouvrir** une Pull Request

## 📞 Support

- 📧 **Email :** support@pretconnect.financial
- 📱 **Téléphone :** +33 1 23 45 67 89
- 💬 **Discord :** [Rejoindre notre serveur](https://discord.gg/pretconnect)
- 📚 **Documentation :** [docs.pretconnect.financial](https://docs.pretconnect.financial)

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

---

<div align="center">
  <strong>Développé avec ❤️ par l'équipe PretConnect Financial</strong><br>
  <em>Votre réussite financière, notre engagement</em>
</div>

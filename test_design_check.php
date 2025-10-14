<?php

// Test rapide pour vérifier le design
$baseUrl = 'http://localhost:8001';

echo "=== Vérification du Design ===\n\n";

// Test de la page d'accueil
echo "1. Test de la page d'accueil...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36');

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpCode === 200) {
    echo "✅ Page d'accueil accessible (Code: $httpCode)\n";
    
    // Vérifier les éléments du design Binance
    $designElements = [
        'tailwindcss.com' => 'Tailwind CSS',
        'binance-black' => 'Couleur Binance Black',
        'binance-yellow' => 'Couleur Binance Yellow',
        'binance-dark' => 'Couleur Binance Dark',
        'PretConnect' => 'Logo PretConnect',
        'font-awesome' => 'Font Awesome Icons'
    ];
    
    foreach ($designElements as $element => $name) {
        if (strpos($response, $element) !== false) {
            echo "✅ $name détecté\n";
        } else {
            echo "❌ $name non détecté\n";
        }
    }
    
    // Vérifier la structure HTML
    if (strpos($response, '<nav class=') !== false) {
        echo "✅ Structure de navigation détectée\n";
    } else {
        echo "❌ Structure de navigation non détectée\n";
    }
    
    if (strpos($response, 'bg-binance-black') !== false) {
        echo "✅ Arrière-plan Binance appliqué\n";
    } else {
        echo "❌ Arrière-plan Binance non appliqué\n";
    }
    
} else {
    echo "❌ Erreur page d'accueil (Code: $httpCode)\n";
}

curl_close($ch);

// Test de la page de connexion
echo "\n2. Test de la page de connexion...\n";
$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $baseUrl . '/login');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36');

$loginResponse = curl_exec($ch2);
$loginCode = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

if ($loginCode === 200) {
    echo "✅ Page de connexion accessible (Code: $loginCode)\n";
    
    // Vérifier les éléments du design sur la page de connexion
    if (strpos($loginResponse, 'bg-binance-dark') !== false) {
        echo "✅ Design Binance appliqué sur la page de connexion\n";
    } else {
        echo "❌ Design Binance non appliqué sur la page de connexion\n";
    }
    
    if (strpos($loginResponse, 'border-binance-yellow') !== false) {
        echo "✅ Bordures jaunes Binance détectées\n";
    } else {
        echo "❌ Bordures jaunes Binance non détectées\n";
    }
    
} else {
    echo "❌ Erreur page de connexion (Code: $loginCode)\n";
}

curl_close($ch2);

echo "\n=== Vérification du Design Terminée ===\n";

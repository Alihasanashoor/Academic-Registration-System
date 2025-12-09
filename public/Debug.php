<?php
// debug.php — TEMPORARY, DELETE AFTER FIXING
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../services/PaymentApiClient.php';

// 1) Accept link_id from query OR fall back to session
$linkId = isset($_GET['link_id']) ? (string)$_GET['link_id'] : ((string)($_SESSION['User_ID'] ?? ''));

// Simple candidate set (keep it small & clear)
$numeric    = ltrim($linkId, '0');
$candidates = array_values(array_unique([
    $linkId,
    $numeric,
    '00' . ($numeric === '' ? '0' : $numeric),
]));

// 2) Call API
$API = new PaymentApiClient();
[$code, $resolved] = $API->resolveUserByAny($candidates);

// 3) Show exactly what was called + results
$meta = $API->getLastDebug();

header('Content-Type: text/html; charset=utf-8');
echo '<h1>Debug Payment API Resolve</h1>';

echo '<h2>Client configuration</h2>';
echo '<pre>' . htmlspecialchars(print_r([
    'baseUrl' => $meta['baseUrl'],
    'method'  => $meta['method'],
    'url'     => $meta['url'],
    'headers' => $meta['headers'],
], true)) . '</pre>';

echo '<h2>Request body (if any)</h2>';
echo '<pre>' . htmlspecialchars((string)$meta['requestBody']) . '</pre>';

echo '<h2>HTTP status</h2>';
echo '<pre>' . htmlspecialchars((string)$meta['http']) . '</pre>';

echo '<h2>Raw response</h2>';
echo '<pre>' . htmlspecialchars((string)$meta['raw']) . '</pre>';

echo '<h2>Decoded response</h2>';
echo '<pre>' . htmlspecialchars(print_r($meta['decoded'], true)) . '</pre>';

echo '<h2>Candidates tried</h2>';
echo '<pre>' . htmlspecialchars(print_r($candidates, true)) . '</pre>';

// Try some common card_id locations so you can see it quickly
$peek = $resolved['card_id']
    ?? ($resolved['data']['card_id'] ?? null)
    ?? ($resolved['Card_ID'] ?? null)
    ?? ($resolved['card']['card_id'] ?? null)
    ?? ($resolved['card']['Card_ID'] ?? null)
    ?? null;

echo '<h2>Best-guess card_id</h2>';
echo '<pre>' . htmlspecialchars(var_export($peek, true)) . '</pre>';

echo '<p style="color:#c00;font-weight:bold">Delete debug.php after you fix the issue.</p>';

// --- NEW: Show all possible card_id key names ---
echo '<h2>Check all possible card_id keys</h2>';
$keys = [
    'card_id', 
    'Card_ID',
    'card.card_id',
    'card.Card_ID',
    'data.card_id',
    'data.Card_ID'
];

foreach ($keys as $k) {
    $val = null;
    // handle dot notation
    if (strpos($k, '.') !== false) {
        [$first, $second] = explode('.', $k, 2);
        if (isset($resolved[$first][$second])) {
            $val = $resolved[$first][$second];
        }
    } else {
        $val = $resolved[$k] ?? null;
    }
    echo '<pre>' . htmlspecialchars($k . ' => ' . var_export($val, true)) . '</pre>';
}

// --- Keep your best guess as well ---
$peek = $resolved['card_id']
    ?? ($resolved['data']['card_id'] ?? null)
    ?? ($resolved['Card_ID'] ?? null)
    ?? ($resolved['card']['card_id'] ?? null)
    ?? ($resolved['card']['Card_ID'] ?? null)
    ?? null;

echo '<h2>Best-guess card_id</h2>';
echo '<pre>' . htmlspecialchars(var_export($peek, true)) . '</pre>';


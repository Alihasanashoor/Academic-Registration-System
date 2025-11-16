<?php
/**
 * ===========================================================
 * VIEW: Transaction Result Page (transaction_result.php)
 * ===========================================================
 * ROLE:
 *   • Purely presentational. This file shows the payment result
 *     after the controller finishes the transaction logic.
 *   • It must NOT call the database or Payment API.
 *   • It simply reads $result prepared by PaymentsController::renderResult().
 *
 * DATA IT EXPECTS:
 *   $result = [
 *       'ok'         => bool,
 *       'message'    => string,
 *       'transaction'=> array (optional),
 *       'idempotent' => bool (optional)
 *   ]
 *
 * STRUCTURE:
 *   1. Start session for header/footer use.
 *   2. Set up page title & load CSS (cache-busted).
 *   3. Require the shared Header.php (common <head> and nav).
 *   4. Print HTML container with banners and tables.
 *   5. If $result['ok'] = true → success banner + transaction table.
 *   6. If $result['ok'] = false → error banner.
 *   7. If $result is missing → generic error.
 *   8. Include Logout.php for footer/logout link.
 */
//start session
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
/** Resolve project root: from /pages/transactions → /resturcterd */
$ROOT = dirname(__DIR__, 2);

// Handle logout BEFORE rendering anything
require_once $ROOT .'/Controllers/LogoutController.php'; 
LogoutController::handle();


$pageTitle="Payment Result"; //set page title
$cssFs = __DIR__ . '/../Style/transaction.css';// filesystem path to the css file
$cssUrl = '/Academic%20Registration%20System/resturcterd/Style/transaction.css'; //style path
// append ?v=TIMESTAMP so the browser fetches the latest file
$styleSheet = $cssUrl . '?v=' . (is_file($cssFs) ? filemtime($cssFs) : time());
//load the LoginController from the Controllers directory
require_once $ROOT . '/Controllers/LoginController.php';
require_once $ROOT . '/View/Header.php'; // Include the header template (contains HTML <head> and top structure)
require_once $ROOT . '/View/partials/main-transaction-container.php'; 


// Load logout button
require_once $ROOT .'/View/View-Registered-Courses-Button.php'; //load a button so it gose to Register Courses page
require_once $ROOT .'/View/Logout.php'; 






?>




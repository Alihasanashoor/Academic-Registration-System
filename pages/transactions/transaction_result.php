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

$pageTitle="Payment Result"; //set page title
/** Resolve project root: from /pages/transactions → /resturcterd */
$ROOT = dirname(__DIR__, 2);
$cssFs = __DIR__ . '/../Style/transaction.css';// filesystem path to the css file
$cssUrl = '/Academic%20Registration%20System/resturcterd/Style/transaction.css'; //style path
// append ?v=TIMESTAMP so the browser fetches the latest file
$styleSheet = $cssUrl . '?v=' . (is_file($cssFs) ? filemtime($cssFs) : time());
//load the LoginController from the Controllers directory
require_once $ROOT . '/Controllers/LoginController.php';
require_once $ROOT . '/View/Header.php'; // Include the header template (contains HTML <head> and top structure)
require_once $ROOT .'/View/Logout.php'; //load logout button





//handel logout button
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['Logout'])){
    $controller = new LoginController();
    $controller->Logout();
}

?>
<!--Begin the main container-->
<div class="container">
    <!--Page heading-->
    <h1 class="h1-center">Payment Transaction Details</h1>
    <!--Only proceed if $result is defined and is an array-->
    <?php if(isset($result) && is_array($result)):?>
    <!--SUCCESS CASE: payment succeeded-->
    <?php if(!empty($result['ok'])):?>
        <div class="banner-success">
            <!--Show the success message(escaped for safety)-->
            <h3><?=htmlspecialchars($result['message'] ?? 'Payment successful')?></h3>
        </div>
        <?php
            /**
            * Checks if the result contains transaction data for display.
            * - Ensures the 'transaction' key exists and is not empty.
            * - Verifies it's an array to prevent type errors in the partial.
            * If valid, it passes the data to a dedicated view partial for rendering.
            */
            if(!empty($result['transaction']) && is_array($result['transaction'])){
                $transaction= $result['transaction'];
                require_once $ROOT . '/View/partials/transaction_table.php';
            }?>
        <?php endif; ?>
        <!--FAILURE CASE: payment failed-->
        <?php else:?>
            <div class="banner-error">
                <!--error messafe returned by API/controller-->
                <h3><?= htmlspecialchars($result['message'] ?? 'Payment failed') ?></h3>
            </div>
        <?php endif; ?>
    </div>
    <div class="button">
    <?php require_once $ROOT .'/View/Register-Courses-Button.php'; //load a button so it gose to Register Courses page ?>
</div>

<!-- 14. End body and html tags started by Header.php -->
</body>
</html>
</div>
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
   

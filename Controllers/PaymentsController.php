<?php
/**
 * PaymentsController
 * ------------------
 * This controller sits in your Academic Registration System.
 * It receives POSTs from your “Pay” button, calls the Payment API,
 * and then shows a result page.
 */

require_once __DIR__. '/../services/PaymentApiClient.php'; //API client

final class PaymentsController{
    public function payCourse(){
        session_start();

    // If not logged in, redirect to your homepage.
    if(empty($_SESSION['User_ID']) || ($_SESSION['Role']??'') !== 'student'){
        header('Location: /pages/index.php');
        exit;
    }
    //READ INPUT: get course_id and price from the hidden inputs
    $course_ID=(string)$_POST['Course_ID'];
    $price=(float)$_POST['Price'];

    // Validate the input; show error page if invalid
    if($course_ID == '' || $price <=0 ){
        $this->renderResult([
            'ok' => false,
            'message' => 'Invalid course or price.',
        ]);
        return;
    }
    //Resolve Student, login ID equals the Link_ID in the payment DB.
    //call the Payment API’s /v1/students/resolve to get the card.
$linkIdRaw = (string)($_SESSION['User_ID'] ?? '');
$numeric   = ltrim($linkIdRaw, '0'); // "007" -> "7" ; "14" -> "14"

// Candidate list, in order of likelihood for your DB style:
$candidates = [];
if ($linkIdRaw !== '') {
    $candidates[] = $linkIdRaw;                           // exact
    $candidates[] = '00' . ($numeric === '' ? '0' : $numeric); // **explicit '00' + number**
    $candidates[] = $numeric;                             // no leading zeros
    $candidates[] = str_pad($numeric, 3, '0', STR_PAD_LEFT);   // legacy 3-digit
    $candidates[] = str_pad($numeric, 6, '0', STR_PAD_LEFT);   // legacy 6-digit
}
error_log('User_ID(raw)=' . $linkIdRaw);
error_log('Resolve candidates=' . json_encode($candidates));

$API = new PaymentApiClient();
[$code, $payload] = $API->resolveUserByAny($candidates);


//pull Card_ID out of the API response
$cardId = (int)(
    $payload['card_id']
    ?? $payload['Card_ID']
    ?? ($payload['card']['card_id'] ?? null)
    ?? ($payload['card']['Card_ID'] ?? null)
    ?? 0
);

if ($cardId <= 0) {
    $this->renderResult([
        'ok'      => false,
        'message' => 'No card found for this student.',
        'api'     => $payload,   // keep for debugging in the view
        'sent'    => ['link_id' => $candidates ?? $linkIdRaw], // quick debug

    ]);
    return;
}
    //BUILD A UNIQUE IDEMPOTENCY KEY
    // Pattern: user-<id>|course-<courseId>|ts-<timestamp>
    // This prevents double charges if the student double-clicks.
    $idempotencyKey= 'user-' . $_SESSION['User_ID'] 
                    . '|course-' . $course_ID;
                    

    //call the payment API to withdraw funds
    [$code, $body]= $API->withdraw($cardId,$price,$course_ID,$idempotencyKey);

    //DECIDE WITCH PAGE TO SHOW:
    //CASE A: Sucuess (HTTP 201 and status=Sucuess)
    

    
        $transaction = [
        // Status from API
        'status' => $body['status'] ?? ($body['transaction']['status'] ?? ''),

        // Card ID from API
        'card_id' => (int)(
    $body['card_id']                                      // e.g. { "card_id": 910 }
    ?? ($body['card_ID'] ?? null)                         // e.g. { "Card_ID": 910 }
    ?? ($body['transaction']['card_id'] ?? null)          // e.g. { "transaction": { "card_id": 910 } }
    ?? ($body['transaction']['Card_ID'] ?? null)          // e.g. { "transaction": { "Card_ID": 910 } }
    ?? $cardId                                            // fallback to resolved value so table is never N/A
),

        // Transaction type (if provided by API)
        'type' => $body['type'] ?? ($body['transaction']['type'] ?? ''),

        // Amount taken – map from both possible API keys
        'Amount_taken' => (float)(
            $body['Amount_taken']
            ?? $body['amount']
            ?? ($body['transaction']['Amount_taken'] ?? $body['transaction']['amount'] ?? 0)
        ),

        // Balance after transaction – map from both possible API keys
        'Balance_After' => (float)(
            $body['Balance_After']
            ?? $body['balance_after']
            ?? ($body['transaction']['Balance_After'] ?? $body['transaction']['balance_after'] ?? 0)
        ),

        // Product (course) name – map from both possible API keys
        'Product' => $body['Product']
            ?? $body['product']
            ?? ($body['transaction']['Product'] ?? $body['transaction']['product'] ?? ''),

        // Transaction ID – map from both possible API keys
        'Transaction_ID' => $body['Transaction_ID']
            ?? $body['transaction_id']
            ?? ($body['transaction']['Transaction_ID'] ?? $body['transaction']['transaction_id'] ?? ''),

        // Idempotency key – map from both possible API keys
        'Idempotency_key' => $body['Idempotency_key']
            ?? $body['idempotency_key']
            ?? ($body['transaction']['Idempotency_key'] ?? $body['transaction']['idempotency_key'] ?? ''),
    ];
    if($code == 201 && ($body['status']??'')=='success'){
        $this->renderResult([
            'ok'            => true,
            'message'       => 'Payment successful',
            'transaction'   =>$transaction,
            'idempotent' =>false,
            'api'         => $body,
        ]);}
     

    //CASE B: same idempotent key used before , already processed
    if(!empty($body['idempotent'])){
        $this->renderResult([
            'ok'            => true,
            'message'       =>'Payment already processed earlier',
            'transaction'   =>$body['transaction'] ?? [],
            'idempotent'    =>true ,
        ]);
        return;
    }

    //CASE C: Failure insufficient funds or error
    $this->renderResult([
        'ok'        => false,
        'message'   => $body['reason'] ?? ($body['error'] ?? 'Payment Failed'),
        'api'     => $body,
        'code'    => $code,
    ]);
}

    /**
     * renderResult()
     * --------------
     * A very tiny “view renderer” that includes a PHP page
     * and passes it the $result array so you can print a nice message.
     */
    private function renderResult(array $data){
        $result=$data;
        require __DIR__ . '/../pages/transactions/transaction_result.php'; // show result page
        exit;
    }

}

// FRONT CONTROLLER PATTERN: Direct entry point for payment requests
// This allows the controller to be called directly from form actions
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['pay'])){
    $controller= new PaymentsController();
    $controller->payCourse();
}
?>
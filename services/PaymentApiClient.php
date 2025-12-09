<?php 
/**
 * PaymentApiClient
 * ----------------
 * A very helper that calls your Payment API using cURL.
 * Keeps the API key hidden on the server .
 */

//create a new PaymentApiClient() wherever you need to charge a student or look up their card/balance.

final class PaymentApiClient{
    // string base URL of payment API
    private string $baseUrl;

    //string the secret API key
    private string $apiKey;
    /**
     * Constructor
     * Runs automatically when you do new PaymentApiClient().
     * Reads base URL + API key from config/payment.php.
     */

     /** 
     * DEBUG: capture last HTTP call for diagnostics 
     */
    private ?string $lastUrl = null;           // full URL called
    private ?string $lastMethod = null;        // GET/POST/...
    private ?string $lastRequestBody = null;   // JSON we sent (if any)
    private ?int    $lastHttpCode = null;      // HTTP status
    private $lastRawBody = null;               // raw response text (string)
    private ?array  $lastDecoded = null;       // json_decode($raw,true)

    /** Return a compact array you can print on your debug page */
    public function getLastDebug(): array{
        return [
            'method'      => $this->lastMethod,
            'url'         => $this->lastUrl,
            'requestBody' => $this->lastRequestBody,
            'headers'     => ['X-API-KEY' => $this->apiKey ? '***set***' : '***missing***'],
            'http'        => $this->lastHttpCode,
            'raw'         => $this->lastRawBody,
            'decoded'     => $this->lastDecoded,
            'baseUrl'     => $this->baseUrl,
        ];
    }
    public function __construct()
    {
        //Load the array returned by config/payment.php
        $config= require __DIR__.'/../config/payment.php';

        // Trim any trailing slash so we don’t get // in URLs later
        $this->baseUrl=rtrim($config['base_url'],'/');
        // Store API key
        $this->apiKey=$config['api_key'];
    }
    
    public function withdraw(int $cardId, float $amount, string $product, string $idempotencyKey){
        //this calls POST /v1/transactions/withdraw on your Payment API.
        // We call our private request() helper below

        return $this->request(
            'POST', //HTTP methid
            '/v1/transactions/withdraw', // path on the API
            [
                //json payload to send
                'card_id' => $cardId,
                'Amount_taken' => $amount,
                'product' => $product,
                'idempotency_key' => $idempotencyKey,
            ]
            );
    }

     /**
     * resolveStudent()
     * ----------------
     * Calls GET /v1/students/resolve?link_id=XYZ on your Payment API.
     * Use it when you know the student’s login Link_ID but not their Card_ID.
     */

    public function resolveUser(string $linkId){
        $qs='?link_id=' . rawurlencode($linkId);
        return $this->request('GET','/v1/students/resolve' .$qs);
    }
    

    public function resolveUserByAny(array $users){
        //helper that tries multiple candidate link IDs
        foreach($users as $student){
            $student =(string)$student;
            if($student==''){
                continue;
            }
            //Log which candidate is being attempted for precise debugging
            error_log('[resolveUserByAny] trying link_id=' . $student);

            [$code,$body] = $this->resolveUser($student);

            // UNWRAP common envelopes e.g. { data: {...} }
            $payload = $body['data']
                ?? $body['result']
                ?? $body['payload']
                ?? $body;

            // Extract a usable card id from the (possibly unwrapped) body
            $cardId = (int)(
                $payload['card_id']
                ?? ($payload['card']['card_id'] ?? null)
                ?? ($payload['card']['Card_ID'] ?? null)
                ?? ($payload['Card_ID'] ?? null)
                ?? 0
            );
            if($code>=200 && $code<300 && $cardId>0){
                return[$code,$payload];
            }
            //Log failures to see exact API response causing the miss
            error_log('[resolveUserByAny] failed for' . $student . 'body=' .json_encode($body));
        }
        return [400, ['error' => 'Resolution failed for all students']];

    }
    public function request(string $method, string $path, ?array $json=null){
        // Full URL we’re calling (base URL + path)
        $url =$this->baseUrl . $path;

        // Create a new cURL handle
        $ch=curl_init($url);

        //Build HTTP headers including the API key and JSON content type
        $headers=[
            'X-API-KEY: ' . $this->apiKey, //secret key in header
            'Content-Type: application/json', // we’re sending JSON
        ];

        //set all cURL options at once 
        curl_setopt_array($ch,[
            CURLOPT_RETURNTRANSFER => true,     //we want the response as a string, not echo
            CURLOPT_CUSTOMREQUEST => $method,   //Sets the HTTP method for the request. $method could be 'GET', 'POST', 'PUT', 'DELETE', etc.
            CURLOPT_HTTPHEADER => $headers,     //Adds custom HTTP headers to the request.
            CURLOPT_TIMEOUT => 20,              //seconds before giving up 
        ]);

        //if there a JSON payload, encode it and attach as request body
        if($json !==null){
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
        }
        // preflight debug for visibility (URL + method)
        error_log('[request] ' . $method . ' ' . $url);

        //Exeute the HTTP request
        $raw=curl_exec($ch);

        //Get http status code(201,200,409,etc)
        $code=(int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        //if cURL itself failed(network error, DNS,etc)
        $error=curl_error($ch);
          // --- DEBUG: capture response ---
    $this->lastHttpCode = $code;
    $this->lastRawBody  = $raw;

    if($raw === false){
        curl_close($ch);
        $this->lastDecoded = ['error'=>"HTTP error: $error"];
        return [0, $this->lastDecoded];
    }
     

        //if raw == false then cURL failed at network level
        if($raw==false){
            return[0,['error'=>"HTTP error: $error"]];
        }
        // post-call debug for visibility (status + first part of body)
        if ($code !== 0) {
            $peek = substr($raw, 0, 500);
            error_log("[request] HTTP=$code BODY_PREVIEW=" . $peek);
        } else {
            error_log("[request] HTTP=0 (no status) RAW_PREVIEW=" . substr($raw, 0, 200));
        }

        //decode JSON
        $body=json_decode($raw, true);

        //if response wasnt valid json, return raw text inside error
        if(!is_array($body)){
            $body=['error' => 'Non-JSON response from Payment API', 'raw' => $raw];
        }

        //always close the handle
        curl_close($ch);

        //return [HTTP code, decoded body]
        return[$code, $body];




    }
}

?>
<?php
namespace App\Http\Services;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
class CreatePaymentService {
    private  $paymentId;
    private  $paymentAccessToken;
    private  $paymentEmail;
    private  $paymentValue;
    private  $paymentDescription;
    function  __construct($defaultPaymentId = "", $defaultPaymentAccessToken = "", $defaultPaymentEmail = "", $defaultPaymentValue = "", $defaultPaymentDescription = "")
    {
        $this->paymentId = $defaultPaymentId;
        $this->paymentAccessToken = $defaultPaymentAccessToken;
        $this->paymentEmail = $defaultPaymentEmail;
        $this->paymentValue = $defaultPaymentValue;
        $this->paymentDescription = $defaultPaymentDescription;
    }
    public function mercadopago($paymentId,$paymentAccessToken,$paymentEmail,$paymentValue,$paymentDescription){
        $this->paymentId = $paymentId;
        $this->paymentAccessToken = $paymentAccessToken;
        $this->paymentEmail = $paymentEmail;
        $this->paymentValue = $paymentValue;
        $this->paymentDescription = $paymentDescription;
        MercadoPagoConfig::setAccessToken($this->paymentAccessToken);
        $client = new PaymentClient();
        try{
       
        $request = [
            "transaction_amount" => $this->paymentValue,
            "description" => $this->paymentDescription,
            "payment_method_id" => "pix",
            "payer" => [
                "email" => $this->paymentEmail,
            ]
        ];
        $request_options = new RequestOptions();
        $request_options->setCustomHeaders(["X-Idempotency-Key: $this->paymentId"]);
        $createPayment = $client->create($request, $request_options);
        return $createPayment;
       }catch(MPApiException $e){
            $e->getApiResponse()->getStatusCode();    
            var_dump($e->getApiResponse()->getContent());
       }
    }
}

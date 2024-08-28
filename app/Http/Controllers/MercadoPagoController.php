<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Services\CreatePaymentService;

class MercadoPagoController extends Controller
{
    private  $paymentId;
    private  $paymentAccessToken;
    private  $paymentEmail;
    private  $paymentValue;
    private  $paymentDescription;

    function __construct($defaultPaymentId = "", $defaultPaymentAccessToken = "", $defaultPaymentEmail = "", $defaultPaymentValue = "", $defaultPaymentDescription = "")
    {
        $this->paymentId = $defaultPaymentId;
        $this->paymentAccessToken = $defaultPaymentAccessToken;
        $this->paymentEmail = $defaultPaymentEmail;
        $this->paymentValue = $defaultPaymentValue;
        $this->paymentDescription = $defaultPaymentDescription;
    }

    public function create(Request $request)
    {
        $this->paymentId = $request['paymentId'];
        $this->paymentAccessToken = $request['paymentAccessToken'];
        $this->paymentEmail = $request['paymentEmail'];
        $this->paymentValue = $request['paymentValue'];
        $this->paymentDescription = $request['paymentDescription'];
        if(!$request['paymentId'] && !$request['paymentAccessToken'] && !$request['paymentEmail'] && !$request['paymentValue'] && !$request['paymentDescription']){
            return response()->json([
                'code'=>4402,
                'data' => null,
                'message' => 'payment not created'
            ]);
        }else{
            $paymentController = new CreatePaymentService();
            $newValue = floatval($this->paymentValue);
            $createNewPayment = $paymentController->mercadopago($this->paymentId,$this->paymentAccessToken,$this->paymentEmail,$newValue,$this->paymentDescription);
            $paymentData = [
                "id" => $createNewPayment->id,
                "status" => $createNewPayment->status,
                "qrcode" => $createNewPayment->point_of_interaction->transaction_data->qr_code,
                "qrcodeImage" => $createNewPayment->point_of_interaction->transaction_data->qr_code_base64
            ];
            return response()->json([
                'code' => 2201,
                'message' => 'payment created',
                'data' =>  $paymentData,
                
            ]);
        }
    }
}




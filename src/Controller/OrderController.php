<?php

namespace App\Controller;

use Stripe\Refund;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface;

class OrderController extends AbstractController
{
    /**
     * @Route("/booking/payment/{token}/{amount}", name="booking_payement")
     * @Method("POST")
     */
    public function checkoutAction(Request $request,$token,$amount)
    {
        
        if ($request->isMethod('POST')) {
            try {   
                \Stripe\Stripe::setApiKey($this->getParameter('app.secret.key'));
                \Stripe\PaymentIntent::create([

                    "amount" => $amount,
                    "currency" => "EUR",
                    "description" => "app hotel!",
                    "payment_method" => $token,
                    "confirm"=> true,
                ]);
                return new Response( "payement réussi",200,[
                    "Content-Type" => "application/json"
                ]);
                
            }
            catch(\Exception $e){
                return new Response("$e",500,[
                    "Content-Type" => "application/json"
                ]);
            }
        }
    }

    /**
     * @Route("/booking/refund/{token}/{amount}", name="booking_refund")
     * @Method("POST")
     */
    public function refundAction(Request $request, Integer $amount)
    {
        
        if ($request->isMethod('POST')) {
            try {   
                \Stripe\Stripe::setApiKey($this->getParameter('app.secret.key'));
                \Stripe\Refund::create([
                    "amount" => $amount,
                    "currency" => "EUR",
                    "payment_intent" =>  "",
                    "description" => "refund app hotel!",
                ]);
                return new Response( "remboursement réussi",200,[
                    "Content-Type" => "application/json"
                ]);
            }
            catch(\Exception $e){
                return new Response("$e", 500,[
                    "Content-Type" => "application/json", 
                    'Message' => 'Une erreur est survenue pendant la tentative de remboursement'
                ]);
            }
        }
    }
}
    
    
    
    
    


<?php
require 'vendor/autoload.php';
include_once "constants.php";
class StripeHelper
{
    /**
     * @var \Stripe\StripeClient
     */
    public $stripeClient;

    public function __construct()
    {
        $this->stripeClient = new \Stripe\StripeClient("put_your_API_KEY_HERE");
    }
    /**
     * Create product
     * @return \Stripe\Product
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createProducts()
    {
        return $this->stripeClient->products->create(array(
            'name' => 'Load Your Card',
            'description' => 'Load Your Trips.',
        ));
    }

    /**
     * Create price
     * @param $product
     * @param $productPrice
     * @return \Stripe\Price
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createProductPrice($product, $productPrice)
    {
        return $this->stripeClient->prices->create(array(
            'unit_amount' => $productPrice * 100,
            'currency' => 'PHP',
            'product' => $product->id,
        ));
    }
    /**
     * Get session detail
     * @param $sessionId
     * @return \Stripe\Checkout\Session
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getSession($sessionId)
    {
        return $this->stripeClient->checkout->sessions->retrieve($sessionId);
    }
}

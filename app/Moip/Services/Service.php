<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 15:04
 */

namespace App\Moip\Services;

use App\Moip\Exceptions\MoipIdException;
use App\Moip\Resources\BillingAddressResource;
use App\Moip\Resources\CreditCardResource;
use App\Moip\Resources\CustomerResource;
use App\Moip\Resources\DocumentResource;
use App\Moip\Resources\HolderResource;
use App\Moip\Resources\OrderResource;
use App\Moip\Resources\PhoneResource;
use App\Moip\Resources\ProductResource;
use App\Moip\Resources\ShippingAddressResource;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Moip\Auth\BasicAuth;
use Moip\Moip;
use Moip\Resource\Holder;

/**
 * Class Service
 * @package App\Moip\Services
 */
abstract class Service
{
    /**
     * @var $customer CustomerResource
     * @var $moip Moip
     */
    protected $moip;
    protected $customer;
    protected $creditCard;
    protected $ticket;
    protected $order;
    protected $boleto;
    protected $shipping;
    protected $products = [];
    protected $billingAddress;
    protected $shippingAddress;
    protected $holder;
    protected $payment;
    protected $endpoint;
    protected $key;
    protected $token;

    /**
     * @param $order
     * @param $customer
     * @return OrderResource
     */
    abstract public function transformOrder($order, $customer);

    /**
     * @param $customer
     * @param DocumentResource|null $documentResource
     * @param PhoneResource|null $phoneResource
     * @param ShippingAddressResource $shippingAddressResource
     * @return CustomerResource
     */
    abstract public function transformCustomer($customer,
                                               DocumentResource $documentResource = null,
                                               PhoneResource $phoneResource = null,
                                               ShippingAddressResource $shippingAddressResource = null);

    /**
     * @param $hash
     * @param $parcelas
     * @param HolderResource $holder
     * @return CreditCardResource
     */
    abstract public function transformCard($hash, $parcelas, HolderResource $holder);

    /**
     * @param $product
     * @return ProductResource
     */
    abstract public function transformProduct($product);


    /**
     * MoipService constructor.
     */
    public function __construct()
    {
        $this->token = env('MOIP_TOKEN');
        $this->key = env('MOIP_KEY');
        $this->endpoint = env('MOIP_HOMOLOGATED', false) ? Moip::ENDPOINT_PRODUCTION : Moip::ENDPOINT_SANDBOX;

        $this->moip = new Moip(new BasicAuth($this->token, $this->key), $this->endpoint);
    }

    /**
     * @return $this|\Moip\Resource\Orders|\stdClass
     * @throws MoipIdException
     */
    public function createOrder()
    {
        if (!$this->customer->hasMoipId()) {
            throw new MoipIdException($this->customer);
        }

        $moipOrder = $this->moip->orders()->setOwnId(uniqid());

        foreach ($this->order->products as $product) {
            $moipOrder->addItem($product->name, $product->quantity, $product->detail, $product->price);
        }

        $moipOrder->setShippingAmount($this->order->shipping);
        $moipOrder = $moipOrder->setCustomer($this->getCustomerOnMoip($this->customer->moipId));
        try {
            $order = $moipOrder->create();
            $this->order->moipId = $order->getId();
            $this->order->total = $order->getAmountTotal();
            $this->order->moipOrder = $order;

            return $this->order;
        } catch (\Exception $e) {
            dd($e);
        }

    }

    /**
     * @return CustomerResource
     */
    public function createCustomer()
    {
        $customer = $this->customer;
        $phone = $customer->phone;
        $taxDocument = $customer->taxDocument;
        $billingAddress = $customer->billingAddress;
        $shippingAddress = $customer->shippingAddress;
        $moipBuyer = $this->moip->customers()->setOwnId(uniqid())
            ->setFullname($customer->fullName)
            ->setEmail($customer->email)
            ->setTaxDocument(
                $taxDocument->number,
                $taxDocument->type
            );


        $moipBuyer->setPhone(
            $phone->areaCode,
            $phone->number,
            $phone->countryCode
        );
        if ($customer->hasBillingAddress()) {
            $moipBuyer->addAddress(
                $billingAddress->type,
                $billingAddress->street,
                $billingAddress->streetNumber,
                $billingAddress->district,
                $billingAddress->city,
                $billingAddress->state,
                $billingAddress->zipCode,
                $billingAddress->complement
            );
        }

        if ($customer->hasShippingAddress()) {
            $moipBuyer->addAddress(
                $shippingAddress->type,
                $shippingAddress->street,
                $shippingAddress->streetNumber,
                $shippingAddress->district,
                $shippingAddress->city,
                $shippingAddress->state,
                $shippingAddress->zipCode,
                $shippingAddress->complement
            );
        }
        try {
            $this->customer->moipId = $moipBuyer->create()->getId();
        } catch (\Exception $e) {
            dd($e);
        }

        return $this->customer;
    }

    /**
     * @return mixed
     */
    public function createPayment()
    {
        $order = $this->getOrderOnMoip($this->order->moipId);

        if ($this->creditCard) {
            $taxDocumentHolder = $this->holder->document;
            $phoneHolder = $this->holder->phone;

            $holder = $this->moip->holders()->setFullname($this->holder->fullName)
                ->setBirthDate($this->holder->birthDate)
                ->setTaxDocument($taxDocumentHolder->number, $taxDocumentHolder->type)
                ->setPhone($phoneHolder->areaCode, $phoneHolder->number, $phoneHolder->countryCode);

            $payment = $order->payments()
                ->setCreditCardHash($this->creditCard->hash, $holder)
                ->setInstallmentCount($this->creditCard->parcelas);
        } else if ($this->ticket) {
            $payment = $order->payments()
                ->setBoleto($this->ticket->expiration_date, $this->ticket->logo_uri, $this->ticket->instruction_lines);
        }
        $payment = $payment->execute();
        $this->payment = $payment;

        return $this->payment;

    }

    /**
     * @param $moipKey
     * @return \Moip\Resource\Customer|\stdClass
     */
    public function getCustomerOnMoip($moipKey)
    {
        return $this->moip->customers()->get($moipKey);
    }

    /**
     * @param $moipKey
     * @return \stdClass
     */
    public function getOrderOnMoip($moipKey)
    {
        return $this->moip->orders()->get($moipKey);
    }

    /**
     * @param Model $model
     * @param CustomerResource $customer
     * @throws MoipIdException
     */
    public function createCreditCard(Model $model, CustomerResource $customer)
    {
        if (!$customer->hasMoipId()) {
            throw new MoipIdException($customer);
        }
        $card = $this->transformCard($model);

        $this->moip->customers()->creditCard()
            ->setExpirationMonth($card->expirationMonth)
            ->setExpirationYear($card->expirationYear)
            ->setNumber($card->number)
            ->setCVC($card->cvc)
            ->setFullName($card->holder->fullName)
            ->setBirthDate($card->holder->birthDate)
            ->setTaxDocument($card->taxDocument->type, $card->taxDocument->number)
            ->setPhone($card->phone->countryCode, $card->phone->areaCode, $card->phone->number)
            ->create($customer->moipId);
    }

    /**
     * @param CreditCardResource $creditCard
     * @throws MoipIdException
     */
    public function removeCreditCard(CreditCardResource $creditCard)
    {
        if (!$creditCard->hasMoipId()) {
            throw new MoipIdException($creditCard);
        }
        $this->moip->customers()->creditCard()->delete($creditCard->moipId);
    }

    /**
     * @param $events
     * @param $link
     */
    public function createWebhook(array $events, string $link)
    {
        $http = new Client();
        $response = $http->post($this->endpoint.'/v2/preferences/notifications', [
            'headers' => [
                'Authorization' => 'Basic ' .base64_encode($this->token.':'.$this->key),
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'events' => $events,
                "target" => $link,
                'media' => "WEBHOOK"
            ]
        ]);
        return $response;
    }

    /**
     * @param string $link
     * @return bool
     */
    public function removeWebhook(string $link)
    {
        $webhooks = $this->getWebhooksOnMoip();
        $removeu = false;
        foreach($webhooks as $webhook){
            if($webhook->target === $link || strpos($webhook->target, 'localhost')){
                $http = new Client();
                $response = $http->delete($this->endpoint.'/v2/preferences/notifications/'.$webhook->id, [
                    'headers' => [
                        'Authorization' => 'Basic ' .base64_encode($this->token.':'.$this->key),
                        'Content-Type' => 'application/json'
                    ]
                ]);
                $removeu = true;
            }
        }
        return $removeu;
    }

    /**
     * @return array
     */
    public function getWebhooksOnMoip()
    {
        return $this->moip->notifications()->getList()->getNotifications();
    }
}
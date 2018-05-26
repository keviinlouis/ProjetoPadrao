<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 06/02/2018
 * Time: 11:39
 */

namespace App\Moip\Services;


use App\Entities\Cliente;
use App\Entities\Oficina;
use App\Entities\Plano;
use App\Moip\Resources\AddressResource;
use App\Moip\Resources\BillingAddressResource;
use App\Moip\Resources\CpfDocumentResource;
use App\Moip\Resources\CreditCardResource;
use App\Moip\Resources\CustomerResource;
use App\Moip\Resources\DocumentResource;
use App\Moip\Resources\HolderResource;
use App\Moip\Resources\OrderResource;
use App\Moip\Resources\PhoneResource;
use App\Moip\Resources\ProductResource;
use App\Moip\Resources\ShippingAddressResource;
use App\Moip\Resources\TicketResource;

/**
 * Class MoipService
 * @package App\Moip\Services
 */
class MoipService extends Service
{
    public $instructionsTicket = [

    ];

    /**
     * @param $order
     * @param $customer
     * @return OrderResource
     */
    public function transformOrder($order, $customer)
    {
        $product = new ProductResource(
            $order->nome,
            1,
            $order->nome,
            $order->valor
        );

        $resource = new OrderResource(
            uniqid(),
            [$product],
            $customer
        );

        $this->order = $resource;

        return $this->order;
    }

    /**
     * @param Oficina $customer
     * @param DocumentResource|null $documentResource
     * @param PhoneResource|null $phoneResource
     * @param ShippingAddressResource $shippingAddressResource
     * @return CustomerResource
     */
    public function transformCustomer(
        $customer,
        DocumentResource $documentResource = null,
        PhoneResource $phoneResource = null,
        ShippingAddressResource $shippingAddressResource = null
    )
    {
        if(!$phoneResource){
            $phoneResource = new PhoneResource($customer->telefone);
        }
        if(!$documentResource){
            $document = $customer->cnpj ?: $customer->cpf;

            $type = $customer->cnpj?DocumentResource::CNPJ:DocumentResource::CPF;

            $documentResource = new DocumentResource($type, $document);
        }

        if(!$shippingAddressResource){
            $shippingAddressResource = $this->transformShippingAddress($customer->endereco);
        }
        $resource = new CustomerResource(
            uniqid(),
            $customer->nome,
            $customer->email,
            $documentResource,
            $phoneResource,
            $shippingAddressResource,
            $customer->moip_id
        );

        $this->customer = $resource;

        return $this->customer;
    }

    /**
     * @param $hash
     * @param $parcelas
     * @param HolderResource $holder
     * @return CreditCardResource
     */
    public function transformCard($hash, $parcelas, HolderResource $holder)
    {
        $resource = new CreditCardResource($holder, $parcelas, $hash);

        $this->creditCard = $resource;

        return $this->creditCard;
    }

    /**
     * @return TicketResource
     */
    public function transformTicket(){
        $resource = new TicketResource($this->instructionsTicket);

        $this->ticket = $resource;

        return $this->ticket;
    }

    /**
     * @param $product
     * @return void
     */
    public function transformProduct($product)
    {
    }

    /**
     * @param $address
     * @return BillingAddressResource
     */
    public function transformBillingAddress($address)
    {
        $resource = new BillingAddressResource(
            $address->rua,
            $address->numero,
            $address->bairro,
            $address->cidade,
            $address->estado,
            $address->cep,
            $address->complemento
        );

        $this->billingAddress = $resource;

        return $this->billingAddress;
    }

    /**
     * @param $address
     * @return ShippingAddressResource
     */
    public function transformShippingAddress($address)
    {
        $resource = new ShippingAddressResource(
            $address->rua,
            $address->numero,
            $address->bairro,
            $address->cidade,
            $address->estado,
            $address->cep,
            $address->complemento
        );

        $this->shippingAddress = $resource;

        return $this->shippingAddress;
    }

    /**
     * @param $fullName
     * @param $birthDate
     * @param $cpf
     * @param $phone
     * @param $billingAddressResource
     * @return HolderResource
     */
    public function transformHolder($fullName, $birthDate, $cpf, $phone, $address)
    {
        $resource = new HolderResource(
            $fullName,
            $birthDate,
            new CpfDocumentResource($cpf),
            new PhoneResource($phone),
            $this->transformBillingAddress($address)
        );

        $this->holder = $resource;

        return $this->holder;
    }
}
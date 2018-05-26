<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 23/01/2018
 * Time: 15:06
 */

namespace App\Moip\Resources;

/**
 * Class CreditCardResource
 * @package App\Moip\Resources
 */
class TicketResource extends Resource
{
    public $expiration_date, $logo_uri, $instruction_lines;

    /**
     * CreditCardResource constructor.
     * @param array $instructions
     */
    public function __construct(array $instructions)
    {
        $this->expiration_date = \Carbon\Carbon::now()->addDays(env('MOIP_TICKET_EXPIRATION_DAYS', 3))->toDateString();

        $this->logo_uri = env('MOIP_TICKET_LOGO');

        $this->instruction_lines = $instructions;
    }

}

<?php
namespace App\Domain;

class MessageData
{
    /**
     * Status Message
     *
     * @var boolean|int
     */
    public $Status = true;
    /**
     * Body Message
     *
     * @var string
     */
    public $Message = '';
    /**
     * Payload
     *
     * @var object|null
     */
    public $Payload = null;
}
<?php
declare(strict_types=1);

namespace Microservice\Common\UI\Commands;


use Geekshubs\RabbitMQ\MessageI;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Message\AMQPMessage;

class MessageObject implements MessageI
{

    public function Message(AMQPMessage $message): void
    {
        log::info("Mensaje recibido ->".$message->body."-- routing key --".$message->get('routing_key'));
        $object = json_decode($message->body,true);
    }
}

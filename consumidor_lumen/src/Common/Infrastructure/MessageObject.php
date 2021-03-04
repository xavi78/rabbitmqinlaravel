<?php
declare(strict_types=1);

namespace Microservice\Common\Infrastructure;


use Geekshubs\RabbitMQ\MessageI;
use Geekshubs\RabbitMQ\RabbitMQ;
use Illuminate\Support\Facades\Log;
use Microservice\Labor\Infrastructure\EventSource\Events\Transaction\TransactionSearchAllEvent;
use PhpAmqpLib\Message\AMQPMessage;

class MessageObject implements MessageI
{

    public function Message(AMQPMessage $message): void
    {
        log::info("Mensaje recibido ->".$message->body."-- routing key --"
            .$message->get('routing_key')."-- correltation id --".$message->get("correlation_id"));
        $object = json_decode($message->body,true);

        /** TRANSACTION **/
        if($message->get('routing_key') === 'geekshubs.rpc') {

            $rabbitMq = new RabbitMQ(
                env('RABBITMQ_HOST','localhost'),
                env('RABBITMQ_PORT','5667'),
                env('RABBITMQ_USERNAME','rabbitmq'),
                env('RABBITMQ_PASSWORD','rabbitmq'),
                env('RABBITMQ_VHOST', '/')
            );
            $rabbitMq->createConnect("Geekshubs");
            $rabbitMq->responseRpc(['respuesta'=>'Hola Don Jose'], $message);


        }

    }
}

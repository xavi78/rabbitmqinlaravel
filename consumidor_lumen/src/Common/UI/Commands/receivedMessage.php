<?php
declare(strict_types=1);

namespace Microservice\Common\UI\Commands;


use Geekshubs\RabbitMQ\Connection;
use Geekshubs\RabbitMQ\Consumer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class receivedMessage extends Command
{

    protected $signature = "rabbitmq:received";
    protected $description = "Active worker from listen rabbitmq";

    public function handle()
    {
        log::info("Iniciando Worker de escucha");
        try{
            $message = new MessageObject();
            $connection = new Connection(
                env('RABBITMQ_HOST','localhost'),
                env('RABBITMQ_PORT','5667'),
                env('RABBITMQ_USERNAME','rabbitmq'),
                env('RABBITMQ_PASSWORD','rabbitmq'),
                env('RABBITMQ_VHOST', '/')
            );
            $connection->connect('Geekshubs');
            $consume = new Consumer($connection, $message);
            $consume(
                'Geekshubs',
                'geekshubs.command.message',
                'geekshubs.*');

        } catch (\Exception $ex) {
        log::error("Error en la escucha " . $ex->getMessage());
        }


    }



}

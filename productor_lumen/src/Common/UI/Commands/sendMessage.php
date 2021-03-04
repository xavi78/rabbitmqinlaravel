<?php


namespace Microservice\Common\UI\Commands;


use Geekshubs\RabbitMQ\RabbitMQ;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class sendMessage extends Command
{

    protected $signature = "rabbitmq:send";
    protected $descritpion = "Enviando un mensaje";


    public function handle()
    {
        log::info ("Enviando mensajes");
        $rabbitMQ = new RabbitMQ(
            env('RABBITMQ_HOST','localhost'),
            env('RABBITMQ_PORT','5667'),
            env('RABBITMQ_USERNAME','rabbitmq'),
            env('RABBITMQ_PASSWORD','rabbitmq'),
            env('RABBITMQ_VHOST', '/')
        );
        $rabbitMQ->createConnect("Geekshubs");
        $rabbitMQ->createExchange("geekshubs.command.message","topic",null,true,null,null,null,null);
        $rabbitMQ->publicMessage("Geekshubs","geekshubs.command.message",'geekshubs.prueba', json_encode("Hola Mundo"));
    }

}

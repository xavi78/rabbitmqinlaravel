<?php
declare(strict_types=1);

namespace Microservice\Common\UI\Commands;


use Geekshubs\RabbitMQ\RabbitMQ;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class sendMessageRpc extends Command
{

    protected $signature = "rabbitmq:sendRPC";
    protected $descritpion = "Iniciando colas de RabbitMQ";


    public function handle(){
        log::info ("Iniciando las colas ->". env('RABBITMQ_HOST','localhost'));
        $rabbitMQ = new RabbitMQ(
            env('RABBITMQ_HOST','localhost'),
            env('RABBITMQ_PORT','5667'),
            env('RABBITMQ_USERNAME','rabbitmq'),
            env('RABBITMQ_PASSWORD','rabbitmq'),
            env('RABBITMQ_VHOST', '/')
        );
        $rabbitMQ->createConnect("Geekshubs");
        $rabbitMQ->createExchange("geekshubs.command.message","topic",null,true,null,null,null,null);
        $id = Str::uuid()->toString();
        log::info("Message enviado con id ->". $id);
        $result = $rabbitMQ->requestRpc($id, "Geekshubs", "geekshubs_return", "geekshubs.command.message", "geekshubs.rpc", json_encode("Hola don pepito"));

        log::info("Contestación ->". $result);
    }
}

<?php
declare(strict_types=1);

namespace Microservice\Common\UI\Commands;


use Geekshubs\RabbitMQ\RabbitMQ;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class initRabbitmq extends Command
{

    protected $signature = "rabbitmq:init";
    protected $descritpion = "Iniciando colas de RabbitMQ";

    public function handle()
    {
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

    }
}

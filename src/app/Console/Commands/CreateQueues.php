<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class CreateQueues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(config('rabbitmq.host'), config('rabbitmq.port'), config('rabbitmq.user'), config('rabbitmq.password'));
        $channel = $connection->channel();

        //=====  Создание обменика catalog и его очередей  =====//
        $channel->exchange_declare('catalog', 'direct');
        $channel->queue_declare('request', auto_delete: false);
        $channel->queue_declare('response', auto_delete: false);
        $channel->queue_bind('request', 'catalog', 'request');
        $channel->queue_bind('response', 'catalog', 'response');

        return Command::SUCCESS;
    }
}

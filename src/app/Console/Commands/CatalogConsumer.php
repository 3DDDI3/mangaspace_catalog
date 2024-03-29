<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

class CatalogConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'catalog:consumer';

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


        echo " [*] Waiting for messages. To exit press CTRL+C\n";
        $channel->basic_consume('request', 'catalog', no_ack: true, callback: function (AMQPMessage $msg) use ($channel) {
            echo ' [x] Received ', $msg->body, "\n";
            $message = new AMQPMessage('hello back');
            $message->set(
                'application_headers',
                new AMQPTable(
                    array('key' => $msg->get('application_headers')->getNativeData()['key'])
                )
            );

            /**
             * @todo Реализовать считываение с базы данныхё
             */

            $channel->basic_publish($message, 'catalog', 'response');
        });

        try {
            $channel->consume();
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }

        return Command::SUCCESS;
    }
}

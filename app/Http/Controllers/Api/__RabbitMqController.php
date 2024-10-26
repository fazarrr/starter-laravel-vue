<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqController extends Controller
{
    protected $connection;
    protected $channel;

    public function __construct(Request $request)
    {
        $this->connection       = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel          = $this->connection->channel();
    }

    public function index($param)
    {
        switch ($param) {
            case 'sender':
                $this->sender();

                break;
            case 'receiver':
                $this->receiver();

                break;
            default:
                return 'Data tidak tersedia';
        }
    }

    private function sender()
    {
        $this->channel->queue_declare('hello', false, false, false, false);

        $msg = new AMQPMessage('Hello World!');
        $this->channel->basic_publish($msg, '', 'hello');

        echo " [x] Sent 'Hello World!'\n";

        $this->channel->close();
        $this->connection->close();
    }

    private function receiver()
    {
        $this->channel->queue_declare('hello', false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $this->channel->basic_consume('hello', '', false, true, false, false, $callback);

        try {
            $this->channel->consume();
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
    }
}

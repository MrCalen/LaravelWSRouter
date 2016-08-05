<?php

namespace App\Console\Commands;

use Calen\Router\Models\ServerWatcher;
use Calen\Router\Server;
use Illuminate\Console\Command;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;


class start extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'router:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start WS server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Starting WebSockets on port " . 8080);
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Server\Server(
                        new class extends ServerWatcher
                        {
                            function onOpen(ConnectionInterface $conn)
                            {
                                var_dump("connected");
                            }

                            function onClose(ConnectionInterface $conn)
                            {
                                var_dump("close");
                            }


                            function onError(ConnectionInterface $conn,
                                             \Exception $e)
                            {
                                var_dump("error: " . $e->getMessage());
                            }

                            function onMessage(ConnectionInterface $from, $msg)
                            {
                                var_dump("message: " . $msg);
                            }
                        }
                    )
                )
            ),
            8080,
            '0.0.0.0'
        );
        $server->run();

    }
}

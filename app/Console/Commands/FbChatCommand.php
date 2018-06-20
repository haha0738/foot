<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FbChatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fb:chat {content}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //EAACcH4AWLx8BAP1Vn0yVtCZAiThSROkfIZAZBbM9ntkZAKoaIKRZCYGvpXtZBDcmt4xlZCbP17tdQGVE3z5aZAuzXQIL0d4zSskIBo7OOzz2qZCHJ8m9Hrt0rXbZA5aZAivQIdgga49qugFsgj7vNBh0dJTgAqDW5lqkC5fJcQvdTVxawZDZD
        $client = new \GuzzleHttp\Client();
        $headers = ['content-type' => 'application/json'];
        $body = [
            'recipient' => [ 'id' => 1944130295645951 ],
            'message' => [ 'text' => $this->argument('content') ]
        ];

        $promise = $client->request('POST', 'https://graph.facebook.com/v2.6/me/messages?access_token=EAACcH4AWLx8BAP1Vn0yVtCZAiThSROkfIZAZBbM9ntkZAKoaIKRZCYGvpXtZBDcmt4xlZCbP17tdQGVE3z5aZAuzXQIL0d4zSskIBo7OOzz2qZCHJ8m9Hrt0rXbZA5aZAivQIdgga49qugFsgj7vNBh0dJTgAqDW5lqkC5fJcQvdTVxawZDZD', ['headers' => $headers, 'body' => json_encode($body)]);
        $this->info($promise->getBody());
    }
}

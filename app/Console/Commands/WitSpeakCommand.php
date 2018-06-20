<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WitSpeakCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wit:speak {content}';

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
        $client = new \GuzzleHttp\Client();
        $headers = ['Authorization' => 'Bearer DEW4SK7ZXV342RJPXQONQLOZDEY7KB4S'];
        $promise = $client->requestAsync('GET', 'https://api.wit.ai/message?v='.time().'&q='.$this->argument('content'), ['headers' => $headers]);
        $promise->then(function ($response){
            $this->info($response->getBody());
        });

    }
}

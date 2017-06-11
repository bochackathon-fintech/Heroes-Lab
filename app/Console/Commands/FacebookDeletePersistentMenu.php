<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mpociot\BotMan\Http\Curl;

class FacebookDeletePersistentMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'botman:facebookDeleteMenu';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove an existing persistent Facebook menu';
    /**
     * @var Curl
     */
    private $http;

    /**
     * Create a new command instance.
     *
     * @param Curl $http
     */
    public function __construct(Curl $http)
    {
        parent::__construct();
        $this->http = $http;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $payload = ["fields" => [
            "persistent_menu"
        ]];
        if (!$payload) {
            $this->error('You need to add a Facebook menu payload data to your BotMan config in services.php.');
            exit;
        }
        $response = $this->http->post('https://graph.facebook.com/v2.6/me/messenger_profile?access_token=' . config('services.botman.facebook_token'),
            [], $payload);
        $responseObject = json_decode($response->getContent());
        if ($response->getStatusCode() == 200) {
            $this->info('Facebook menu was deleted.');
        } else {
            $this->error('Something went wrong: ' . $responseObject->error->message);
        }
    }
}
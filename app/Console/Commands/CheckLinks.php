<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use GuzzleHttp\Client;

class CheckLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   protected $signature = 'check:links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if links return a 200 status code';

    /**
     * Execute the console command.
     */
     public function handle()
    {
        // List of URLs to check
        $urls = [
			 'http://studynexus.ng/institutions/BSU/programs/accounting',
            'http://studynexus.ng/institutions/BSU/programs',
            // Add more URLs as needed
        ];

        $client = new Client();
        
        foreach ($urls as $url) {
            try {
                $response = $client->get($url);
                $statusCode = $response->getStatusCode();

                if ($statusCode === 200) {
                    $this->info("URL: $url is OK ($statusCode)");
                } else {
                    $this->warn("URL: $url returned status code $statusCode");
                }
            } catch (\Exception $e) {
                $this->error("URL: $url is not reachable. Error: " . $e->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}




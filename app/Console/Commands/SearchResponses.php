<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Response;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;

class SearchResponses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:search-responses {query}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $query = $this->argument('query');

        $queryEmbedding = Prism::embeddings()
            ->using(Provider::OpenAI, 'text-embedding-3-small')
            ->fromInput($query)
            ->asEmbeddings();

        $embeddings = $queryEmbedding->embeddings[0]->embedding;

        $similarResponses = Response::findSimilar($embeddings);

        foreach ($similarResponses as $response) {
            dump("Question: " . $response->question);
            dump("Response: " . $response->response);
            dump("Distance: " . $response->distance);
            dump("--------------------------------");
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Response;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;

class GenerateResponseEmbeddings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-response-embeddings';

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
        $responses = Response::all();

        foreach ($responses as $response) {
            $embeddingResponse = Prism::embeddings()
                ->using(Provider::OpenAI, 'text-embedding-3-small')
                ->fromInput($response->response)
                ->asEmbeddings();

            $embeddings = $embeddingResponse->embeddings[0]->embedding;

            $response->embedding = $embeddings;
            $response->save();

            dump("Tokens: " . $embeddingResponse->usage->tokens . "\n");
        }
    }
}

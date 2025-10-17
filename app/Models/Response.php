<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Response extends Model
{
    protected $fillable = ['question', 'response'];

    public static function findSimilar(array $queryEmbedding, int $limit = 3, float $threshold = 0.8): Collection
    {
        $embeddingString = '[' . implode(',', $queryEmbedding) . ']';
        
        return static::selectRaw('*, (embedding <=> ?) as distance', [$embeddingString])
            ->whereRaw('(embedding <=> ?) < ?', [$embeddingString, $threshold])
            ->orderBy('distance')
            ->limit($limit)
            ->get();
    }

}

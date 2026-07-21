<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SentimentWordSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('positive_words')->insert(array_map(fn($w)=>[
            'word'=>$w,
            'created_at'=>now(),
            'updated_at'=>now()
        ], [

            'growth',
            'grow',
            'increase',
            'improve',
            'improved',
            'profit',
            'profits',
            'stable',
            'success',
            'successful',
            'recover',
            'recovery',
            'efficient',
            'efficiently',
            'expand',
            'expansion',
            'strong',
            'strength',
            'boost',
            'rise',
            'rising',
            'gain',
            'gains',
            'innovation',
            'investment',
            'opportunity',
            'development',
            'secure',
            'resilient',
            'record',
            'record-high',
            'positive',
            'benefit',
            'advantage',
            'support',
            'improvement',
            'optimize',
            'optimization',
            'modernization',
            'achievement'

        ]));

        DB::table('negative_words')->insert(array_map(fn($w)=>[
            'word'=>$w,
            'created_at'=>now(),
            'updated_at'=>now()
        ], [

            'war',
            'crisis',
            'delay',
            'delays',
            'inflation',
            'conflict',
            'strike',
            'sanction',
            'disaster',
            'earthquake',
            'flood',
            'storm',
            'hurricane',
            'congestion',
            'shortage',
            'recession',
            'decline',
            'drop',
            'loss',
            'losses',
            'collapse',
            'risk',
            'failure',
            'failed',
            'bankrupt',
            'bankruptcy',
            'damage',
            'damaged',
            'disruption',
            'disrupted',
            'slowdown',
            'accident',
            'blocked',
            'shutdown',
            'terror',
            'pandemic',
            'virus',
            'decrease',
            'fall',
            'negative'

        ]));
    }
}
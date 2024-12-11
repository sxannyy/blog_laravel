<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Illuminate\Support\Carbon;

class PublishPosts extends Command
{
    protected $signature = 'posts:publish';
    protected $description = 'Автоматическая публикация постов';

    public function handle()
{
    $now = now();

    $postsToPublish = Post::where('is_published', false)
        ->where(function ($query) use ($now) {
            $query->whereNull('scheduled_at')
                  ->orWhere('scheduled_at', '<=', $now);
        })
        ->get();

    foreach ($postsToPublish as $post) {
        $post->update([
            'is_published' => true,
            'publish_at' => $now,
        ]);
        $this->info("Пост с ID: {$post->id} опубликован");
    }

    $this->info('Автоматическая публикация завершена');
}

}

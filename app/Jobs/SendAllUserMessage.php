<?php

namespace App\Jobs;

use App\Message;
use App\Notifications\TemplateMessage;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendAllUserMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $message;

    public $templateConfig;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Message $message, array $config)
    {
        $this->message = $message;

        $this->templateConfig = $config;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $config = [
            'template_id' => $this->templateConfig['template_id'],
            // todo url
            'url' => '',
            'data' => [
                'first' => $this->message->title,
                'keyword1' => '浙江工业大学',
                'keyword2' => $this->message->infomer,
                'keyword3' => $this->message->created_at->format('Y-m-d H:i:s'),
                'keyword4' => trim_words($this->message->content, 50),
                'remark' => '点击查看详情'
            ]
        ];
        $users = User::all();
        foreach ($users as $user) {
            if ($user->allow_send) {
                $user->notify(new TemplateMessage($config));
            }
        }

    }
}
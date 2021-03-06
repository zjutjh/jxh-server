<?php

namespace App\Notifications;

use App\Channels\TemplateMessageChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TemplateMessage extends Notification implements ShouldQueue
{
    use Queueable;



    /**
     * [
     *     'template_id' => 'template-id',
     *     'url' => 'https://easywechat.org',
     *     'data' => [
     *         'key1' => 'VALUE',
     *         'key2' => 'VALUE2',
     *          ...
     *         ],
     * ]
     * @var array
     */
    public $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TemplateMessageChannel::class];
    }


    /**
     * @param $notifiable
     * @return array
     */
    public function toTemplate($notifiable)
    {
        return [
            'touser' => $notifiable->openid,
            'template_id' => $this->data['template_id'],
            'url' => $this->data['url'] . '?t=' . time(),
            'data' => $this->data['data']
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

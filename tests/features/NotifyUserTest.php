<?php

use App\Notifications\PostCommented;
use App\User;
use Illuminate\Support\Facades\Notification;

class NotifyUserTest extends FeatureTestCase
{
    function test_the_subscribers_receive_a_notification_when_post_is_commented()
    {
        Notification::fake();

        $post = $this->createPost();

        $suscriber = factory(User::class)->create();

        $suscriber->subscribeTo($post);

        $writter = factory(User::class)->create();

        $writter->subscribeTo($post);

        $comment = $writter->comment($post, 'Un comentario cualquiera');

        // dd($comment);

        Notification::assertSentTo($suscriber, PostCommented::class, function ($notification) use ($comment) {
          return $notification->comment->id == $comment->id;
        });

        // The author of the comment shouldn't be notified even if he is a subscriber.
        Notification::assertNotSentTo($writter, PostCommented::class);

    }
}

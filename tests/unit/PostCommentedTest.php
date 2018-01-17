<?php

use App\Notifications\PostCommented;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Notifications\Messages\MailMessage;

class PostCommentedTest extends TestCase
{
    use DatabaseTransactions;

    function test_it_builds_a_mail_message()
    {

        $post = factory(\App\Post::class)->create([
            'title' =>  'Titulo del post'
        ]);

        $author = factory(\App\User::class)->create([
            'name' => 'Marco Barreto'
        ]);

        $comment = factory(\App\Comment::class)->create([
            'post_id' => $post->id,
            'user_id' => $author->id,
        ]);

        $notification = new PostCommented($comment);

        $subscriber = factory(\App\User::class)->create();

        $message = $notification->toMail($subscriber);

        $this->assertInstanceOf(MailMessage::class, $message);

        // dd($message);

        $this->assertSame(
            'Nuevo comentario en: Titulo del post',
            $message->subject
            );

        $this->assertSame(
            'Marco Barreto escribió un comentario en: Titulo del post',
            $message->introLines[0]
        );

        $this->assertSame($comment->post->url, $message->actionUrl);
    }
}

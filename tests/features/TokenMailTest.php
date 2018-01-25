<?php

use App\Mail\TokenMail;
use App\Token;
use App\User;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\DomCrawler\Crawler;

class TokenMailTest extends FeatureTestCase
{
    /**
     * @test
     */
    function it_sends_a_link_with_the_token()
    {
        $user = new User([
           'first_name' => 'Marco',
           'last_name' => 'Barreto',
           'email' => 'admysis@hotmail.com'
        ]);

        $token = new Token([
           'token' => 'this-is-a-token',
            'user' => $user
        ]);

        // SMTP -> Mailtrap
        // API Mailtrap -> data (email)

        $this->open(new TokenMail($token))
            ->seeLink($token->url, $token->url);
    }

    protected function open(Mailable $mailable)
    {
        $transport = Mail::getSwiftMailer()->getTransport();

        $transport->flush();

        Mail::send($mailable);

        $message = $transport->messages()->first();

        $this->crawler = new Crawler($message->getBody());

        return $this;
    }
}

<?php

use App\Mail\TokenMail;
use App\Token;
use Illuminate\Support\Facades\Mail;

class AuthenticationTest extends FeatureTestCase
{
    function test_a_guest_user_can_request_a_token()
    {
        // Having

        Mail::fake();

        $user = $this->defaultUser(['email' => 'admin@styde.net']);

        // When

        $this->visitRoute('login')
            ->type('admin@styde.net','email')
            ->press('Solicitar token');

        // Then a new token is created in the database
        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token, 'A token was not created');

        // And sent to the user
        Mail::assertSentTo($user, TokenMail::class, function ($mail) use ($token) {
            return $mail->token->id === $token->id;
        });

        $this->dontSeeIsAuthenticated();

        $this->seeRouteIs('login_confirmation')
            ->see('Enviamos a tu email un enlace para que inicies sesión');
    }

    function test_a_guest_user_can_request_a_token_without_an_email()
    {
        // When
        $this->visitRoute('login')
            ->type('Silence', 'email')
            ->press('Solicitar token');

        $this->seeErrors([
            'email' => 'Correo electrónico no es un correo válido'
        ]);
    }


    function test_a_guest_user_can_request_a_token_with_a_non_existent_email()
    {
        // Having
        $this->defaultUser(['email' => 'admin@styde.net']);

        // When
        $this->visitRoute('login')
            ->type('silence@styde.net', 'email')
            ->press('Solicitar token');

        $this->seeErrors([
            'email' => 'Correo electrónico no existe'
        ]);
    }


}

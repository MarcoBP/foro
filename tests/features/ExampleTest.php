<?php

class ExampleTest extends FeatureTestCase
{

    function test_basic_example()
    {
        $user = factory(App\User::class)->create([
            'name' => 'Marco Barreto',
            'email' => 'admysis@hotmail.com',
        ]);

        $this->actingAs($user, 'api');

        $this->visit('api/user')
             ->see('Marco Barreto')
             ->see('admysis@hotmail.com');
    }
}

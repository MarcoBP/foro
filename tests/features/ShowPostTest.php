<?php

class ShowPostTest extends FeatureTestCase
{
    function test_a_user_can_see_the_post_details()
    {
        // Having
        $user = $this->defaultUser([
            'first_name' => 'Marco',
            'last_name' => 'Barreto',
        ]);

        $post = $this->createPost([
            'title' => 'Este es el título del post',
            'content' => 'Este es el contenido del post',
            'user_id' => $user->id,
        ]);

        // Imprime en un array una lista de los usuarios del sistema, y el user_id del Post
        // dd(\App\User::all()->toArray(), $post->user_id);

        //When

        // Cambiamos esta ruta larga por la nueva manejada por el atributo: url
        // $this->visit(route('posts.show', [$post->id, $post->slug]))

        // Estas instrucciones temporales se deben deshabilitar al ejecutar nuevamene la prueba completa
        // dd($post->url);

        $this->visit($post->url)
            ->seeInElement('h1', $post->title)
            ->see($post->content)
            ->see('Marco Barreto');
    }

    function test_old_urls_are_redirected(){

        // Having
        $post = $this->createPost([
            'title' => 'Old title',
        ]);

        $url = $post->url;

        $post->update(['title' => 'New title']);

        $this->visit($url)
            ->seePageIs($post->url);

    }

    // Se deshabilita esta prueba para generar una nueva prueba con otra funcionalidad
    /*
    function test_post_url_with_wrong_slugs_still_work()
    {
        // Having
        $user = $this->defaultUser();

        $post = factory(\App\Post::class)->make([
            'title' => 'Old title',
        ]);

        $user->posts()->save($post);

        $url = $post->url;

        $post->update(['title' => 'New title']);

        // dd($url);

        $this->visit($url)
            ->assertResponseOk()
            ->see('New title');
    }
    */


}

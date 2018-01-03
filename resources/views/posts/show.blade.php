@extends('layouts.app')

@section('content')
    <h1>{{ $post->title }}</h1>

    <p>{{ $post->content }}</p>

    <p>{{ $post->user->name }}</p>

    <h4>Comentarios</h4>

    {!! Form::open(['route' => ['comments.store', $post], 'method' => 'POST']) !!}

        {!! Field::textarea('comment') !!}

        <button type="submit">
            Publicar Comentario
        </button>

    {!! Form::close() !!}

    @foreach($post->latestComments as $comment)
        <article class="{{ $comment->answer ? 'answer' : '' }}">
            {{ $comment->comment }}
            {{ $comment->post->user }}

            @if(Gate::allows('accept', $comment) && !$comment->answer)
            {!! Form::open(['route' => ['comments.accept', $comment], 'method' => 'POST']) !!}
                <button type="submit">Aceptar Respuesta</button>
            {!! Form::close() !!}
            @endif

        </article>
    @endforeach

@endsection
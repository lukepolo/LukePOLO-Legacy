@extends('emails.template')
@section('title')
    New Comment on <a href="{{ route('blog/view', $comment->blog->link_name) }}">{{ $comment->blog->name }}</a>
@endsection
@section('content')
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td class="content-block">
                {{ $comment->user->first_name }} {{ $comment->user->last_name }} ({{ $comment->user->email }}) said
            </td>
        </tr>
        <tr>
            <td class="content-block">
                "{{ $comment->comment }}"
            </td>
        </tr>
        @if($comment->parentComment)
            <tr>
                <td class="content-block">
                    in response to {{ $comment->parentComment->user->first_name }} {{ $comment->parentComment->user->last_name }} ({{ $comment->parentComment->user->email }})'s comment :
                <td>
            </tr>

            <tr>
                <td class="content-block">
                    "{{ $comment->parentComment->comment }}"
                <td>
            </tr>
        @endif
        <tr>
            <td class="content-block">
                Please moderate at <a href="{{ action('AdminController@getIndex') }}">Admin Dashboard</a>
            </td>
        </tr>
    </table>
@endsection

@extends('layouts.master')

@section('title')
{{$band->band_name}}
@endsection

@include('includes.navbar')

@section('content')
        <div id='viewArticles'>
        Articles:<br>
        
        @if ($articles == null)
        @else
            @foreach($articles as $article)
            <a href="{{'article/'.$article->art_id}}">{{$article->art_title}}</a><br>
            <button type='button' class='edit' value='{{'article/editArticle/'.$article->article_id}}'>Edit</button>
            <button type='button' class='delete' value='{{$article->article_id}}'>Delete</button>
            <br><br>
            @endforeach
        @endif
        </div>
        
        <hr>
        <form method="post" action="{{'../'.$band->band_name.'/addArticle'}}" enctype="multipart/form-data">
            {{ csrf_field()}}
            Title of Article:<br>
            <input type='text' name='art_title'><br><br>
            Content:<br>
            <textarea name='content'></textarea><br><br>
            <input type='submit'>
        </form>
</body>
<script type="text/javascript">
$(document).ready(function()
{
     $("#viewArticles").on('click', '.edit' ,function(){
        
        var val = $(this).val();
        if(confirm('Do you want to edit this article?'))
        {
            window.location = val;
        }
     });
     $("#viewArticles").on('click', '.delete' ,function(){
        
        var val = $(this).val();
        if(confirm('Do you want to delete this article?'))
        {
            window.location = 'article/deleteArticle/'+val;
        }
     });
 });
</script>
@endsection

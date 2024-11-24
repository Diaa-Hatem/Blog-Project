@extends('themes.master')

@section('title', 'My Blogs')


@section('contant')

    @include('themes.subthemes.hero', ['title' => 'My Blogs'])

   
    <!--================ Start Blog Post Area =================-->
    @if (session('blog-delete-status'))
    <div class="alert alert-success">
        {{ session('blog-delete-status') }}
    </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th scope="col" width="5%">#</th>
                <th scope="col">title</th>
                <th scope="col" width="15%">active</th>
            </tr>
        </thead>
        <tbody>
            @if (count($blogs)>0)
                @foreach ($blogs as $key=>$blog)
                <tr>
                    <th scope="row">{{++$key}}</th>
                    <td><a href="{{ route('blogs.show', ['blog' => $blog] )}}">{{$blog->title}}</a></td>

                    <td>
                        <a href="{{ route('blogs.edit',['blog' =>$blog]) }}" class="btn btn-sm btn-primary mr-3">Edite</a>
                        <form action="{{route('blogs.destroy' , ['blog' =>$blog])}}" method="POST" class="d-inline" id="delete_form">
                            @csrf
                            @method('delete')
                        </form>
                        <a href="javascript:$('form#delete_form').submit();" class="btn btn-sm btn-danger mr-3">Delete</a>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    </div>
    <!--================ End Blog Post Area =================-->
@endsection
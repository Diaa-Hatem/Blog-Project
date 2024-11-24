@extends('themes.master')

@section('title', 'Edite Blog')


@section('contant')
    @include('themes.subthemes.hero', ['title' => $blog->title])

    <!-- ================ contact section start ================= -->
    <section class="section-margin--small section-margin">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    @if (session('blog-edite-status'))
                        <div class="alert alert-success">
                            {{ session('blog-edite-status') }}
                        </div>
                    @endif
                    <form action="{{ route('blogs.update', ['blog' => $blog]) }}" class="form-contact contact_form"
                        action="contact_process.php" method="post" novalidate="novalidate" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <input class="form-control border" name="title" type="text" placeholder="Enter your title"
                                value="{{ $blog->title }}">
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />

                        </div>



                        <div class="form-group">
                            <input class="form-control border" name="image" type="file">
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />

                        </div>

                        <div class="form-group">
                            <select name="category_id" id="" class="form-control border">
                                <option value="">select your category</option>
                                @if (count($categories) > 0)
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @if ($category->id == $blog->category_id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>


                        <div class="form-group">

                            <textarea class="w-100 border" name="description" type="text" placeholder="Enter your description" rows="5">{{ $blog->description }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />

                        </div>

                        <div class="form-group text-center text-md-right mt-3">
                            <button type="submit" class="button button--active button-contactForm">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ contact section end ================= -->
@endsection

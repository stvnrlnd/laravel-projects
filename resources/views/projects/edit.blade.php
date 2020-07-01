@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1>Edit your project</h1>

    <form method="POST" action="{{ route('projects.update') }}">

        @csrf
        @method('PATCH')

        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title">
        </div>

        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>
        </div>

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>
@endsection

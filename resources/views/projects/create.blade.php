@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="mt-4 card">
            <div class="card-heading">
                <h1>Create a project</h1>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('projects.store') }}">

                    @csrf
                    @method('POST')

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
        </div>
    </div>
@endsection

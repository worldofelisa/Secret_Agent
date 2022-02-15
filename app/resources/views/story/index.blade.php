@extends("layout")

@section("content")
    <form method="post" action="/start">
        {{-- See the following for more info on CRSF protection--}}
        {{-- https://laravel.com/docs/8.x/csrf#preventing-csrf-requests--}}
        @csrf
        <div class="form-group">
            <label for="UserName">Username</label>
            <input type="text" class="form-control" id="UserName" placeholder="Enter username" name="username">
        </div>
        <div class="form-group">
            <label for="InputEmail">Email address</label>
            <input type="email" class="form-control" id="InputEmail" placeholder="Enter email" name="email">
        </div>
        <button type="button" class="btn btn-primary" id="submit">Submit</button>
    </form>
@endsection

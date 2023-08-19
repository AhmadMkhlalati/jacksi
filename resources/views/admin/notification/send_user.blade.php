@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Send Notification</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                    <div class="col-md-8 mx-auto ">
                        <div class="flex justify-between">
                        <p><strong>Name : </strong>{{$user->name}}</p>
                        <p><strong>email : </strong>{{$user->email}}</p>
                        <p><strong>mobile type : </strong>{{$user->mobile_type}}</p>
                        </div>
                    <form action="{{route('send.user.notification',$user->id)}}" method="post">
                        @csrf
                        <div class="form-group my-2">
                            <label class="form-label">Title</label>
                            <input required class="form-control" name="title">
                        </div>
                        <div class="form-group my-2">
                            <label class="form-label">Body</label>
                            <textarea required class="form-control" name="body"></textarea>
                        </div>
                        <div class="form-group my-2">
                            <button type="submit" class="btn btn-primary btn-block"> send notification</button>
                        </div>
                    </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

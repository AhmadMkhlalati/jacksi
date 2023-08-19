@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header flex justify-content-between">
                        <p>Users Table</p>
                        <a class="btn btn-success" href="{{route('send.users.notification')}}">send notification to all</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <livewire:users-table-view />

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

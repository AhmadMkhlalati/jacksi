@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header flex justify-content-between">
                        <p>Notes Table</p>
                        <a class="btn btn-success" href="{{route('admin.notes.create')}}">Add Note</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <livewire:notes-table-view />

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

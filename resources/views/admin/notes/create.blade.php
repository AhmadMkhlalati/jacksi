@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create Note</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    <div class="col-md-8 mx-auto">

                    <form action="{{route('admin.notes.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group my-2">
                            <label class="form-label">content</label>
                            <input required class="form-control" name="content">
                        </div>
                        <div class="form-group my-2">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image"/>
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

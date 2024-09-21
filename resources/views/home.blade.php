@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in(Bootstrap 4 is available out of the box. To enable BS icons add link to layout/app.blade.php)
					
					<div class="alert alert-success">
					    <p>
                            <i class="fas fa-user-circle"></i> Hello, <strong>{{Auth::user()->name}}</strong> 
						</p>
						
						 <p><i class="fas fa-lock-open"></i> Created <strong>{{Auth::user()->created_at}}</strong> </p>
						
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

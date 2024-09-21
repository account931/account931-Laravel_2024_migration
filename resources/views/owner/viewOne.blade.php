@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">EquipmentController</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

					<div class="alert alert-sucess">
					    <p>
                            <i class="fas fa-user-circle"></i> Hello, <strong>{{Auth::user()->name}}</strong> 
						</p>
						
						<p>One equipment records here.....</p>
						 
			            <p><i class='fas fa-cat'   style='font-size:16px'></i> Name:    {{ $owner->first_name  }}  {{ $owner->last_name  }}</p>
						<p><i class='fas fa-horse' style='font-size:16px'></i> Location: {{ $owner->location}}  </p>
						<p><i class='fas fa-tree' style='font-size:16px'></i>  Confirmed: {!! ($owner->confirmed) ? '<i class="far fa-check-circle" style="color:green"></i>' : '<i class="far fa-bell-slash" style="color:red"></i>' !!}  </p>	 
						<a href="{{route('/owners')}}"> <i class='fas fa-sign-in-alt'></i> Go back</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

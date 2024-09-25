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
						 
			            <p><i class='fas fa-cat'   style='font-size:16px'></i> Name:    {!! $owner->first_name  !!}  {{ $owner->last_name  }}</p>
						<p><i class='fas fa-horse' style='font-size:16px'></i> Location: {{ $owner->location}}  </p>
						<p><i class='fas fa-tree' style='font-size:16px'></i>  Confirmed: {!! ($owner->confirmed) ? '<i class="far fa-check-circle" style="color:green"></i>' : '<i class="far fa-bell-slash" style="color:red"></i>' !!}  </p>	 
						
						{{-- Venues hasMany  --}}
                            <p> <i class='fas fa-charging-station' style='font-size:16px'></i> Venues (hasMany): 
                            @if( $owner->venues->isEmpty())
                                <span class="text-danger"> No venue so far. </span>
                            @else
                                @foreach ($owner->venues as $venue)
								    <div class="one" style="border: 1px solid black; padding: 1em; margin-bottom:1em; border-radius: 1em;">
                                    <p>Venue {{ $loop->iteration }}: {{ $venue->venue_name }}</p>
									
									
									{{-- Equipment Many to Many  --}}
									@if( $venue->equipments->isEmpty())
									    <span class="text-danger"> No equipment so far. </span>	
									@else
										<p>Equipment (many to many)</p>
										<ul>
										@foreach ($venue->equipments as $equipment)
									        <li> {{ $equipment->trademark_name }} {{ $equipment->model_name }}</li>
										@endforeach
										</ul>
									@endif
									{{-- End Equipment Many to Many  --}}
									
									</div> <!-- end class one-->
                                @endforeach
                            @endif
                            </p>
                            {{-- End Venues hasMany  --}}
						
						<a href="{{route('/owners')}}"> <i class='fas fa-sign-in-alt'></i> Go back</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

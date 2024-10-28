@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">OwnerController</div>

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
						
						<div class="row">
						    <div class="col-lg-9 col-md-9 col-sm-9">
						        <p>All Owner records here.....</p>
							</div>
							
							 <div class="col-lg-3 col-md-3 col-sm-3">
						        <!-- Button to create new record -->
						        <p><a href="{{ route('owner/create-new') }}"><button class="btn btn-large btn-info">Create new</button></a></p>
							</div>
							
							
							<!-- Flash message success -->
					        @if(session()->has('flashSuccess'))
                                <div class=" row alert alert-success">
					                <i class='fas fa-charging-station' style='font-size:21px'></i> &nbsp;
                                   {{ session()->get('flashSuccess') }}
                                </div>
                            @endif
					
					        <!-- Flash message failure -->
					        @if(session()->has('flashFailure'))
                                <div class="row alert alert-danger">
                                    {{ session()->get('flashFailure') }}
                                </div>
                            @endif   
						
						</div>
						 
						@if ($owners->count())
                          
                            @foreach ($owners as $owner)
							<div class="alert alert-info" style="border: 1px solid black;">
			                <p> Owner {{ $owner->id }} {{-- $loop->iteration --}}  </p>  <!-- {{ $loop->iteration }} is Blade equivalentof $i++ -->
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
                            

							<!-- Link to view one. Two below links shows tha same page-->
							<p class='small'>
							    <a href="{{route('ownerOneId', ['id' => $owner->id])}}"> <i class='far fa-eye' style='font-size:16px'></i> View it (by id)...</a>  <!-- Traditional route by id -->
								</br>
								<a href="{{route('ownerOne',   ['owner' => $owner])}}"> <i class='far fa-eye' style='font-size:16px'></i> View it (by model binding)...</a>  <!-- Implicit Route Model Binding -->
							</p> 

							<hr>
							
							
							<!-- Link to edit -->
							<p class='small'>
								<a href="{{route('ownerEdit',   ['owner' => $owner])}}"> <i class='far fa-eye' style='font-size:16px'></i> Edit it (by model binding)...</a>  <!-- Implicit Route Model Binding -->
							</p> 
							
							
							<hr>
							<!-- Link to delete, partial form with delete action -->
						    @include('owner.partial.delete', ['id_passed' => $owner->id])

							<hr>
							</div>
							
                            @endforeach
							{{ $owners->links() }}
		                @else
		                Not found any record
                        @endif		 
						
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

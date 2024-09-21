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
						
						<p>All Owner records here.....</p>
						 
						@if ($owners->count())
                          
                            @foreach ($owners as $owner)
							<div class="alert alert-info">
			                <p> Owner {{ $loop->iteration }}  </p>  <!-- {{ $loop->iteration }} is Blade equivalentof $i++ -->
                            <p><i class='fas fa-cat'   style='font-size:16px'></i> Name:    {{ $owner->first_name  }}  {{ $owner->last_name  }}</p>
							<p><i class='fas fa-horse' style='font-size:16px'></i> Location: {{ $owner->location}}  </p>
							<p><i class='fas fa-tree' style='font-size:16px'></i>  Confirmed: {!! ($owner->confirmed) ? '<i class="far fa-check-circle" style="color:green"></i>' : '<i class="far fa-bell-slash" style="color:red"></i>' !!}  </p>
							
							<!-- Link to view one. Two below links shows tha same page-->
							<p class='small'>
							    <a href="{{route('ownerOneId', ['id' => $owner->id])}}"> <i class='far fa-eye' style='font-size:16px'></i> View it (by id)...</a>  <!-- Traditional route by id -->
								</br>
								<a href="{{route('ownerOne',   ['owner' => $owner])}}"> <i class='far fa-eye' style='font-size:16px'></i> View it (by model binding)...</a>  <!-- Implicit Route Model Binding -->
							</p> 

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

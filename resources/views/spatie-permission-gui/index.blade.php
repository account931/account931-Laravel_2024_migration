@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Laravel Permission custom GUI</div>

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
						        <p>My manual Spatie Laravel permission 5.3 GUI.....</p>
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
						 
						@if ($allRoles->count())
                          
                            @foreach ($allRoles as $role)
							    <div class="alert alert-info" style="border: 1px solid black;">
			                    <p> Role {{ $role->id }} {{-- $loop->iteration --}}  </p>  <!-- {{ $loop->iteration }} is Blade equivalentof $i++ -->
                                <p><i class='fas fa-cat'   style='font-size:16px'></i> Role name:  <span style='font-size:19px; color:red;'>{{ $role->name  }}</span></p>
								
								{{-- Permissions that belong to role --}}
								<p class="alert alert-info" style="border: 1px solid black;">Permissions</p>
								@foreach ($role->permissions as $permission)
								    <p><i class='fas fa-mountain' style='font-size:16px'></i> Permission {{$loop->iteration}}:  <span style='color:green;'>{{ $permission->name  }} </span></p>
								@endforeach
								{{-- End Permissions --}}
								
								
								{{-- Users who have this role --}}
								<p class="alert alert-info" style="border: 1px solid black;">Users having role {{ $role->name }}</p>
								@foreach ($role->users as $user)
								    <p><i class='fas fa-hiking' style='font-size:16px'></i> User {{$loop->iteration}}:  <span style='color:green;'> {{ $user->name }}, {{ $user->email }} </span></p>
								@endforeach
								{{-- End Users who have this role --}}
								 
								</div>
						   @endforeach
            
		                @else
		                    Not found any roles
                        @endif		 
						
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

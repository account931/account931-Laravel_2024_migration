{{-- @extends('permission-editor::layouts.app') --}}
@extends('layouts.app')

@section('content')

<div class="container mt-3">
        <h2>Permissions(my modified package + changed from TailWind Css to Bootstrap 4)</h2>
        <p>Navigation tabs:</p>
		
         @include('laraveldaily.laravelPermissionEditor.partial.navlinks', [])  <!-- render partial navlinks-->
	</br>
	</hr>
	
	
	<!--  Create new-->
	<div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10">
	    </div>
		<div class="col-lg-2 col-md-2 col-sm-2">
		    <a href="{{ route('permissions.create') }}">
			    <button type="button" class="btn btn-success">Create</button>
			</a>
	    </div>
	</div>
    </br>
	</hr>
	
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
	
	
	<div class="row border">
	    <div class="col-lg-4 col-md-4 col-sm-4 border p-2">
		     Permission Name
	    </div>
		<div class="col-lg-4 col-md-4 col-sm-4 border p-2">
		    Roles (that have this permission)
	    </div>
		<div class="col-lg-4 col-md-4 col-sm-4 border p-2">
		    Action
	    </div>
		
	    @foreach ($permissions as $permission)
        <div class="col-lg-4 col-md-4 col-sm-4 border p-2">
		      {{ $permission->name }}
	    </div>
		
		<div class="col-lg-4 col-md-4 col-sm-4 border p-2">
		    {{ $permission->roles->implode('name', ', ') }} 
	    </div>
		
		<div class="col-lg-4 col-md-4 col-sm-4 border p-2">
		    <a href="{{ route('permissions.edit', $permission) }}"> <button type="button" class="btn btn-info">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button> </a> 
			<p></p>
			<form action="{{ route('permissions.destroy', $permission) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure?')"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                <button type="submit" class="btn btn-success"> Delete </button>
            </form>
	    </div>
	@endforeach
	</div>

</div> <!-- end class="container mt-3" -->
@endsection
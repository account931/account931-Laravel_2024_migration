{{--  @extends('permission-editor::layouts.app')  --}}
@extends('layouts.app')

@section('content')

<div class="container mt-3">
    <h2>Edit Role (my modified package + changed from TailWind Css to Bootstrap 4)</h2>
	<a class="nav-link" href="{{ route('roles.index') }}"><i class='fas fa-cat' style='font-size:16px'></i> {{ __('Go back') }}</a>
	</hr>
	
    <!-- Errors -->
	 @if ($errors->any())
        <div class="row mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
	
	<!-- Form -->
	<form action="{{ route('roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ $role->name ?? old('name') }}" class="form-control" required="required" autofocus="autofocus">
        </div>

        @if ($permissions->count())
            <div>
                <label for="name">Permissions </label> </br>
				    @foreach ($permissions as $id => $name)
                        <input type="checkbox" name="permissions[]" id="permission-{{ $id }}" value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || $role->permissions->contains($id) ? 'checked' : '')}} >  
									                                                                                        {{-- was (not supported in L6) =>  @checked(in_array($id, old('permissions', [])) || $role->permissions->contains($id)) --}}
									
									
                         <label  for="permission-{{ $id }}">{{ $name }}</label>
                         <br />
                    @endforeach
            </div>
        @endif

            <div>
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </div>
    </form>
	<!-- End form -->


</div> <!-- end class="container mt-3" -->

@endsection
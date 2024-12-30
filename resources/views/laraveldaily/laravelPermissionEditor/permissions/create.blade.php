{{--  @extends('permission-editor::layouts.app')  --}}
@extends('layouts.app')

@section('content')

<div class="container mt-3">
    <h3>Create Permission (my modified package + changed from TailWind Css to Bootstrap 4)</h3>
	<a class="nav-link" href="{{ route('permissions.index') }}"><i class='fas fa-cat' style='font-size:16px'></i> {{ __('Go back') }}</a>
	</br>
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
	

    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label  for="name"> Name </label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required="required" autofocus="autofocus">
        </div>

        @if ($roles->count())
            <div class="mt-4">
                <label for="name"> Roles </label> </br>

                @foreach ($roles as $id => $name)
                    <input type="checkbox" name="roles[]" id="role-{{ $id }}" value="{{ $id }}">
                    <label for="role-{{ $id }}">{{ $name }}</label>
                    <br />
                @endforeach
            </div>
        @endif

        <div class="mt-4">
            <button type="submit" class="btn btn-success">
                Save
            </button>
        </div>
     </form>

</div> <!-- end class="container mt-3" -->

@endsection
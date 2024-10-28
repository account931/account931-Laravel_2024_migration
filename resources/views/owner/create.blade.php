@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-xs-12 col-md-8 col-md-offset-2 panel panel-default"> <!-- col-md-offset-2 -->
            <div class="panel-heading"> Create new Owner </div>
			    <p><br><a href="{{ route('/owners') }}"><button class="btn btn-large btn-success">Back to owners</button></a></p>
				
				
				<!------------------------------- FORM ----------------------------------->
					
			    <div class="col-sm-12 col-xs-12">
					    
				    <!-- Display errors var 1 -->
				    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div><br />
                    @endif

						
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
						
					<!-------------------------------  FORM ----------------------------------->	
                    <div class="row">
					    
                        <form method="post" action="{{url('owner/save')}}"  enctype="multipart/form-data">
							{{-- Form::open(array('url' => 'owner/save')) --}}

							<input type="hidden" value="{{csrf_token()}}" name="_token" />
							
                            <!-- First name -->							
                            <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first_name"> First name:</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{old('first_name','')}}"/>	
							    @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif	
                            </div>
							
							<!-- Last name -->	
							<div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="last_name">Last name:</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{old('last_name','')}}"/>	
							    @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif	
                            </div>

							<!-- Email -->	
							<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email','')}}"/>	
							    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif	
                            </div>	
							
                            <!-- Phone -->								
							<div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="phone">Phone:</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone','')}}"/>	
							    @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif	
                            </div>

							<!-- Location -->	
                            <div class="form-group {{ $errors->has('location') ? ' has-error' : '' }}">
                                <label for="location">Location:</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror") name="location" value="{{old('location','')}}"/>	
							    @if ($errors->has('location'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                @endif	
                            </div>	

							<!-- Venues  dropdown, not used, reassigned to checkbox -->	
                            <div class="form-group {{ $errors->has('owner_venuePrev') ? ' has-error' : '' }}">
                                <select name="owner_venuePREV" class="form-control @error('owner_venuePrev') is-invalid @enderror")>
						            <option  disabled="disabled"  selected="selected">Choose venue (not used, reassigned to checkbox)</option>
		                            @foreach ($venues as $venue)
									    <!-- Saves the old value of select if submit failed due to Validation -->
					                    <option value={{ $venue->id }} {{ old('owner_venue')!=null && old('owner_venue') == $venue->id  ?  ' selected="selected"' : '' }} > {{ $venue->venue_name }}, {{ $venue->address }} </option>
									@endforeach
						        </select>
									
								@if ($errors->has('owner_venue'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('owner_venue') }}</strong>
                                    </span>
                                @endif
                            </div>							
					        <!-- End Venues dropdown reassigned to checkbox -->
							
							
							<!-- Venues  checkbox (hasMany) -->	
							<div class="form-group {{ $errors->has('owner_venue') ? ' has-error' : '' }}">
							    </br>
							    <p><b>Venues (hasMany)</b></p>
							    <div class='row'>
							        @foreach ($venues as $venue)
							        <div class="col-sm-6 col-xs-6 form-control @error('owner_venue') is-invalid @enderror")>
							             <input class="form-check-input" type="checkbox"  name="owner_venue[]" value={{$venue->id}} @if(is_array(old('owner_venue')) && in_array($venue->id, old('owner_venue'))) checked @endif />      {{-- in_array($venue->id, $owner->venues->pluck('id')->toArray())  ?  " checked" : "" --}}
                                         <label for="venues"> id:{{ $venue->id }}, {{ $venue->venue_name }} </label><br>
								    </div>
							        @endforeach
							    </div>
							</div>
							<!-- End Venues  checkbox (hasMany) -->
							
								 
                            <button type="submit" class="btn btn-primary">Create</button>
								{{-- Form::close() --}}
                        </form>
					    </br>
                    </div>
					
					<!------------------------------- END FORM ----------------------------------->
					
            </div>
        </div>
	</div>
</div>

@endsection
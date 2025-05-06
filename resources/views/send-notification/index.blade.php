@extends('layouts.app')

<!-- Additional CSS for this page -->
@section('styles')
    <!-- Bootstrap Select JS -->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>-->
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Send notification <b>  </b> </div>

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
						        <!--<p>Owner records via Vue go here.....</p>-->
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
						
						
						<div class="send-notification">
						    
					        <div class="col-sm-12 col-xs-12">
					            <h6><b>Send<b></h6>
								
								<!-- Display validation errors -->
								@if ($errors->any())
                                <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                </div>
                                @endif
								<!-- end Display validation errors -->

								
								<!------------ Form ----------------->
								<form action="{{ route('send-notif') }}" method="POST" class="my-form">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label" for="tags">Select Userss:</label>
								    </div>
									
									<div class="form-group">
									
                                        <select class="selectpicker" data-live-search="true" name="users[]" id="users" multiple style="width:20em;">
									        @foreach($users as $user)
                                            <option  value="{{ $user->id }}">   {{ $user->name }}  </option>
									        @endforeach
                                        </select>
									</div>
									
									<div class="form-group">
									   <label for="message" class="form-label">Your Message:</label>
                                       <textarea name="message" id="message" rows="4" class="form-control" placeholder="Enter your message here..."></textarea>
									</div>

									<div class="form-group">
                                        <button class="btn btn-primary" type="submit"> Submit </button>
									</div>
									
                                </form>
								<!------------ End Form ----------------->


								
								<!------------ Display auth user notifications (from DB) ----------------->
								<div></br>Logged user notifications (for testing):</div>
								@foreach(auth()->user()->notifications as $notification)
                                    <div class="alert alert-info">
                                       {{ $notification->created_at }}   {{ $notification->data['data'] }} <!-- Display the message -->
                                    </div>
                                @endforeach 
                                <!------------ end Display auth user notifications ----------------->



                            </div>
							
						</div> <!-- end of  .venues-store-locator -->
						 
						
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('scripts')
@endsection

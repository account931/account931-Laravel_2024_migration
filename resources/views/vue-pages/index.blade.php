@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Vue Pages, request to <b> /api/owners </b> (open route, does not require Passport(access token))</div>

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
						
						
						<div class="vue-pages">
						    
						    <!-- Show Hello component -->
					        <div id="hello" class="col-sm-12 col-xs-12">
					            <h6><b>Owners List on Vue<b></h6>
					            <owners-list-component><owners-list-component/> <!-- Vue component -->   <!--<example-component/>-->
                            </div>
							
						</div> <!-- end of  .vue-pages -->
						 
						
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

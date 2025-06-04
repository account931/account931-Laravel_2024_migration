@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">Vue Pages (Vuex store, router, access to open and protected py Passport routes)</div>

                <div class="">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

					<div class="col-sm-12 col-12">
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
						
						</div> <!-- end row -->
						
						
						<div class="vue-pages col-sm-12 col-12">
						    
						    <!-- Show Hello component -->
					            <h6><b>Vue router<b></h6>
								<vue-router-menu-with-links/>
							
						</div> <!-- end of  .vue-pages -->
						 
						
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<!-- A test page to make api request to protected route /api/owners/quantity. Request shoud contain Passport token-->
<template>
	<div class="services">
	    
        <!--------- Unauthorized/unlogged Section ------> 
        <div v-if="this.$store.state.passport_api_tokenY == null" class="col-sm-12 col-xs-12 alert alert-info"> <!--auth check if Passport Token is set, i.e user is logged -->
            <!-- Display subcomponent/you_are_not_logged.vue -->
            <you-are-not-logged-page></you-are-not-logged-page>         
        </div>
        <!--------- end Unauthorized/unlogged Section ------> 
        
        
        <!--------- Authorized/Logged Section ----------> 
        <div v-else-if="this.$store.state.passport_api_tokenY != null">
		    You are logged </br>
			<button class="btn btn-info" @click="makeApiRequestToProtectedRoute">MakeApiRequest to protected route</button>	
			
			<!-- Here goes Api response -->
			<transition name="moveInUp"> <!-- animation-->
			<div v-if="this.showDiv == true">
			    </br>
			    <p> Response from Api </p>
			     Owners status:   {{ this.apiResponse.status }} </br>
                 Owners quantity: {{ this.apiResponse.quantity }} 				 
			</div>
			</transition> <!-- end animation-->
			<!-- End Here goes Api response -->
			
        </div>
		<!--------- End Authorized/Logged Section ----------> 
		 
		 
		 
		<!-- GIF Loader (appears while ajax runs  ---------->
        <div v-if="showLoader" class="col-sm-12 col-xs-12" style="position:absolute;top:-10%;left:6%"> 
		    <img src ="img/loader-black.gif" style="width:33%" alt="loader"/>
		</div>
		<!------------------ End GIF Loader ---------------->
		
		
	</div>
</template>
<script>
import youAreNotLogged  from '../subcomponents/you_are_not_logged.vue';
	export default{
		name:'Quantity',
		//using other sub-component 
	    components: {
            'you-are-not-logged-page' : youAreNotLogged,
        },
		data (){
			return{
				title      :'Quantity',
				showLoader : false,
				showDiv    : false,
				apiResponse: {quantity: '', status: ''}
			}
		},
		
		methods: {
		/*
        |--------------------------------------------------------------------------
        | Ajax request, get REST API located at => see routes/api
        |--------------------------------------------------------------------------
        |
        */
	    makeApiRequestToProtectedRoute() {  
		    //alert('run');
            this.showLoader = true;	
            //alert('store');
            var thatX = this; //to fix context issue
  
            //Axios method http variant 
            axios({
                method: 'get', 
                url: 'api/owners/quantity',
                headers: {
                    'Content-Type': 'application/json', 'Authorization': 'Bearer ' + this.$store.state.passport_api_tokenY
                },
            })
            .then(dataResponse => {
			    console.log('then => ' + JSON.stringify(dataResponse.data));
				//alert(JSON.stringify(dataResponse.data)); 
			
                setTimeout(() => {
        			this.showLoader = false;
                }, 2000); // 2000ms = 2 seconds delay
	  
          
                //change for Axios
                if (dataResponse.data && dataResponse.data.status == "OK" ){ 
				    //alert('success');
					//alert(dataResponse.data["owners quantity"]);   //cant use standart dot notation (dataResponse.data.owners quantity), as in API backend 'owners quantity' comes with blankspace
					this.apiResponse.quantity = dataResponse.data["owners quantity"]; //cant use standart dot notation (dataResponse.data.owners quantity), as in API backend 'owners quantity' comes with blankspace
                    this.apiResponse.status   = dataResponse.data.status;
					swal("Done", "Response is loaded (axios) (not Vuex store).", "success");
					
					setTimeout(() => { this.showDiv = true;}, 2000); // 2000ms = 2 seconds delay
	                //return commit('setPosts', dataResponse); //sets ajax results to store via mutation
                }
            })
	        .catch(function(err){ 
			    thatX.showLoader = false;
			    alert('catch');
                //$('.loader-x').fadeOut(800);  //hide loader
                //console.log("Getting articles failed ( in store/index.js). Check if ure logged =>  " + err);
                swal("Crashed", "You are in catch", "error");
                
                //changes for Axios //Unlogg the user 
                if(err == "Error: Request failed with status code 401" ||  err == "Unauthenticated."){ //if Rest endpoint returns any predefined error
                    //console.log("dataResponse.data.error 2 " + err.error);
                    swal("Unauthenticated2", "Check Bearer Token", "error");
                    
          
                }
            }); 
		   }
            //End Axios http variant
		 },  //end methods
		 
		mounted() {
            //this.$store.dispatch('getAllPosts'); //trigger ajax function getAllPosts(), which is executed in Vuex store to REST Endpoint => /public/post/get_all
		    //console.log('Mounted ' + this.$store.state.posts);
			//this.makeApiRequestToProtectedRoute();  //works
			//console.log('Mounted ' + this.$store.state.posts);
        },
		
		mutations: {
		    /*
            setPosts(dataR) {
                this.apiResponseQuantity = dataR.data.owners_quantity;
            },
			*/
	    },	 
		
	}
</script>

<style scoped>
/* animation */
.moveInUp-enter-active{
    animation: fadeIn 2s ease-in;
}
@keyframes fadeIn{
    0%{
        opacity: 0;
    }
    50%{
        opacity: 0.5;
    }
    100%{
        opacity: 1;
    }
}
.moveInUp-leave-active{
    animation: moveInUp .3s ease-in;
}
@keyframes moveInUp{
    0%{
        transform: translateY(0);
    }
    100%{
       transform: translateY(-400px);
    }
}
</style>

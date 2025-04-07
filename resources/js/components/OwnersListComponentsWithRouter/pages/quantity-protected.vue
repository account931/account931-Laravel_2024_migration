
<!-- Just a Lorem Ipsum template-->
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
		    logged
			
			
			
			
        </div>
		<!--------- End Authorized/Logged Section ----------> 
		 
		 
		 
		 
		 
		<!-- GIF Loader (appears while ajax runs  ---------->
        <div v-if="showLoader" class="col-sm-12 col-xs-12" style="position:absolute;top:-15%;left:6%"> 
		    <img src ="img/loader-black.gif" style="width:33%" alt="loader"/>
		</div>
		<!------------------ End GIF Loader --------->
		
		
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
				title:'Quantity',
				showLoader: false,
			}
		},
		
		methods: {
		/*
        |--------------------------------------------------------------------------
        | Ajax request, get REST API located at => WpBlog_VueContoller/ function getAllPosts(), get all blog posts (non-admin section)
        |--------------------------------------------------------------------------
        |
        */
	    makeApiRequest() {  
		    alert('run');
            state.showLoader = true;	
            //alert('store');
            //var thatX = this; //to fix context issue
  
            //Axios method http variant 
            axios({
                method: 'get', 
                url: 'api/owners/quantity',
                headers: {
                    'Content-Type': 'application/json', 'Authorization': 'Bearer ' + state.passport_api_tokenY
                },
            })
            .then(dataZ => {
			    console.log('nnn ' + dataZ);
			
                setTimeout(() => {
        			state.showLoader = false;
                }, 2000); // 2000ms = 2 seconds delay
	  
          
                //change for Axios
                if (dataZ.data){ 
				    //alert('success');
                    swal("Done", "Articles are loaded (axios) (Vuex store).", "success");
	                //return commit('setPosts', dataZ.data ); //sets ajax results to store via mutation
                }
            })
	        .catch(function(err){ 
			    alert('catch');
                //$('.loader-x').fadeOut(800);  //hide loader
                //console.log("Getting articles failed ( in store/index.js). Check if ure logged =>  " + err);
                swal("Crashed", "You are in catch", "error");
                
                //changes for Axios //Unlogg the user 
                if(err == "Error: Request failed with status code 401" ||  err == "Unauthenticated."){ //if Rest endpoint returns any predefined error
                    //console.log("dataZ.data.error 2 " + err.error);
                    swal("Unauthenticated2", "Check Bearer Token2", "error");
                    
          
                }
            }); 
            //End Axios http variant
		 },  //end methods
		 
		 mounted() {
            //this.$store.dispatch('getAllPosts'); //trigger ajax function getAllPosts(), which is executed in Vuex store to REST Endpoint => /public/post/get_all
		    //console.log('Mounted ' + this.$store.state.posts);
			this.makeApiRequest();
			//console.log('Mounted ' + this.$store.state.posts);
        },
		 
		 
		}
	}
</script>
<style scoped>
</style>

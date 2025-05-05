<!-- Show Mapbox Store Locator for Venues -->

<template>
    <div class="container">
	    <div class="col-sm-12 col-xs-12">
            <p> {{ this.title }}   </p>
			
	
	        <!-- Mapbox container -->
	        <div id="map" class="map-container"></div>
			
			<!-- Show all data with coords received from /api/owners -->
		    <p style="margin-top:2em; font-size: 0.8em;">  {{this.allVenuesCoords}}} </p>
			
            <!----------- GIF Loader (appears while ajax runs  ----->
           <div v-if="showLoader" class="col-sm-12 col-xs-12" style="position:absolute;top:-15%;left:20%"> 
		       <img src ="img/loader-black.gif" alt="loader"/>
		   </div>
		   <!------------------ End GIF Loader ---------------------->
		   		
			
	    </div> <!-- end class="col-sm-12 col-xs-12" -->	   
    </div>
</template>

<script>
    import mapboxgl from 'mapbox-gl';      //MapBox Vue
    import 'mapbox-gl/dist/mapbox-gl.css'; //MapBox CSS (to display markers)
    
    //import { mapState } from 'vuex';
    import axios from 'axios';
    export default {
	   name: 'MapboxMap',
	    data (){
			return{
				title:'Venues store locator component',
				//postDialogVisible: false,
				//manualPosts: [], //not used 
                //currentPost: '',
                //ifMakeAjax: true,
				allVenuesCoords: [],
				showLoader: false
    
			}
		},
		
        mounted() {
			//alert(this.allVenuesCoords);
            //console.log('Component mounted.')
			
			// Mapbox access token. It is set in .env -> then defined in /config.app as app.frontend.mapbox_token_from_config => then we pass it in Blade /views/venue-store-locator/index
            mapboxgl.accessToken = process.env.MIX_MAPBOX_API_KEY;   //window.mapbox_api_token_from_config.tokenMapBox;  //env('MAPBOX_API_KEY');  // Replace with your actual Mapbox access token

            // Initialize map
            const map = new mapboxgl.Map({
                container: 'map', // The ID of the container (div)
                style: 'mapbox://styles/mapbox/streets-v11', // Map style (you can choose any style from Mapbox)
                center: [2.649570, 39.581595], // Initial map center [longitude, latitude]
                zoom: 9, // Initial zoom level
				
				
            });

			 this.map = map;
			 
			 map.addControl(new mapboxgl.NavigationControl(), 'top-right'); //add zoom icon
			
            // Add a marker (example)
            new mapboxgl.Marker()
               .setLngLat([2.602878, 39.576832,])  // Set marker position
			   .setPopup(
                    new mapboxgl.Popup({ offset: 25 }) // Optional offset for styling
                    .setHTML('<h3>Marker Name</h3><p>It is just test...</p>')
                 )
               .addTo(map);  // Add marker to the ma
			   
			   //alert('Mounted ends');
        },
        beforeDestroy() {
            if (this.map) {
                this.map.remove(); // Clean up when the component is destroyed
            }
        },
			
			
		beforeMount() {
		    this.getAllVenuesCoordinates(); //api call to /api/owners
            //this.$store.dispatch('getAllPosts'); //trigger ajax function getAllPosts(), which is executed in Vuex store to REST Endpoint => /public/post/get_all
		    //console.log('Mounted ' + this.$store.state.posts);
			//console.log('Mounted ' + this.$store.state.posts);
        },
		
		computed: {
            //...mapState(['posts']), //is needed for Vuex store, after it u may address Vuex Store value as {posts} instead of {this.$store.state.posts}

			checkOwnerStore() { 
		      //console.log('CheckStore ' + JSON.stringify( this.$store.state.posts));
		      //return this.$store.state.posts;
		      //return [{"wpBlog_id":1,"wpBlog_title":"Article 1", "wpBlog_text":"Text 1"}, {"wpBlog_id":2,"wpBlog_title":"Article 2", "wpBlog_text":"Text 2"}]
            },
			
		
		},
			
			
	   /*	
	    |--------------------------------------------------------------------------
        | Methods
        |--------------------------------------------------------------------------
        */
		methods: {
		
			
		   /*	
	        |--------------------------------------------------------------------------
            | get venues coordinates from /api/owners
            |--------------------------------------------------------------------------
            */
			getAllVenuesCoordinates() {
			    this.showLoader	= true;	
			   let that = this;
  
               //Axios method http variant 
                axios({
                    method: 'get', 
                    url: 'api/owners',
                    headers: {
                        //'Content-Type': 'application/json', 'Authorization': 'Bearer ' + state.passport_api_tokenY
                    },
                })
                .then(dataZ => {
				    //alert('then');
                    //console.log(dataZ);
                    //$('.loader-x').fadeOut(800);  //hide loader
                    setTimeout(() => {
        			    this.showLoader	= false;
                    }, 2000); // 2000ms = 2 seconds delay
	  
          
                    //change for Axios
                    if (dataZ.data){ 
				        //alert('success');
                        swal("Done", "Coordinates are loaded (axios).", "success");
	                    //return commit('setPosts', dataZ.data ); //sets ajax results to store via mutation
						// alert(dataZ.data);
						
						//getting all coords and adding to array allVenuesCoords[]
						for (const key in dataZ.data.data) {
						    //console.log(dataZ.data.data[key]);
							
							for (const key2 in dataZ.data.data[key]['venues']) {
							    //console.log(dataZ.data.data[key]['venues'][key2]['location']);
								that.allVenuesCoords.push({ 
								     coords:    dataZ.data.data[key]['venues'][key2]['location'], 
									 name:      dataZ.data.data[key]['venues'][key2]['venue_name'], 
									 address:   dataZ.data.data[key]['venues'][key2]['address'],
							   });
							}
								
						}
						
						
						//
						//iterate over allVenuesCoords[] & add all coords in loop to Mapbox map
			            for(let i=0; i < that.allVenuesCoords.length; i++){
			                console.log(that.allVenuesCoords[i]);
						    console.log(that.allVenuesCoords[i].coords.lon);
			                new mapboxgl.Marker()
                                .setLngLat([ that.allVenuesCoords[i].coords.lon, that.allVenuesCoords[i].coords.lat ])  // Set marker position
			                    .setPopup(
                                    new mapboxgl.Popup({ offset: 25 }) // Optional offset for styling
                                      .setHTML('<h3>Marker Name</h3>  <p>' + that.allVenuesCoords[i].name + '</p> <p>address: ' + that.allVenuesCoords[i].address + '</p>')
                                )
                            .addTo(that.map);  // Add marker to the map
			   
			                } //end add all coords in loop
							//
							
                    }
                })
	            .catch(function(err){ 
			        alert('catch');
                    //$('.loader-x').fadeOut(800);  //hide loader
                    //console.log("Getting articles failed ( in store/index.js). Check if ure logged =>  " + err);
                    swal("Crashed", "You are in catch, check" + " <b> mapboxgl.accessToken</b>", "error");
					
					
                
                    //changes for Axios //Unlogg the user 
                    if(err == "Error: Request failed with status code 401" ||  err == "Unauthenticated."){ //if Rest endpoint returns any predefined error
                        //console.log("dataZ.data.error 2 " + err.error);
                        swal("Unauthenticated2", "Check Bearer Token2", "error");
                    
                        //Unlog the user if  dataZ.error == "Unauthenticated." || 401, otherwise if user has wrong password token saved in Locals storage, he will always recieve error and never logs out                  
                        //store.dispatch('LogUserOut');//this.$store.dispatch('LogUserOut'); //trigger Vuex function LogUserOut(), which is executed in Vuex store
                    
                    }
                }); 
                //End Axios http variant
				
            },
			
        }
			
    }
</script>

<style scoped>
#map {
  width: 100%;
  height: 400px;  /* Adjust the map height */
}

.map-container {
  position: relative;
  width: 100%;
  height: 100%;
}
</style>
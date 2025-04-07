<!-- View 1 blog post via router -->
<template>
	<div class="contact">
	
	    <!--------- Unauthorized/unlogged Section ------> 
        <div v-if="this.$store.state.passport_api_tokenY == null" class="col-sm-12 col-xs-12 alert alert-info"> <!--auth check if Passport Token is set, i.e user is logged -->
            <!-- Display subcomponent/you_are_not_logged.vue -->
            <you-are-not-logged-page></you-are-not-logged-page>         
        </div>
        
        
        
        <!--------- Authorized/Logged Section ----------> 
        <div v-else-if="this.$store.state.passport_api_tokenY != null">
				
		    <p>Details</p>
			
			
			<!-- If no records -->
            <div v-if="this.$store.state.posts.length == 0" class="col-sm-12 col-xs-12"> 
                <hr>
              	
			    <p class="text-danger"> No data fetched for yout Post {{ this.$route.params.Pidd }} , visit first <br> <router-link class="nav-link" to="/owners-list"> <button class="btn btn-success"> Vue Crud panel </button> </router-link> </p>
		    </div>
				
			

            <!-------- If  records are available || records are not null ---------------->
		    <div v-else class="col-sm-12 col-xs-12">
				
				
			    <!------- If record ID does not exist in this.$store.state.posts (user intentionally inputs wrong ID)----->
                <div v-if="this.$store.state.posts[this.currentDetailID] == undefined" class="col-sm-12 col-xs-12"> 
                    <hr>			
			        <p class="text-danger"> Article ID {{ this.$route.params.Pidd }} does not exist , visit first <br> <router-link class="nav-link" to="/owners-list"> <button class="btn btn-success"> Vue Crud panel </button> </router-link> </p>
		        </div>
				<!-- End If record ID does not exist in this.$store.state.posts (user intentionally inputs wrong ID)  -->
			
		
		
		        <!------------ If record ID exist in this.$store.state.posts, then show it ------------->
                <div v-else class="col-sm-12 col-xs-12">
                 
		            <!-- Show one product, based on URL ID. Gets values from Vuex store in "/store/index.js" -->
		            <div>
		                <hr>
                        <!-- Nav Link go back -->
                        <p class="z-overlay-fix-2"> 
                            <router-link class="nav-link" to="/owners-list">
                                 <button class="btn"> Back to Blog_List <i class="fas fa-tag" style="font-size:14px"></i></button>
                            </router-link>
                        </p>
                        <!-- End Nav Link go back -->
		    
                        <p> One owner </p>
						<i class='fas fa-wine-bottle'></i>
                
                        <hr>
                        <p> Owner:  <b> {{ this.$store.state.posts[this.currentDetailID].first_name }} {{ this.$store.state.posts[this.currentDetailID].last_name }} </b></p>
				
				        <!-- Venues hasMany -->
				        <p> Owner has {{ this.$store.state.posts[this.currentDetailID].venues.length }} venues:   </p>   <!-- {venues} is a model HasMany relation {function venus} -->
				        <div v-for="(venue, v) in this.$store.state.posts[this.currentDetailID].venues" :key=v>
				            <p> Venue {{ v }}:   {{ venue.venue_name }}, address:  {{ venue.address }} </p> 
					
					        <!-- Equipment hasMany -->
					        <ul>
					            <li> Venue has {{ venue.equipments.length }} equipments:   </li>
					                <div v-for="(equipment, e) in venue.equipments" :key=e>
				                        <li> Equipmet {{ e }}:   {{ equipment.trademark_name }} {{ equipment.model_name }} </li> 
					                </div>
					            </ul>
					        <!-- Equipment hasMany -->
					
					
				        </div>
				        <!-- End Venues hasMany -->
				
           

           
                        <!-- Show all article images via FOR LOOP except for first. HasMany Relation -->
                        <div class="col-md-12" v-for="(img, i) in this.$store.state.posts[this.currentDetailID].get_images" :key=i>
                            <div v-if="i > 0">
                                <img :src="`images/wpressImages/${img.wpImStock_name}`" class="img-thumbnail" alt="">
                            </div>
                        </div>
          
                    </div>
		            <!-- End Show one product, based on URL ID -->
					
				</div><!-- End If record ID exist in this.$store.state.posts, then show it	-->
				
			</div><!-- End If  records are available || records are not null-->	
			
		    <br><br>
		</div> 
		<!--------- Authorized/Logged Section ----------> 
	</div>
</template>


<script>
import { mapState } from 'vuex';
//using other sub-component 
import youAreNotLogged  from '../subcomponents/you_are_not_logged.vue';
export default {
    name: 'details-info',
	//using other sub-component 
	components: {
        'you-are-not-logged-page' : youAreNotLogged,
    },
    data() {
        return {
	        currentDetailID: 1, 
        };
    },
  
    computed: {
	   ...mapState(['posts']), //is needed for Vuex store, after it u may address Vuex Store value as {products} instead of {this.$store.state.products}
    },
  
    //before mount
    beforeMount() { 
        //Passport token check
        if(this.$store.state.passport_api_tokenY == null){
            swal("View one page says: Access denied", "You are not logged", "error");
            return false;
        } 	
	    //getting route ID => e.g "wpBlogVueFrameWork#/details/2", gets 2. {Pid} is set in 'pages/home' in => this.$router.push({name:'details',params:{Pid:proId}})
	    let ID = this.$route.params.Pidd; //gets 1, 2, etc
		//alert(ID);
	    ID = ID - 1; //to comply with Vuex Store array, that starts with 0
	    this.currentDetailID = ID; //set to this.state
    },
	mounted() { 
	    //alert('length ' +this.$store.state.posts.length);
	}
}
</script>

<style scoped>
.contact form{
	max-width: 40em;
	margin: 2em auto;
}
.contact form .form-control{
	margin-bottom: 1em;
}
.contact form textarea{
	min-height: 20em;
}	
</style>
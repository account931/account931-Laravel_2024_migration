
//Vuex store
import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);
const debug = process.env.NODE_ENV !== 'production';

//Vuex store itself
export default new Vuex.Store({
    state: {
	    posts : [], //all owners // [{"id":1,"first_name":"Michel","last_name":"O'Keefe","confirmed":1,"venues":[{"id":1,"venue_name":"Herman","address":"12501 Herzog","active":1,"equipments":[{"id":1,"trademark_name":"Pioneer","model_name":"SL-1200"},{"id":2,"trademark_name":"Technics","model_name":"SL-1200"}],"status":"success"}, ,{"id":2,"venue_name":"Runolfsdottir Ltd","address":"6700 Jackeli......
        //posts: [ {first_name:"Owner1", last_name:"Some_last", id:1},{first_name:"Owner2", last_name:"Some_last2", id:2},],
		//adm_posts_qunatity : 0, //quantity of posts found
        loggedUser         : JSON.parse(localStorage.getItem('loggedStorageUser')) || {name: 'not set', email: 'errorMail'}, //logged user data (JS type:Object), set by Login ajax, {name: '', email: ''}  use {JSON.parse} to convert string to JS type: OBJECT
		passport_api_tokenY: localStorage.getItem('tokenZ') || null , // is set by ajax in /subcomponents/login.vue {thatX.$store.dispatch('changeVuexStoreLogged', data); and mutated here by { changeVuexStoreLogged({ commit }, dataTestX) } }
		//api_tokenY       : localStorage.getItem('tokenZ') || '' , //api_token is passed from php in view as <vue-router-menu-with-link-content-display v-bind:current-user='{!! Auth::user()->toJson() !!}'>  and uplifted here to this store in VueRouterMenu in beforeMount() Section. Was true in prev project
        showLoader: false,  //show/hide loader in component
	},
  
    getters: {
        //minor getter, can delete (both from Login_component)
        getCart(state) { 
            return state.passport_api_tokenY;
        },
        
    },
    
	
   /*	
	|--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */
    actions: {
		
       
           
       /*
        |--------------------------------------------------------------------------
        | Ajax request, get REST API located at => WpBlog_VueContoller/ function getAllPosts(), get all blog posts (non-admin section)
        |--------------------------------------------------------------------------
        |
        */
	    getAllPosts({ commit, state  }) { 
            state.showLoader	= true;	
            //alert('store');
            //var thatX = this; //to fix context issue
  
            //Axios method http variant 
            axios({
                method: 'get', 
                url: 'api/owners',
                headers: {
                    'Content-Type': 'application/json', 'Authorization': 'Bearer ' + state.passport_api_tokenY
                },
            })
            .then(dataZ => {
				//alert('then');
                //console.log(dataZ);
                //$('.loader-x').fadeOut(800);  //hide loader
                setTimeout(() => {
        			state.showLoader	= false;
                }, 2000); // 2000ms = 2 seconds delay
	  
          
                //change for Axios
                if (dataZ.data){ 
				    //alert('success');
                    swal("Done", "Articles are loaded (axios) (Vuex store).", "success");
	                return commit('setPosts', dataZ.data ); //sets ajax results to store via mutation
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
                    
                    //Unlog the user if  dataZ.error == "Unauthenticated." || 401, otherwise if user has wrong password token saved in Locals storage, he will always recieve error and never logs out                  
                    //store.dispatch('LogUserOut');//this.$store.dispatch('LogUserOut'); //trigger Vuex function LogUserOut(), which is executed in Vuex store
                    localStorage.removeItem('tokenZ'); //clear localStorage
                    localStorage.removeItem('loggedStorageUser');
                    commit('LogOutMutation'); //reset state vars (state.passport_api_tokenY + state.loggedUser) via mutation
                    state.passport_api_tokenY = null;
                }
            }); 
            //End Axios http variant
      
        },
        
        //on API Login success save data to Store (trigger mutation)
        changeVuexStoreLogged({ commit }, dataTestX) { 
            return commit('setLoginResults', dataTestX ); //sets dataTestX to store via mutation
        },
       
       /*
        |--------------------------------------------------------------------------
        | Logging user out, triggered in /subcomponents/logged.vue (subcomponent of Login_component.vue )
        |--------------------------------------------------------------------------
        |
        |
        */
		LogUserOut ({ commit }) { 
            localStorage.removeItem('tokenZ'); //clear localStorage
            localStorage.removeItem('loggedStorageUser');
            commit('LogOutMutation'); //reset state vars to store via mutation
            
        },
        	  
	},

	
	/*
    |--------------------------------------------------------------------------
    | Mutation section
    |--------------------------------------------------------------------------
    |
    |
    */
    mutations: {
        setPosts(state, response) {  
		    //alert('mutate');
            state.posts = response.data;
	        //console.log('setPosts executed in store' + state.posts[0]);
			//console.log ('mutation ' + JSON.stringify(state.posts)); 
        },
		
		//For mutation to set a quantity of found posts(in Admin Part). Fired in list_all. passedArgument is an arg passed in list_all.vue
		/*
        setPostsQuantity ({ commit, state  }, passedArgument) {  
            return commit('setQuantMutations', passedArgument ); //to store via mutation
        },
		*/
		
		//on API Login success save data to Store (trigger mutation)
        setLoginResults (state, response) { 
            //sets user's array to Vuex store object(state.state.loggedUser). Is gotten from /subcomponents/login.vue ajax 
            localStorage.setItem('loggedStorageUser', JSON.stringify(response.user)); //use {JSON.stringify} to save JS type:Object (i.e converts Object to string) //saves to localStorage to not reset data on every F5        
            state.loggedUser = response.user;  //sets Vuex user Object (JS type:Object) {name: '', email: ''} 

            //sets the passport api token to Vuex store(state.passport_api_tokenY). Is gotten from /subcomponents/login.vue ajax 
            localStorage.setItem('tokenZ', response.access_token); //saves to localStorage to not reset data on every F5        
            state.passport_api_tokenY = response.access_token;

	        //console.log('setApiToken executed in store' + response + ' Store => ' + state.passport_api_token);
            //console.log('set apiToken mutation is done. localStorage is ' + localStorage.getItem('tokenZ'));
        },
        

        //Log out mutation (clear state.passport_api_tokenY +  state.loggedUser vars) 
        LogOutMutation(state) {
            state.passport_api_tokenY = null;
            state.loggedUser          = {}; 
        },

    },
    strict: debug
});

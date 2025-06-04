
<!-- This is a Sub-component of Login_component.vue, used in \resources\assets\js\Wp_Login_Register_Rest\components -->
<!-- Uses Vuex store: this.$store.state.ifLogged -->

<template>

    <div class="col-sm-12 col-12 borderX">
        <center>
		    <p> Login Vue </p>
        </center>
        
        <!-- Link to registration for new users -->
        <div>
             <button class="btn btn-info"  @click="goToRegister">  Not registered yet? </button>
        </div>
        <!-- Link to registration for new users -->
    
        <div class="form-group">
            <div v-if="status_msg" class="alert-danger alert" role="alert">
                {{ status_msg }}
            </div>
            
            
            <!-- Login Form -->
            <form class="login" @submit.prevent="loginSubmit">
                <h1 class="responsive-heading"> Sign in </h1>
                <p><i class="fa fa-external-link" style="font-size:36px"></i></p>
                
				<!-- Login: email -->
				<div class="form-row justify-content-center">
                    <div class="col-md-6 col-12 form-group">
                        <label for="email">E-Mail Address</label>
                        <input required v-model="email" type="email" placeholder="Name"  class="form-control"/>
                    </div>
				</div>
               
                <!-- Password -->
				<div class="form-row justify-content-center">
                    <div class="col-md-6 col-12 form-group">
                        <label for="password">Password</label>
                        <input required v-model="password" type="password" placeholder="Password" id="passwordd"  class="form-control"/>
                        <i class="fa fa-eye" id="passEye" @click="togglePassword" style="cursor:pointer;"></i>
                    </div>
				</div>
				
				<!-- Hint/promt for username. If username was prev saved to LocalStorage -->
				<div class="form-row">
				    <div class="col-sm-12 col-12 alert alert-info borderX" :class="this.cssStateFlagHidden ? ' hide-me' : '' "   id="userNameHint">
				        <transition name="moveInUp"> <!-- appear with delay ?-->
				            <p class="small-ft"> 
					        Last time you logged as <b> {{ this.user_Name_Hint }} </b> (LocStorage). 
						    Wanna use it? <button type="button"  v-on:click="useNameHint"> Yes </button> <!-- if use simple <button> it will fire form submitting -->
					        </p>
					
				        </transition>
                 
                			 
                        <p class="small-ft text-danger"> 
				        <i class="fas fa-award"></i>
				        <small>You may check credentials in  => <span class ="text-success">\Seeds\...\UserSeeder;</span> otherwise see Factories\UserFactory </small>(one DB)
				        </p>
					 
				    </div>
				</div>
				<!-- End Hint/promt for username. If username was prev saved to LocalStorage -->
                
                <hr><br><br>
                <button type="submit" class="btn btn-info">Login <i class="	fa fa-folder-open-o" style="font-size:12px"></i></button>
            </form>
        </div>
		
		<!------------------ GIF Loader (appears while ajax runs  ---->
        <div v-if="showLoader" class="col-sm-12 col-12" style="position:absolute;top:-15%;left:6%"> 
		    <img src ="img/loader-black.gif" style="width:33%" alt="loader"/>
		</div>
		<!------------------ End GIF Loader --------------------------->
		   
    </div>

</template>

<script>

export default {
    name: 'all-posts',
    data() {
        return {
            email : "",
            password : "",
            status_msg: "", //validate error message
            status: "",
			cssStateFlagHidden: true, //flag for CSS visibility change (username hint). true means hidden
			user_Name_Hint: "",
			showLoader: false,
        };
    },
  
    computed: { 
    },
    beforeMount() {
		//check if Local storage contains userName hint (from prev Login)
		if (localStorage.getItem("usernameHint93111111") != null) {
		    let locStorageName = localStorage.getItem("usernameHint93111111"); //gets the prev value of username field
			
			var thatSelf = this; //this issue fix
			
			//set with delay to show interactivity
			setTimeout(function(thatX ) {
			    thatSelf.cssStateFlagHidden = false;
			    thatSelf.user_Name_Hint = locStorageName;
            }, 2000)
		}

    },
	
    methods: {
    
        /*
        |--------------------------------------------------------------------------
        |Rest Api Login submit
        |--------------------------------------------------------------------------
        |
        |
        */
        loginSubmit (e) {
            e.preventDefault();
            if (!this.validateForm()) {
                return false;
            }
            
			this.showLoader = true;
			
			//save userName to Locasl storage for UserName hint
			localStorage.setItem("usernameHint93111111", this.email);
			
            let emailX    = this.email; 
            let passwordX = this.password;
            
            //Use Formdata to bind inpts 
            var thatX = this; //Fix for ajax 
            var formData = new FormData(); 
            formData.append('email',     this.email);
            formData.append('password',  this.password);
            
            $.ajax({
		        url: 'api/login', 
                type: 'POST', //POST is to create a new user
                cache : false,
                dataType    : 'json',
                processData : false,
                contentType: false,
			    //passing the data
                data: formData, 
                success: function(data) {
				    this.showLoader = true;
					
                    if(data.error_message){
                        swal("Failed", data.error_message, "error");
                        thatX.status_msg = data.error_message;
                    } else {
                        thatX.$store.dispatch('changeVuexStoreLogged', data); // save Passport token, change Vuex store from child component 
                    }
                }, 
            
			    error: function (errorZ) {
                    alert("error " +  JSON.stringify(errorZ, null, 4));                    
			    }	  
            });                             
        },
        
        
        /*
        |--------------------------------------------------------------------------
        |Client-side form validation
        |--------------------------------------------------------------------------
        |
        |
        */
        validateForm() {
            if (!this.email) {
                this.status = false;
                this.showNotification('Email title cannot be empty');
                return false;
            }
            if (!this.password) {
                this.status = false;
                this.showNotification('Password cannot be empty');
                return false;
            }
            this.showNotification(''); //clears error messages if any prev
            return true;
        },
        
        showNotification (message) {
            this.status_msg = message;
            setTimeout(() => {  //clears message in n seconds
                this.status_msg = ''
            }, 3000 * 155)
        },
        
        
         
        /*
        |--------------------------------------------------------------------------
        |Toggles Password Visibility //eye icon in Password input 
        |--------------------------------------------------------------------------
        |
        |
        */
        togglePassword(){
            const password  = document.querySelector('#passwordd');
            const type      = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            document.getElementById("passEye").classList.toggle('fa-eye-slash');//HTML DOM property element.classList //classList.toggle => 
        },
		
		
		/*
        |--------------------------------------------------------------------------
        |Use userName Hint, on button click "Yes", set Loc storage vaue to email
        |--------------------------------------------------------------------------
        |
        |
        */
		useNameHint(){
			this.email = this.user_Name_Hint;
			return false;
		},
		
		//open link in router
        goToRegister() {
           this.$router.push({name:'register-path' /*,params:{Pidd:proId}*/}) //creates route like "/wpBlogVueFrameWork#/details/3"
        },
        
    },
}
</script>

<style scoped>
.hide-me {display:none;}
.small-ft {font-size:0.7em;}

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

#Mobile responsive-heading
 .responsive-heading {
    font-size: 2.5rem; /* Desktop size, h1-ish */
  }

  @media (max-width: 576px) {
    .responsive-heading {
      font-size: 0.75rem; /* Mobile size, h6-ish */
    }
  }
</style>

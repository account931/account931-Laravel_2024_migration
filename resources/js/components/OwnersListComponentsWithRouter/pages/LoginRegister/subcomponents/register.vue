<!-- This is a Sub-component of Registration_component.vue, used in \resources\assets\js\Wp_Login_Register_Rest\components -->
<!-- Uses Vuex store: this.$store.state.passport_api_tokenY -->

<template>

    <div class="col-sm-12 col-xs-12 alert alert-info borderX">
        <center>
		    <p> Registration Vue </p>
        </center>
        
        <!-- Display Validation errors if any come from Controller Request Php validator -->
        <div v-for="(book, i) in booksGet " :key="i" class="alert alert-danger"> 
            Error: {{ book }} 
        </div>
        
        <div class="form-group">
            <div v-if="status_msg" class="alert-danger alert" role="alert">
                {{ status_msg }}
            </div>
            
            <!-- Register Form -->
            <form class="login" @submit.prevent="registerSubmit">
                <h1>Register</h1>
                <p><i class="fa fa-credit-card" style="font-size:36px"></i></p>
                
                <!-- Login: email -->
                <div class="col-md-6 form-group">
                    <label for="email" class="col-md-6 control-label">E-Mail Address</label>
                    <input required v-model="email" type="email" placeholder="Email"  class="form-control"/>
                </div>
                
                <!-- Name -->
                <div class="col-md-6 form-group">
                    <label for="name" class="col-md-6 control-label"> Name </label>
                    <input required v-model="name" type="text" placeholder="Name"  class="form-control"/>
                </div>
               
                <!-- Password -->
                <div class="col-md-6 form-group">
                    <label for="password" class="col-md-6 control-label">Password</label>
                    <input required v-model="password" type="password" placeholder="Password" id="passwordd"  class="form-control" required/>
                    <i class="fa fa-eye" id="passEye1" @click="togglePasswordReg1" style="cursor:pointer;"></i>
                </div>
                
                <!-- Password Confirmation -->
                <div class="col-md-6 form-group">
                    <label for="passworddConfirm" class="col-md-6 control-label">Confirm Password</label>
                    <input required v-model="password_confirm" type="password" placeholder="Confirm Password" id="passworddConfirm"  class="form-control"/>
                    <i class="fa fa-eye" id="passEye2" @click="togglePasswordReg2" style="cursor:pointer;"></i>
                </div>
                
                <hr><br><br>
                <button type="submit" class="btn btn-info"> Register <i class="	fa fa-folder-open-o" style="font-size:12px"></i></button>
            </form>
        </div>
    </div>

</template>

<script>
export default {
    name: 'all-posts',
    data() {
        return {
            email           : "",  //form email
            password        : "",  //form password
            password_confirm: "",  //form password confirm
            name            : "",  //form name
            status_msg      : "",  //validate error message
            status          : "",
            errroList: [],         //list of validations errors of server-side validator
        };
    },
  
    computed: { 
        booksGet () { //compute Back-end validation errors
            return this.errroList;
        }      
    },
    beforeMount() {},
    methods: {
    
        /*
        |--------------------------------------------------------------------------
        |Rest Api Registration submit
        |--------------------------------------------------------------------------
        |
        |
        */
        registerSubmit (e) {
            e.preventDefault();
            if (!this.validateForm()) {
                return false;
            }
            
            var that = this; //Fix this issue. 
            let emailX    = this.email; 
            let passwordX = this.password;
            
            //Use Formdata to bind inpts 
            var thatX = this; //Fix for ajax 
            var formData = new FormData(); 
            formData.append('email',                  this.email);
            formData.append('name',                   this.name);
            formData.append('password',               this.password);
            formData.append('password_confirmation',  this.password_confirm); //must be named 'password_confirmation', i.e 'firstINPUT_confirmation' to be automatically validate in back-end via ('password' => 'required|confirmed',)
            
            $.ajax({
		        url: 'api/register', 
                type: 'POST', 
                cache : false,
                dataType    : 'json',
                processData : false,
                contentType: false,
			    //passing the data
                data: formData, 
                success: function(data) {
                    if(data.error_message){
                        swal("Failed", data.error_message, "error");
                        thatX.status_msg = data.error_message;
                        
                        //setting the list of validations errors of server-side validator
                        var tempoArray = []; //temporary array
                        for (var key in data.validateErrors) { //Object iterate
                            var t = data.validateErrors[key][0]; //gets validation err message, e.g validateErrors.title[0]
                            tempoArray.push(t);
                        }
                        that.errroList = tempoArray; 
                        
                    } else {
                        swal("OK", "Reg is OK", "success");
                        var tempoArray = []; 
                        that.errroList = tempoArray; //clears validation server-side errors if any. Simple that.errroList = [] won't work
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
            
             if (!this.name) {
                this.status = false;
                this.showNotification('Name cannot be empty');
                return false;
            }
            
            if (!this.password) {
                this.status = false;
                this.showNotification('Password cannot be empty');
                return false;
            }
            
            if (!this.password_confirm) {
                this.status = false;
                this.showNotification('Password confirm cannot be empty');
                return false;
            }
            
            //client-side password match check
            if (this.password != this.password_confirm) {
                this.status = false;
                this.showNotification('Passwords do not match');
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
        togglePasswordReg1(){
            const password = document.querySelector('#passwordd');
            const type     = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            document.getElementById("passEye1").classList.toggle('fa-eye-slash');//HTML DOM property element.classList 
        },
        
        togglePasswordReg2(){
            const password = document.querySelector('#passworddConfirm');
            const type     = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            document.getElementById("passEye2").classList.toggle('fa-eye-slash');//HTML DOM property element.classList 
        },
    },
}
</script>
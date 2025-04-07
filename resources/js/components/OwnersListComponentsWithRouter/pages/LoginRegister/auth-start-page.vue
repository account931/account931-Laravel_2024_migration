<!-- Displays either login form or user dashboard (depends on this.$store.state.passport_api_tokenY)
<!-- Uses /subcomponents/login.vue + /subcomponents/logged.vue -->
<!-- Uses Vuex store: this.$store.state.passport_api_tokenY -->

<template>

    <div class="col-sm-12 col-xs-12 alert alert-info borderX">
        <center> 
            <p> Login: {{ this.ifPassportTokenSet }}   </p> 
            
            <!-- If user is logged, use logged-user-page View -->
            <div v-if="this.$store.state.passport_api_tokenY !== null && this.$store.state.passport_api_tokenY !== undefined && this.$store.state.passport_api_tokenY !== ''"> <!--auth check if Passport Token is set, i.e user is logged -->
                Logged
                <logged-user-page></logged-user-page>
            </div>
            
            <!-- Login Form -->
            <div v-else class="col-sm-12 col-xs-12 alert alert-info">
                <div class="col-sm-4 col-xs-4 alert alert-danger col-sm-offset-4 col-xs-offset-4">
                    Not Logged 
                </div>
                <login-auth-page> </login-auth-page> <!-- Vue subcomponent (Login Form) -->
            </div>
        </center>
    </div>

</template>

<script>
//using other sub-component 
import loginPage      from './subcomponents/login.vue';
import loggedUserPage from './subcomponents/logged.vue';

export default {
    name: 'all-posts',
    
    //using other sub-component 
	
	components: {
          'login-auth-page' : loginPage,
          'logged-user-page': loggedUserPage,
    },
    data() {
        return {};
    },
  
    computed: { 
        //just to form text information
        ifPassportTokenSet () {
            if(this.$store.state.passport_api_tokenY != null  && this.$store.state.passport_api_tokenY !== undefined && this.$store.state.passport_api_tokenY !== ''){
                return " Passport Token is set, User is logged";
            } else {
                return " Passport Token is not set, login first";
            }
        },
        
        isLoggedInZ(){ return this.$store.getters.isLoggedIn },			

    },
	
	watch: {},
    beforeMount() {},
    created(){},
    methods: {},
}
</script>
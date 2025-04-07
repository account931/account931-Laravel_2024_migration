<!-- This is a Sub-component of Login_component.vue, used in \resources\assets\js\Wp_Login_Register_Rest\components -->
<!-- Uses Vuex store: this.$store.state.loggedUser + this.$store.state.passport_api_tokenY -->

<template>

    <div class="col-sm-12 col-xs-12 alert alert-info borderX">
        <center>
           <p> </br> <button class="btn btn-success" @click="logMeOut"> Log out </button> </br></br></p>
		   <p> <i class="fas fa-address-book" style="font-size:46px"></i></p>
		   <h3> Your name is  <b> {{this.$store.state.loggedUser.name}}        </b> </h3>
           <p>  Your email is <b> {{this.$store.state.loggedUser.email}}       </b></p>
		   <p>  Registered    <b> {{this.$store.state.loggedUser.created_at}}  </b></p>
           <p style="word-wrap: break-word; font-size:0.8em;"> Token is  {{this.truncateText(this.$store.state.passport_api_tokenY, 66) }} </p>
        </center>
    </div>

</template>

<script>
export default {
    name: 'all-posts',
    data() {
        return {
        };
    },
  
    //computed property is used to declaratively describe a value that depends on other values. When you data-bind to a computed property inside the template, Vue knows when to update the DOM when any of the values depended upon by the computed property has changed.
    computed: { 
    },
    beforeMount() {
    },
    methods: {
        logMeOut(){
            this.$store.dispatch('LogUserOut'); //trigger Vuex function LogUserOut(), which is executed in Vuex store
        },
		truncateText(text, length) {
                if (text.length > length) {
                    return `${text.substr(0, length)}...`;
                }
                return text;
        },
    },
}
</script>
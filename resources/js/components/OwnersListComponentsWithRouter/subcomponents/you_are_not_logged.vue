
<!-- Template "When user is not logged"  -->
<!-- Subcomponent, used in blog_2021.vue, loadnew.vue  -->
<template>
    <h3> 
        <p class="small">subcomponent/you_are_not_logged </p>
        <i class="fa fa-minus-circle" style="font-size:15px;color:red"></i> 
        <p>Sorry, you are not logged. Login first </p>
        <p> <button class="btn-default my-btn" @click="goRegisterComponent">  Click to go to Login page  </button> </p>
        </hr> 
        <i class="fa fa-globe" style="font-size:55px;"></i> 
    </h3>
</template>
<script>
	export default{
		name:'You_are_not_now_logged',
		data (){
			return{
				title:'Unlogged'
			}
		},
		methods: {
		    goRegisterComponent() {
                this.$router.push({name:'login-reg'}) //creates route like "/wpBlogVueFrameWork#/details/3"
            }, 
		}
		
	}
</script>

<style scoped>
    .small  {font-size: 0.3em;}	
    .my-btn { padding:0.5em; font-size: 0.8em; }
</style>


<!-- Just a Lorem Ipsum template-->
<template>
	<div class="services">
	    <my-personal-page/>	
	</div>
</template>
<script>
//using other sub-component 
import startPage from './LoginRegister/auth-start-page.vue';
	export default{
		name:'My page',
		components: {
          'my-personal-page' : startPage,
        },
		data (){
			return{
				title:'Services'
			}
		}
	}
</script>
<style scoped>
</style>

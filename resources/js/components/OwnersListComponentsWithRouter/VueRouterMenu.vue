<!-- Vue-Router Main menu with Links -->

<template>
    <div id="appDemo">
        <!--- Menu Variant 3 --->
        <nav class="navbar navbar-expand-lg navbar-light bg-light" > <!-- fix for BS 4+--> <!-- .fix-for-non-working-click-in-mobile is a fix for non-working click in mobile -->
            <ul class="nav navbar-nav">
				
				 <li class="nav-item">
                    <router-link class="nav-link" to="/my-page"> My page </router-link>
                </li>
				
                <li class="nav-item">
                    <router-link class="nav-link" to="/contact"> Contact </router-link>
                </li>
				
                <li class="nav-item">
                    <router-link class="nav-link" to="/services"> Services </router-link>
                </li>
				
				<li class="nav-item">
                    <router-link class="nav-link" to="/owners-list"> Owners List<span style="font-size:0.6em;">(open route)</span> </router-link>
                </li>
				
				<li class="nav-item">
                    <router-link class="nav-link" to="/quantity-protected"> Protected by Passport <span style="font-size:0.6em;">route </span></router-link>
                </li>
                
            </ul>
        </nav>
	    <!--- End Menu Variant 3 --->
		
	  
	    <!------ Shows the rendered page (home, services, etc) based on selected menu item. Uses animation ------>
        <div class="col-sm-12 col-xs-12 container ">
            <transition name="moveInUp">
                <router-view/> <!-- built-in Vue component -->
            </transition>
        </div>
	    <!------ End Shows the rendered page (home, services, etc) based on selected menu item ------>
    
    </div>
</template>

<script>
    export default {
        name: 'RouterCompon',
        //props: ['currentUser', 'categoriesxx'],
        
        //before mount
        beforeMount() {            
        },
    }
</script>


<style>
/* mine */
.nav-item     {margin-left:2em; }
.nav-item a   {color:black;}
.navbar-brand {color:black}

#appDemo {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 20px;
}
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
</style>
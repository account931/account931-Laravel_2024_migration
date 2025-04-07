import Vue from 'vue';
import Router from 'vue-router';
import my_info_page from  '../components/OwnersListComponentsWithRouter/pages/my-page';
import services     from  '../components/OwnersListComponentsWithRouter/pages/services';
import contact      from  '../components/OwnersListComponentsWithRouter/pages/contact';
import owners_list  from  '../components/OwnersListComponentsWithRouter/pages/owners-list';
import detailsInfo  from  '../components/OwnersListComponentsWithRouter/pages/details-info';
import quantity_pr  from  '../components/OwnersListComponentsWithRouter/pages/quantity-protected';
import register     from  '../components/OwnersListComponentsWithRouter/pages/LoginRegister/subcomponents/register';

import loginPage from  '../components/OwnersListComponentsWithRouter/pages/LoginRegister/auth-start-page';
//import loadNew1 from  '../components/pages/loadnew';

Vue.use(Router);
export default new Router({ 
  routes: [
      {
      path: '/my-page',
      name: 'my-info-page', 
      component: my_info_page,  
    },
	
    {
      path: '/',
      name: 'my-info-page', 
      component: my_info_page,  
    },
	
	//register page , login goes inside my_info_page
	{
      path: '/register-api',
      name: 'register-path', 
      component: register,  
    },
	
	
    
    {
      path: '/services',
      name: 'services',
      component: services
    },
    {
      path: '/contact',
      name: 'contact',
      component: contact
    },
    
    {
      path: '/owners-list', 
      name: 'owners-list',      //same as in component return section
      component: owners_list,  //component itself
    },
    
    //Blog/Owner One item Routing
    {
      path: '/details-info/:Pidd', 
      name: 'details-info', 
      component: detailsInfo 
    },
    
    {
      path: '/login-reg', 
      name: 'login-reg', 
      component: loginPage 
    },
	
	{
      path: '/quantity-protected', 
      name: 'quantity-protected', 
      component: quantity_pr 
    },
	
	
  ]
})
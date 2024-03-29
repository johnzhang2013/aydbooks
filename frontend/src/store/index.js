import Vue from 'vue'
import Vuex from 'vuex';
Vue.use(Vuex);

let u_name = localStorage.getItem('u_name');
let u_email = localStorage.getItem('u_email');
let u_pwd = localStorage.getItem('u_password');
let u_gt = localStorage.getItem('u_gt');
let u_rm = localStorage.getItem('u_rememberme');
let u_lang = localStorage.getItem('u_lang');

//Create a Store instance
const store = new Vuex.Store({
	state: {
		u_lang: u_lang ? u_lang : 'en',
		u_name: u_name ? u_name : null,
		u_email: u_email ? u_email : null,
		u_pwd: u_pwd ? u_pwd : null,
		u_gt: u_gt ? u_gt : null,
		u_rm: u_rm ? u_rm : null,
	},
	getters(){
	  
	},
	mutations: {
		setLanguage (state, lang) {
			state.language = lang;
			
			localStorage.setItem('u_lang', lang);			
		},
		
		setLoginUserInfo (state, userData) {
			state.u_name = userData.u_name;
			localStorage.setItem('u_name', userData.user_name);
			localStorage.setItem('u_token', userData.user_token);
		},
		
		setLoginRole (state, loginRoleData){
			state.u_gt = loginRoleData.gt;
			localStorage.setItem('u_gt', loginRoleData.gt);
		},
		
		setRememberLogin (state, loginData){
			if(loginData.hasOwnProperty('email')){
				state.u_email = loginData.email;
				localStorage.setItem('u_email', loginData.email);
			}
			
			if(loginData.hasOwnProperty('password')){
				state.u_pwd = loginData.password;
				localStorage.setItem('u_password', loginData.password);
			}
				
			if(loginData.hasOwnProperty('remember_me')){
				state.u_rm = loginData.remember_me;
				localStorage.setItem('u_rememberme', loginData.remember_me);
			}
		},
		
		clearLoginCredentials (state){
			state.u_name = null;
			state.u_email = null;
			state.u_pwd = null;
			state.u_rm = null;
			
			localStorage.removeItem('u_name');
			localStorage.removeItem('u_email');
			localStorage.removeItem('u_password');
			localStorage.removeItem('u_rememberme');
		},
		
		logOut (state) {
			const u_rm = localStorage.getItem('u_rememberme');
			if(u_rm == null || !Boolean(u_rm)){
				localStorage.removeItem('u_gt');
			}
			
			localStorage.removeItem('u_name');
			localStorage.removeItem('u_token');
		}
	},
	actions: {
		setLanguage (context, lang) {
			context.commit('setLanguage', lang);
		},
		
		//save something related with login credentials
		afterLoginAction (context, userData) {
			context.commit('setLoginUserInfo', userData);
		},
		
		//clear something related with login credentials
		afterLogoutAction(context){
			context.commit('logOut');
		},
		
		//restore something related with login credentials
		yesRememberLoginAction(context, loginData){
			context.commit('setRememberLogin', loginData);
		},
		
		//remove something related with login credentials
		noRememberLoginAction(context){
			context.commit('clearLoginCredentials');
		},
		
		//set the login role as it is required when it logs out
		setLoginRoleAction(context, loginRoleData) {
			context.commit('setLoginRole', loginRoleData); 
		}
    }
})
export default store
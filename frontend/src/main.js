import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './route';
import store from './store';

import App from './App.vue';

import ElementUI from 'element-ui';
import "@/assets/styles/index.scss"; // global css
import "@/assets/styles/ruoyi.scss"; // ruoyi css
import "./assets/styles/element-variables.scss";
import "./assets/icons"; // icon

import i18n from './langs';

import httpapi from './api/api.js';
import layout from './components/layout.vue';

Vue.prototype.$httpapi = httpapi;

Vue.use(VueRouter);
Vue.use(ElementUI);
Vue.component('layout', layout);

const router = new VueRouter({
	routes
});

const whiteList = ["/", "/login", "/uploadimg", "/pdfmerge"];
router.beforeEach((to, from, next) => {
	if (whiteList.indexOf(to.path) !== -1) {//no need to auth the vistor for the page in the whitelist
		next();
	} else {
		let token = window.localStorage.getItem('u_token');
		if (token) {//check if logged
			if (to.path === '/login') {//No need to login again as you've logged in.
				next('/');
			} else {//move next
				next();
			}
		} else {//not logged
			next('/login');	
		}	
	}
});

Vue.config.productionTip = false

new Vue({
  router,
  store,
  i18n,
  layout,
  render: h => h(App),
}).$mount('#app')

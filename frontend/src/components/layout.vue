<template>
	<div class="app app-header-fixed app-aside-fixed">		
		<AppHeader />
		<AppSidebar />
		<div class="app-content-wrap">
			<div class="view-content">
				<slot></slot>
			</div>
		</div>
	</div>	
</template>

<script>
import AppHeader from '../components/header'
import AppSidebar from '../components/sidebar'

export default {
	name: 'layout',
	components: {
	  AppHeader,
	  AppSidebar
	},
	data (){
		return {
			isLogged: false,
			uName: null
		}
	},
	created(){
		let u_name = this.$store.state.u_name;
		if(u_name){
			this.isLogged = true;
			this.uName = u_name;
		}
	},
	methods: {
		doLogout(){
			this.$store.dispatch('beforeLogoutAction').then(() => {
				this.$router.push({ path: '/login' });
			}).catch(err => {
				this.$message.error(err);
			});
		},
	}
}
</script>

<style>
	body{
		font-family: Helvetica Neue,Helvetica,Arial,sans-serif;
		font-size: 13px;
		-webkit-font-smoothing: antialiased;
		line-height: 1.42857143;
		color: #000;
		overflow: hidden;
		background-color: #fff;
		width: 100%;
		height: 100%;
		display: block;
		margin: 8px;
		overflow-y: auto!important;
	}
	body, h3, h4, li, p, ul {
	    margin: 0;
	    padding: 0;
	}
	.app {
	    position: relative;
	    width: 100%;
	    height: 100%;
	}
	.app-content-wrap {
	    background: #fff;
	    transition: padding-left .28s ease-in-out;
	    width: 100%;
	    padding-left: 180px;
	    box-sizing: border-box;
	    height: 100%;
	    position: absolute;
	    left: 0;
	    right: 0;
	    top: 0;
	    bottom: 0;
	    padding-top: 50px;
	}
	.app-content-wrap .view-content {
	    background: #fff;
	    height: 100%;
	    position: relative;
	}
</style>
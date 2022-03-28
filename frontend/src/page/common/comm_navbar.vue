<template>
	<div class="profile_entry">
		<div v-if="islogged">
			<span>{{ this.$t('navbar.greeting') }}, {{ this.uName }}  </span>
			<router-link :to="this.linkTo">{{ this.linkText }}</router-link>
		</div>
		<div v-else>
			<router-link :to="this.linkTo">{{ this.linkText }}</router-link>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'CommonNavBar',
		props:["workfor"],
		data() {
			return {
				islogged: false,
				isAdmin: false,
				uName: null,
				linkTo: null,
				linkText: null
			}
		},
		
		mounted(){
			this.checkAppLoginStatus();
			this.setNavbarToLink();
		},
		
		methods: {
			checkAppLoginStatus(){
				let u_token = window.localStorage.getItem('u_token');
				if(u_token){
					this.islogged = true;
					this.uName = window.localStorage.getItem('u_name');
					this.isAdmin = (window.localStorage.getItem('u_gt') == 'admin') ? true : false;
				}else{
					this.islogged = false;
				}
			},
			setNavbarToLink(){
				if(this.workfor == 'home'){
					if(this.islogged){
						if(this.isAdmin){
							this.linkTo = 'dashboard';
							this.linkText = this.$t('navbar.admin_dashboard');
						}else{
							this.linkTo = 'profile';
							this.linkText = this.$t('navbar.user_profile');
						}
					}else{
						this.linkTo = 'login';
						this.linkText = this.$t('navbar.login');
					}
				}else{
					this.linkTo = '/';
					this.linkText = this.$t('navbar.home');
				}
			}
		}		
	}
</script>

<style>
</style>

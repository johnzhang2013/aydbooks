<template>
	<div class="profile_entry">		
		<div v-if="islogged" class="job_entry">
			<router-link :to="this.linkTo"><i class="el-icon-s-tools"></i> {{ this.linkText }}</router-link> |
			<span class="logout_span" @click="doLogout"> {{ this.logOut }}</span> |
		</div>
		<div v-else class="job_entry">
			<router-link :to="this.linkTo">{{ this.linkText }}</router-link> |
		</div>
		<div class="navbar_uploadimg">
			<router-link to="/uploadimg">{{ this.$t('navbar.upload_img') }}<i class="el-icon-upload el-icon--righ"></i></router-link> |
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
				linkText: null,
				logOut: this.$t('navbar.logout')
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
			},
			
			doLogout() {
				this.$store.dispatch('beforeLogoutAction').then(() => {
					if(this.workfor == 'home'){
						this.linkTo = 'login';
						this.linkText = this.$t('navbar.login');
						this.islogged = false;
					}else{
						this.$router.replace('/');
					}
				});
			}
		}		
	}
</script>

<style>
	.profile_entry{
		color:#ffaa00;
		font-weight: bold;
	}
	.navbar_uploadimg {
		float:right;
		padding:5px 20px 0 0;
	}
	.job_entry {
		float:left;
		padding:5px 10px 0 0;
	}
	.logout_span {
		margin-bottom:20px;
		cursor:pointer;
	}
</style>

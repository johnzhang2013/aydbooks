<template>
	<div class="login_page">
		<div class="login_languge_switcher">
			<LanguageSwitcher></LanguageSwitcher>
		</div>
			<div class="login_panel">		
			<el-form ref="loginForm" :model="loginForm" :rules="loginRules" class="login-form">
				<h3 class="title">{{ title }}</h3>
				<el-form-item prop="email">
					<el-input v-model="loginForm.email" type="text" prefix-icon="el-icon-s-check"  auto-complete="off" placeholder="Email" clearable></el-input>
				</el-form-item>
				<el-form-item prop="password">
					<el-input v-model="loginForm.password" auto-complete="off" prefix-icon="el-icon-lock"  show-password  placeholder="Password" @keyup.enter.native="handleLogin"></el-input>
				</el-form-item>
				<el-form-item prop="gt" label="Login as">
					<el-radio v-model="loginForm.gt" label="admin">Librarian</el-radio>
					<el-radio v-model="loginForm.gt" label="user">User</el-radio>
				</el-form-item>
				<el-form-item prop="remember_me">
					<el-checkbox v-model="loginForm.remember_me" style="float:left;">Remember Me</el-checkbox>
					<!--<el-link type="primary" style="float:right;" href="/#/register">Not a member yet?<i class="el-icon-s-custom el-icon--right"></i></el-link>-->
				</el-form-item>
				<el-form-item>
					<el-button :loading="loading" size="medium" type="primary" style="width:100%;" @click.native.prevent="handleLogin">
						<span v-if="!loading">Log in</span>
						<span v-else>Try to Log in...</span>
					</el-button>
				</el-form-item>
			</el-form>
			<div class="el-login-footer">
				<span>Copyright@2022 AYDbook.twsbay.com All Rights Reserved.</span>
			</div>
		</div>
	</div>
</template>

<script>
import {decrypt, encrypt} from "@/utils/jsencrypt";
import LanguageSwitcher from "../../components/languages.vue";
import md5 from "js-md5";
export default {
	components: {LanguageSwitcher},
	data(){
		var validateEmail = (rule, value ,callback) => {
			const reg_email = /^[a-z0-9](?:[-_.+]?[a-z0-9]+)*@[a-zA-z0-9]+\.[a-zA-Z]{1,3}$/i;
			if (!reg_email.test(value.trim())) {
				callback(new Error('Email-address is invalid'));
			} else {
				callback();
			}
		};
		var validatePass = (rule, value, callback) => {
			if (value.length < 6) {
				callback(new Error('You must input 6 chars at least'));
			} else {
				callback();
			}
		};
		
		return{
			title: 'AYD Book Login',
			loading: false,
			loginForm: {
				email: '',
				password: '',
				gt: "",
				remember_me: false
			},
			loginRules: {
				email: [
					{validator: validateEmail, trigger: 'blur'}
				],
				password: [
					{validator: validatePass, trigger: 'blur'}
				],
				gt:[
					{required: true, message:' '}
				]
			}
		}
	},
	created(){
		//To do something after the page created
		this.initRememberMe();
	},
	methods:{
		handleLogin() {
			//submit the login request only after the form passed through the validation
			this.$refs.loginForm.validate((valid) => {
				if (valid) {
					this.loading = true;
					
					this.doLogin();
				} else {
					this.$message('Some of your credentials are missed.');
					this.loading = false;
					return false;
				}
			});
		},
		
		resetForm(form) {
			this.$refs[form].resetFields();
		},
		
		initRememberMe() {
			const email = this.$store.state.u_email;
			const password = this.$store.state.u_pwd;
			const gt = this.$store.state.u_gt;
			const remember_me = this.$store.state.u_rm;
			
			this.loginForm = {
				email: (email === null) ? this.loginForm.email : email,
				password: (password === null) ? this.loginForm.password : decrypt(password),
				gt: (gt === null) ? this.loginForm.gt : gt,
				remember_me: (remember_me === null) ? false : Boolean(remember_me)
			};
		},
		
		doLogin(){
			this.$httpapi.post(
				'api/backend/login',
				{
					'email': this.loginForm.email,
					'password': md5(this.loginForm.password),//we md5 the password for security
					'gt': this.loginForm.gt//login role
				},
				(res)=>{
					if(res.status == true && res.code == 200){
						//finish the remember me feature only after you log in successfully
						this.doRememberMe();
						
						//also save the access token after you log in successfully
						this.$store.dispatch('afterLoginAction', res.data).then(() => {
							if(this.loginForm.gt == 'admin'){//you are logged in as an admin then it goes to member manage page
								this.$router.replace('/dashboard');
							}else{//you are logged in as a member then it goes to the member profile page
								this.$router.replace('/user');
							}
						});
					}else{
						this.loading = false;
						this.$message('[' + res.code +'] ' + res.msg);
					}
				},
				(error) => {
					this.loading = false;
					this.$message(error);
				}
			);
		},
	
		doRememberMe(){
			if (this.loginForm.remember_me) {
				const login_data = {
					email: this.loginForm.email,
					password: encrypt(this.loginForm.password),
					gt: this.loginForm.gt,
					remember_me: this.loginForm.remember_me
				};
				this.$store.dispatch('yesRememberLoginAction', login_data);
			} else {
				this.$store.dispatch('noRememberLoginAction');
			}
		}
	}
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
	.login_page {
		height: 100%;
		background-image: url("../../assets/images/login-background.jpg");
		background-size: cover;
	}
	.login_panel {
		display: flex;
		justify-content: center;
		align-items: center;
		margin:0 auto;
		height: 90%;
	}
	.title {
		margin: 0px auto 30px auto;
		text-align: center;
		color: #707070;
	}

	.login-form {
		border-radius: 6px;
		background: #ffffff;
		width: 400px;
		padding: 25px 25px 5px 25px;
		.el-input {
			height: 38px;
			input {
				height: 38px;
			}
		}
		.input-icon {
			height: 39px;
			width: 14px;
			margin-left: 2px;
		}
	}
	.login-tip {
		font-size: 13px;
		text-align: center;
		color: #bfbfbf;
	}
	.login-code {
		width: 33%;
		height: 38px;
		float: right;
		img {
			cursor: pointer;
			vertical-align: middle;
		}
	}
	.el-login-footer {
		height: 40px;
		line-height: 40px;
		position: fixed;
		bottom: 0;
		width: 100%;
		text-align: center;
		color: #fff;
		font-family: Arial;
		font-size: 12px;
		letter-spacing: 1px;
	}
	.login-code-img {
		height: 38px;
	}
	
	.login_languge_switcher {
		position: relative;
		float: right;
		height: 10%;
		width:100px;
		margin:10px 20px 0 0;
	}
	.login_languge_switcher .el-dropdown-link {
		cursor: pointer;
		color: #ffffff!important;
	}
</style>
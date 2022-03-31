<template>
	<div class="profile_page">
		<div class="login_languge_switcher">
			<LanguageSwitcher></LanguageSwitcher>
		</div>
		<div class="common_nav_bar">
			<CommonNavBar :workfor="page_name"></CommonNavBar>
		</div>
		<div class="profile_container">
			<h1 style="text-align: center;">{{ this.$t('pages.home.title') }}</h1>
			<el-divider />
			<el-tabs v-model="active_tab"  type="border-card" tab-position="left" @tab-click="handleTabClick">
			    <el-tab-pane :label="lang_texts.user_profile" name="profile">
					<UserProfile></UserProfile>
				</el-tab-pane>
			    <el-tab-pane :label="lang_texts.user_brr" name="bbr">
					<UserBRR></UserBRR>
				</el-tab-pane>
			    <el-tab-pane :label="lang_texts.user_pwd" name="pwd">
					<UserPwd></UserPwd>
				</el-tab-pane>
			</el-tabs>
		</div>
	</div>	
</template>

<script>
	import LanguageSwitcher from "../../components/languages.vue";
	import CommonNavBar from "../common/comm_navbar.vue";
	import UserProfile from "./user_profile.vue";
	import UserBRR from "./user_brr.vue";
	import UserPwd from "./user_pwd.vue";
	export default {
		components:{LanguageSwitcher, CommonNavBar, UserProfile, UserBRR, UserPwd},
		data() {
			return {
				page_name: 'user_prifile',
				active_tab: 'profile',
				lang_texts: {
					user_profile: this.$t('pages.profile.tab_profile'),
					user_brr: this.$t('pages.profile.tab_brr'),
					user_pwd: this.$t('pages.profile.tab_pwd')
				}
			}
		},
		methods: {
			handleTabClick(tab, event) {
				this.active_tab = tab.name;
			}
		}
	}
</script>

<style>
	.profile_container{
		padding: 20px;
		box-sizing: border-box;
	}
	.common_nav_bar{
		position: relative;
		float: right;
		height: 10%;
		margin:12px 0 0 0px;
		padding-right:20px;
	}
	.login_languge_switcher {
		position: relative;
		float: right;
		height: 10%;
		width:100px;
		margin:15px 20px 0 0;
	}
	.login_languge_switcher .el-dropdown-link {
		cursor: pointer;
		color: #000000!important;
	}
</style>
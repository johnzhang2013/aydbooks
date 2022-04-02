<template>
	<div class="app-header navbar">
		<div class="navbar-header bg-dark">
			<span class="xheader_logo">AYD Books</span>
		</div>
		<div class="login_languge_switcher">
			<LanguageSwitcher></LanguageSwitcher>
		</div>
		<div class="common_nav_bar">
			<CommonNavBar :workfor="page_name"></CommonNavBar>
		</div>
		<el-divider class="header_divider"></el-divider>
	</div>
	
</template>

<script>
	import LanguageSwitcher from "./languages.vue";
	import CommonNavBar from "../page/common/comm_navbar.vue";
	export default {
		name: 'admin_header',
		components: { LanguageSwitcher,	CommonNavBar},
		data() {
			return {
				page_name: 'admin_header'
			}
		}
	}
</script>

<style>
	.app-header-fixed .app-header {
	    position: fixed;
	    top: 0;
	    width: 100%;
	    z-index: 1025;
	}
	.navbar-header {
	    width: 180px;
		left: 0px;
	}
	.header_divider {
		margin-top:50px;
		background-color:#ffaa00;
	}
	.bg-dark {
	    color: #a6a8b1;
	    background-color: #1d2b36;
	}
	.app-header .navbar-header {
	    position: fixed;
	    transition: width .28s ease-in-out;
	    height: 50px;
	    overflow: hidden;
	}
	.xheader_logo {
		font-size: 30px;
		text-align: center;
	}
	.xheader_nav {
		margin-left: 20px; 
		font-size: 13px;
	}
	.navbar-collapse {
	    margin-left: 180px;
	    transition: margin-left .28s ease-in-out;
	    height: 50px;
	    line-height: 30px;
	    position: relative;
	    box-shadow: 0 2px 12px #d1d4d7;
	}
	.leon-ul {
	    float: right;
	}
	.leon-ul li {
	    display: inline-block;
	    color: #777;
	    list-style: none;
	    padding: 0 25px;
	}
	.leon-ul li a {
	    display: block;
	    font-size: 14px;
	    color: #333744;
	}
	.el-dropdown-link {
		cursor: pointer;
		color: #409EFF;
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

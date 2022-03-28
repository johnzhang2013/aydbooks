<template>
	<div class="app-header navbar">
		<div class="navbar-header bg-dark">
			<span class="xheader_logo">AYD Books</span>
		</div>
		<div class="navbar-collapse bg-white-only">
			<div class="xheader_nav">
				<ul class="leon-ul">
					<li class="acc-li">
						<a href="javascript:void(0);">Logout</a>					
					</li>
					<li>
						<LanguageSwitcher></LanguageSwitcher>
					</li>
				</ul>
			</div>
		</div>
	</div>
</template>

<script>
	import LanguageSwitcher from "./languages.vue";
	export default {
		name: 'header',	
		components: {
			LanguageSwitcher
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
</style>

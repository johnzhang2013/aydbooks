<template>
	<div class="app-aside-nav bg-dark">
		<div class="aside-nav-wrap bg-dark">
			<div class="navigation-wrap">
				<div class="collapse-block">
					<i aria-hidden="true" class="fa fa-bars"></i>
				</div>
				<div class="navigation-content">
					<ul>
						<li class="topNav">
							<p>
								<span :title="lang_texts.menus.dashboard"><a href="/#/dashboard">{{ this.lang_texts.menus.dashboard}}</a></span>
							</p>
						</li>
						<li class="topNav">
							<p>
								<span :title="lang_texts.menus.member"><a href="/#/members">{{this.lang_texts.menus.member}}</a></span>
							</p>
						</li>
						<li class="topNav">
							<p>
								<span :title="lang_texts.menus.books_title">{{this.lang_texts.menus.books_title}}</span>
							</p>
							<ul>
								<li class="secondNav">
									<p>
										<i class="menu menu-1_1" style="margin-right: 8px;"></i>
										<span :title="lang_texts.menus.books_author"><a href="/#/authors">{{this.lang_texts.menus.books_author}}</a></span>
									</p>
								</li>
								<li class="secondNav">
									<p>
										<i class="menu menu-1_2" style="margin-right: 8px;"></i>
										<span :title="lang_texts.menus.books_cates"><a href="/#/bookcategory">{{this.lang_texts.menus.books_cates}}</a></span>
									</p>
								</li>
								<li class="secondNav">
									<p>
										<i class="menu menu-1_3" style="margin-right: 8px;"></i> 
										<span :title="lang_texts.menus.books_book"><a href="/#/books">{{this.lang_texts.menus.books_book}}</a></span>
									</p>
								</li>
							</ul>
						</li>
						<li class="topNav">
							<p>
								<span :title="lang_texts.menus.brr_title">{{lang_texts.menus.brr_title}}</span><i class="fa fa-caret-down"></i>
							</p>
							<ul>
								<li class="secondNav">
									<p>
										<i class="menu menu-2_1" style="margin-right: 8px;"></i>
										<span :title="lang_texts.menus.brr_records"><a href="/#/brr_records">{{lang_texts.menus.brr_records}}</a></span>
									</p>
								</li>
								<li class="secondNav">
									<p>
										<i class="menu menu-2_2" style="margin-right: 8px;"></i>
										<span :title="lang_texts.menus.brr_stats"<a href="/#/brr_stats">{{lang_texts.menus.brr_stats}}</a></span>
									</p>
								</li>
								<li class="secondNav">
									<p>
										<i class="menu menu-2_3" style="margin-right: 8px;"></i>
										<span :title="lang_texts.menus.brr_return"<a href="/#/brr_return">{{lang_texts.menus.brr_return}}</a></span>
									</p>
								</li>
							</ul>
						</li>						
					</ul>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				lang_texts: {
					menus: {
						dashboard: this.$t('pages.common.admin_menus.dashboard'),
						member: this.$t('pages.common.admin_menus.member'),
						books_title: this.$t('pages.common.admin_menus.books.title'),
						books_author: this.$t('pages.common.admin_menus.books.author'),
						books_cates: this.$t('pages.common.admin_menus.books.category'),
						books_book: this.$t('pages.common.admin_menus.books.book'),
						brr_title: this.$t('pages.common.admin_menus.bbr.title'),
						brr_records: this.$t('pages.common.admin_menus.bbr.records'),
						brr_stats: this.$t('pages.common.admin_menus.bbr.stats'),
						brr_return: this.$t('pages.common.admin_menus.bbr.return'),
					}
				}
			}
		}
	}
</script>

<style scoped>
	.app-aside-nav {
	    top: 50px;
	    left: 0;
	    bottom: 0;
	    position: fixed;
	    overflow-x: hidden;
	    width: 180px;
	    transition: width .28s ease-in-out;
	    z-index: 1000;
	}
	.aside-nav-wrap {
	    width: 100%;
	    height: 100%;
	}
	.navigation-wrap{
	    height: 100%;
	    color: #fff;
	    font-size: 14px;
	}
	.navigation-wrap .collapse-block{
	    height: 40px;
	    color: #fff;
	    text-align: center;
	    line-height: 40px;
	    background-color: #263947;
	    cursor: pointer;
	}
	.navigation-content {
	    height: calc(100% - 40px);
	    background-color: #1d2b36;
	    width: 197px;
	    overflow-y: scroll;
	}
	.navigation-content .topNav a {
	    border-bottom: 2px;
	    cursor: pointer;
	}
	.navigation-content .topNav > p {
	    line-height: 48px;
	    padding-left: 16px;
	    font-size: 12px;
	    color: #a1b2bf;
	    padding-right: 16px;
	}
	.navigation-content .secondNav a {
	    cursor: pointer;
	    color: #adbece;
	}
	.navigation-content .secondNav > p {
	    line-height: 40px;
	    font-size: 12px;
	    padding-left: 22px;
	    padding-right: 16px;
	}
	.menu {
	    background-repeat: no-repeat;
	    display: inline-block;
	    vertical-align: middle;
	}
	.menu-1_1 {
	    width: 16px;
	    height: 16px;
	    background: url(../assets/icons/menunav.png) -10px -154px;
	}
	.menu-1_2 {
	    width: 16px;
	    height: 16px;
	    background: url(../assets/icons/menunav.png) -82px -226px;
	}
	.menu-1_3 {
	    width: 16px;
	    height: 16px;
	    background: url(../assets/icons/menunav.png)  -46px -226px;
	}
	.menu-2_1 {
	    width: 16px;
	    height: 16px;
	    background: url(../assets/icons/menunav.png) -46px -190px;
	}
	.menu-2_2 {
	    width: 16px;
	    height: 16px;
	    background: url(../assets/icons/menunav.png) -154px -10px;
	}
	.menu-2_3 {
	    width: 16px;
	    height: 16px;
	    background: url(../assets/icons/menunav.png) -190px -226px;
	}
</style>

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
								<span title="Dashboard"><a href="/#/dashboard">Dashboard</a></span>
							</p>
						</li>
						<li class="topNav">
							<p>
								<span title="Members"><a href="/#/members">Members</a></span>
							</p>
						</li>
						<li class="topNav">
							<p>
								<span title="Books">Books</span>
							</p>
							<ul>
								<li class="secondNav">
									<p>
										<i class="menu menu-1_1" style="margin-right: 8px;"></i>
										<span title="Authors"><a href="/#/authors">Authors</a></span>
									</p>
								</li>
								<li class="secondNav">
									<p>
										<i class="menu menu-1_2" style="margin-right: 8px;"></i>
										<span title="Book Categor"><a href="/#/bookcategory">Book Category</a></span>
									</p>
								</li>
								<li class="secondNav">
									<p>
										<i class="menu menu-1_3" style="margin-right: 8px;"></i> 
										<span title="Books"><a href="/#/books">Books</a></span>
									</p>
								</li>
							</ul>
						</li>
						<li class="topNav">
							<p>
								<span title="Borrows and Return">Borrows and Returns</span><i class="fa fa-caret-down"></i>
							</p>
							<ul>
								<li class="secondNav">
									<p>
										<i class="menu menu-2_1" style="margin-right: 8px;"></i>
										<span title="Borrows"><a href="/#/borrows">Borrow Records</a></span>
									</p>
								</li>
								<li class="secondNav">
									<p>
										<i class="menu menu-2_2" style="margin-right: 8px;"></i>
										<span title="Statistics"<a href="/#/borrows_stats">Statistics</a></span>
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
	.navigation-content .topNav {
	    border-bottom: 2px solid #131d24;
	    cursor: pointer;
	}
	.navigation-content .topNav > p {
	    line-height: 48px;
	    padding-left: 16px;
	    font-size: 12px;
	    color: #a1b2bf;
	    padding-right: 16px;
	}
	.navigation-content .secondNav {
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
	    background-image: url(../assets/icons/menunav.png);
	    background-repeat: no-repeat;
	    display: inline-block;
	    vertical-align: middle;
	}
	.menu-1_1 {
	    width: 16px;
	    height: 16px;
	    background: url(../assets/icons/menunav.png) -10px -82px;
	}
	.menu-1_2 {
	    width: 16px;
	    height: 16px;
	    background: url(../assets/icons/menunav.png) -84px -46px;
	}
	.menu-1_3 {
	    width: 16px;
	    height: 16px;
	    background: url(../assets/icons/menunav.png)  -46px -226px;
	}
	.menu-2_1 {
	    width: 16px;
	    height: 16px;
	    background: url(../assets/icons/menunav.png) -154px -154px;
	}
	.menu-2_2 {
	    width: 16px;
	    height: 16px;
	    background: url(../assets/icons/menunav.png) -154px -10px;
	}
</style>

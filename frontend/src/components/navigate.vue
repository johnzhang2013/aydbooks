<template>
	<div class="tags-view">
		<div class="scroll-container tags-view-wrapper el-scrollbar">
			<div class="el-scrollbar__wrap" style="margin-bottom: -17px; margin-right: -17px;">
				<div class="el-scrollbar__view" style="position: relative;">
					<div class="scroll-wrapper" style="left: 0px;">
						<ul>
							<li class="router-link-exact-active router-link-active cur">
								<img src="" style="margin-right: 4px; margin-bottom: -1px;" />首页
							</li>
						</ul>
					</div>
					<div class="resize-triggers">
						<div class="expand-trigger">
							<div style="width: 127px; height: 19px;"></div>
						</div>
						<div class="contract-trigger"></div>
					</div>
				</div>
			</div>
			<div class="el-scrollbar__bar is-horizontal">
				<div class="el-scrollbar__thumb" style="transform: translateX(0%);"></div>
			</div>
			<div class="el-scrollbar__bar is-vertical">
				<div class="el-scrollbar__thumb" style="transform: translateY(0%);"></div>
			</div>
		</div>
		<ul class="contextmenu" style="left: 0px; top: 0px; display: none;">
			<li>关闭其他</li>
			<li>关闭所有</li>
		</ul>
	</div>
</template>

<script>
</script>

<style>
</style>

<template>
	<layout>
		<div class="dashboard_page">
			<!--show bookstat -->
			<el-row :gutter="12">
				<el-col :span="24">
					<BookStat></BookStat>
				</el-col>
			</el-row>
			<el-row :gutter="12">
				<el-col :span="24">
					<BookTops></BookTops>
				</el-col>
			</el-row>
		</div>
	</layout>
</template>

<script>
	import BookStat from "./components/dashboard_bookstat.vue";
	import BookTops from "./components/dashboard_booktops.vue";
	export default {
		components: {BookStat, BookTops},
	}
</script>

<style>
	.dashboard_page{
		padding: 0 20px 20px;
		background: #eaedf1;
		
		position: absolute;
		top: 40px;
		left: 0;
		right: 0;
		bottom: 0;
		overflow: auto;
	}
	
	
</style>
<template>
	<div>
		<el-card class="box-card elcard_top" shadow="always">
			<div slot="header" class="clearfix">
				<span>{{ this.$t('pages.dashboard.booktops.book_borrowed_top_title', {topn: this.topn})}}</span>
			</div>
			<div v-for="(t, ti) in top_borrowed_books" :key="ti" class="text item">
				<span class="btitle">{{t.title}}</span>
				<span class="bcount">{{t.count}}</span>
			</div>
		</el-card>
		<el-card class="box-card elcard_top" shadow="always">
			<div slot="header" class="clearfix">
				<span>{{ this.$t('pages.dashboard.booktops.book_overdued_top_title', {topn: this.topn})}}</span>
			</div>
			<div v-for="(t, ti) in top_overdued_books" :key="ti" class="text item">
				<span class="btitle">{{t.title}}</span>
				<span class="bcount">{{t.count}}</span>
			</div>
		</el-card>
		<el-card class="box-card elcard_top" shadow="always">
			<div slot="header" class="clearfix">
				<span>{{ this.$t('pages.dashboard.booktops.bookcate_borrowed_top_title', {topn: this.topn})}}</span>
			</div>
			<div v-for="(t, ti) in top_borrowed_bookcates" :key="ti" class="text item">
				<span class="btitle">{{t.title}}</span>
				<span class="bcount">{{t.count}}</span>
			</div>
		</el-card>
		
		<el-card class="box-card elcard_top" shadow="always">
			<div slot="header" class="clearfix">
				<span>{{ this.$t('pages.dashboard.booktops.bookcate_overdued_top_title', {topn: this.topn})}}</span>
			</div>
			<div v-for="(t, ti) in top_overdued_bookcates" :key="ti" class="text item">
				<span class="btitle">{{t.title}}</span>
				<span class="bcount">{{t.count}}</span>
			</div>
		</el-card>
	</div>
</template>

<script>
	export default {
		name: 'BookTops',
		data() {
			return {
				topn: 10,
				top_borrowed_books: [],
				top_overdued_books: [],
				top_borrowed_bookcates: [],
				top_overdued_bookcates: []
			}
		},
		
		mounted() {
			this.queryBookTops();
		},
		
		methods: {
			queryBookTops() {
				this.$httpapi.get('/api/backend/dashboard/book_tops', {tops: this.topn},
					(res) => {
						if(res.status == true && res.code == 200){
							this.top_borrowed_books = res.data.top_borrowed_books;
							this.top_overdued_books = res.data.top_overdued_books;
							this.top_borrowed_bookcates = res.data.top_borrowed_bookcates;
							this.top_overdued_bookcates = res.data.top_overdued_bookcates;
						}else{
							this.$message(res.msg);
						}
					}
				);
			}
		}
	}
</script>

<style>
	.elcard_top{
		width:25%;
		position:relative;
		float:left;
		padding:5px;
	}
	.btitle{
		float:left;
		position:relative;
	}
	.bcount{
		position:relative;
		float:right;
	}
</style>

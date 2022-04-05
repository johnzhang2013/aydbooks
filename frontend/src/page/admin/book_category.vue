<template>
	<layout>
		<div class="bookcate_container">
			<div v-if="list_data.total == 0">
				<el-empty :description="lang_texts.empty_results"></el-empty>
			</div>
			<div class="bookcate_table" else>
				<el-table :data="list_data.list" style="width: 100%" stripe border
					v-loading="loading"
					:element-loading-text="lang_texts.loading_show_texts"
					element-loading-spinner="el-icon-loading"
					element-loading-background="rgba(238, 236, 226, 0.8)"
				>
					<el-table-column prop="id" :label="lang_texts.id" width="130px"></el-table-column>
					<el-table-column prop="name" :label="lang_texts.category_name" width="400px"></el-table-column>
					<el-table-column prop="books_total" :label="lang_texts.book_total" width="300px"></el-table-column>
					<el-table-column width="300px">
						<template slot="header" slot-scope="scope">
							<el-input v-model="filter.name" size="mini" :placeholder="lang_texts.filter_placeholder" @keyup.native.enter="doBookCateSearch()"/>
						</template>
						<template slot-scope="scope">
							<el-button type="primary" size="small">{{ lang_texts.btn_edit }}</el-button>
							<el-button type="primary" size="small" @click="getCategoryBookList(scope.row)">{{ lang_texts.btn_viewbooks }}</el-button>
						</template>
					</el-table-column>
				</el-table>
				<el-pagination 
					class="bookcate_paginater" 
					background layout="total,sizes,prev,pager,next"  
					@size-change="handlePageSizeChange"
					:page-size="filter.per_page"
					:current-page="filter.curr_page"
					:page="list_data.curr_page"
					:page-sizes="[10, 20, 50]"
					@current-change="changeCurrentPage"
					:total="list_data.total">
				</el-pagination>
			</div>
			<el-dialog :title="category_title" v-if="isShowed" :visible.sync="isShowed" width="70%">
				<CategoryBookList :vfilter="cFilter" vuse="bcates"></CategoryBookList>
			</el-dialog>
		</div>		
	</layout>
</template>

<script>
	import CategoryBookList from '@/page/components/book_list.vue';
	export default {
		components: {CategoryBookList},
		data(){
			return{
				loading: false,
				isShowed: false,
				cFilter: {
					category_id: 0,
				},
				category_title: null,
				lang_texts: {
					loading_show_texts: this.$t('messages.common.loading_show_texts'),
					
					empty_results: this.$t('pages.book_category.empty_results'),
					id: this.$t('pages.book_category.id'),
					category_name: this.$t('pages.book_category.category_name'),
					book_total: this.$t('pages.book_category.book_total'),
					filter_placeholder: this.$t('pages.book_category.filter_placeholder'),
					btn_edit: this.$t('pages.book_category.btn_edit'),
					btn_viewbooks: this.$t('pages.book_category.btn_viewbooks')
				},
				filter: {
					name: '',
					per_page: 10,
					curr_page: 1
				},				
				list_data: {
					total: -1,
					per_page: 10,
					curr_page: 1,
					total_page: 0,
					list: []
				}
			};
		},
		
		mounted(){
			this.getBookCategoriesList();
		},
		
		methods: {
			doBookCateSearch(){
				this.filter.curr_page = 1;
				this.getBookCategoriesList();
			},			
			//request book categories list
			getBookCategoriesList(){
				this.loading = true;
				
				const bookcate_filter = JSON.parse(JSON.stringify(this.filter));
				this.$httpapi.post('/api/backend/bookcate/list', bookcate_filter, 
					(res) => {
						this.loading = false;
						if(res.status == true && res.code == 200){
							this.list_data = res.data;
						}else{
							if(res.code == 404){
								this.list_data = res.data;
							}
							this.$message(res.msg);
						}
					}
				);
			},
			
			//Get book list of a specific category
			getCategoryBookList(category) {
				this.category_title = this.$t('pages.book_category.book_list_title', {category_name: category.name});
				
				this.cFilter.category_id = category.id;
				this.isShowed = true;
			},
			
			//go to the specific page
			changeCurrentPage(e) {
			  this.filter.curr_page = e;
			  this.getBookCategoriesList();
			},
			
			//change the page size of paginate
			handlePageSizeChange(e) {
			  this.filter.curr_page = 1;
			  this.filter.per_page = e;
			  this.getBookCategoriesList();
			},
		}
	}
</script>

<style>
	.bookcate_container{
		padding: 20px;
		box-sizing: border-box;
		margin: 0 auto;
	}
	
	.bookcate_container .filter-form{
		overflow: hidden;
	}
	
	.bookcate_container .filter-form .li{
		float: left;
		min-width: 255px;
		margin-bottom: 20px;
	}
	
	.bookcate_container .el-table .cell {
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis
	}
	
	.li-span {
	  float: left;
	  width: 350px;
	}
	
	.select-with {
	  width: 80px;
	}
	
	.bookcate_table{
		margin:0 auto;
		border:1px solid #d3cece;
		padding: 20px 20px 0 300px;
	}
	.bookcate_paginater{
		margin:20px 0 10px 200px;
	}
</style>
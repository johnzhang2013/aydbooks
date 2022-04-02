<template>
	<layout>
		<div class="books_container">
			<ul class="filter-form">
				<li class="li">
					<span>{{lang_texts.filter.title}}</span>
					<el-input v-model="filter.title" :placeholder="lang_texts.filter.title_placeholder" size="small" class="w160" clearable @keyup.enter.native="doBookSearch"></el-input>
				</li>
				<li class="li">
					<span>{{lang_texts.filter.isbn}}</span>
					<el-input v-model="filter.isbn" :placeholder="lang_texts.filter.isbn_placeholder" size="small" class="w160" clearable @keyup.enter.native="doBookSearch"></el-input>
				</li>
				<li class="li">
					<span>{{lang_texts.filter.onshelf_date}}</span>
					<el-date-picker v-model="filter.onshelf_datetime" type="daterange" clearable unlink-panels 
						:range-separator="lang_texts.filter.onshelf_to" 
						format="yyyy-MM-dd" 
						value-format="yyyy-MM-dd" 
						:start-placeholder="lang_texts.filter.onshelf_start" 
						:end-placeholder="lang_texts.filter.onshelf_end" 
						@change="doBookSearch">
					</el-date-picker>
				</li>
				<li class="li">
					<span>{{lang_texts.filter.author}}</span>
					<el-select v-model="filter.author_id" :placeholder="lang_texts.filter.author_select_default" size="small" @change="doBookSearch">
						<el-option :label="0" :value="lang_texts.filter.all_author"></el-option>
						<el-option v-for="author in sys_authors" :label="author.label" :value="author.value" :key="author.value"></el-option>
					</el-select>
				</li>
				<li class="li">
					<span>{{lang_texts.filter.category}}</span>
					<el-select v-model="filter.category_id" :placeholder="lang_texts.filter.category_select_default" size="small" @change="doBookSearch">
						<el-option :label="0" :value="lang_texts.filter.all_category"></el-option>
						<el-option v-for="category in sys_bookcategories" :label="category.label" :value="category.value" :key="category.value"></el-option>
					</el-select>
				</li>
				<li><el-button icon="el-icon-search" type="success"  size='large' @click.native="doBookSearch"></el-button></li>
			</ul>		
			<div class="books_table">
				<div v-if="list_data.total == 0">
					<el-empty :description="lang_texts.loading_show_texts"></el-empty>
				</div>
				<div else>
					<el-table :data="list_data.list" style="width: 100%" :cell-class-name="lowStockAlert" stripe border
						v-loading="loading"
						:element-loading-text="lang_texts.loading_show_texts"
						element-loading-spinner="el-icon-loading"
						element-loading-background="rgba(238, 236, 226, 0.8)"
					>
						<el-table-column prop="isbn" fixed :label="lang_texts.column.isbn" width="130px"></el-table-column>
						<el-table-column prop="title" :label="lang_texts.column.title" width="500px"></el-table-column>
						<el-table-column prop="author" :label="lang_texts.column.author" width="400px"></el-table-column>
						<el-table-column prop="category" :label="lang_texts.column.category" width="150px"></el-table-column>
						<el-table-column prop="stock" :label="lang_texts.column.stock_qty" width="100px"></el-table-column>
						<el-table-column prop="borrowed_count" :label="lang_texts.column.borrowed_count" width="150px"></el-table-column>
						<el-table-column prop="overdued_count" :label="lang_texts.column.overdued_count" width="150px"></el-table-column>
						<el-table-column prop="onshelf_datetime" :label="lang_texts.column.onshelf_at" width="200px"></el-table-column>
						<el-table-column prop="is_active" :label="lang_texts.column.active" width="100px">
							<template slot-scope="scope">
								<el-switch v-model="scope.row.is_active" active-color="#13ce66" inactive-color="#DCDFE6" :active-value="1" :inactive-value="0" />
							</template>
						</el-table-column>
						<el-table-column :label="lang_texts.column.actions" fixed="right" width="300px">
							<template slot-scope="scope">
								<el-button type="success" icon="el-icon-view" circle :title="lang_texts.column.btn_action_view" @click=""></el-button>
								<el-button type="danger" icon="el-icon-delete" circle :title="lang_texts.column.btn_action_delete" @click=""></el-button>
								<el-button type="primary" icon="el-icon-edit" circle :title="lang_texts.column.btn_action_edit" @click=""></el-button>
								<el-button type="success" icon="el-icon-check" circle :title="lang_texts.column.btn_action_records" @click=""></el-button>
							</template>
						</el-table-column>
					</el-table>
					<el-pagination 
						class="books_paginater" 
						background layout="total,sizes,prev,pager,next"  
						@size-change="handlePageSizeChange"
						:page-size="filter.per_page"
						:current-page="filter.curr_page"
						:page="list_data.curr_page"
						:page-sizes="[10, 20, 50, 80, 100]"
						@current-change="changeCurrentPage"
						:total="list_data.total">
					</el-pagination>
				</div>
			</div>
		</div>
	</layout>
</template>

<script>
	//import BookEntity from "./components/book_entity";
	//import BookBorrowHistory from "./components/book_borrow_history";
	
	export default {
		data(){
			return{
				loading: true,
				lang_texts: {
					loading_show_texts: this.$t('messages.common.loading_show_texts'),
					empty_results: this.$t('pages.books.empty_results'),
					
					filter: {
						isbn: this.$t('pages.books.fliter.isbn'),
						isbn_placeholder: this.$t('pages.books.fliter.isbn_placeholder'),
						title: this.$t('pages.books.fliter.title'),
						title_placeholder: this.$t('pages.books.fliter.title_placeholder'),
						author: this.$t('pages.books.fliter.author'),
						all_author: this.$t('pages.books.fliter.all_author'),
						author_select_default: this.$t('pages.books.fliter.author_select_default'),
						category: this.$t('pages.books.fliter.category'),
						all_category: this.$t('pages.books.fliter.all_category'),
						category_select_default: this.$t('pages.books.fliter.category_select_default'),
						onshelf_date: this.$t('pages.books.fliter.onshelf_date'),
						onshelf_start: this.$t('pages.books.fliter.onshelf_start'),
						onshelf_to: this.$t('pages.books.fliter.onshelf_to'),
						onshelf_end: this.$t('pages.books.fliter.onshelf_end')
					},
					column: {
						isbn: this.$t('pages.books.column.isbn'),
						title: this.$t('pages.books.column.title'),
						author: this.$t('pages.books.column.author'),
						category: this.$t('pages.books.column.category'),
						stock_qty: this.$t('pages.books.column.stock_qty'),
						borrowed_count: this.$t('pages.books.column.borrowed_count'),
						overdued_count: this.$t('pages.books.column.overdued_count'),
						onshelf_at: this.$t('pages.books.column.onshelf_at'),
						active: this.$t('pages.books.column.active'),
						actions: this.$t('pages.books.column.actions'),
						btn_action_view: this.$t('pages.books.column.btn_action_view'),
						btn_action_edit: this.$t('pages.books.column.btn_action_edit'),
						btn_action_delete: this.$t('pages.books.column.btn_action_delete'),
						btn_action_records: this.$t('pages.books.column.btn_action_records'),
					}
				},
				
				filter: {
					isbn: '',
					title: '',
					author_id: '',
					onshelf_datetime: '',
					category_id: '',
					per_page: 10,
					curr_page: 1
				},				
				list_data: {
					total: -1,
					per_page: 10,
					curr_page: 1,
					total_page: 0,
					list: []
				},				
				sys_authors: [],
				sys_bookcategories: []
			};
		},
		
		//components:{BookEntity, BookBorrowHistory},
		
		mounted(){
			this.initBooksBasicOptions();
			this.getBooksList();
		},
		
		methods: {
			lowStockAlert({row, column, rowIndex, columnIndex}) {
				if(columnIndex != 4) return;
			
				if (row.stock <= 5) {
					return 'lsa-lose';
				} else if (row.stock <= 10) {
					return 'lsa-warning';
				}
				return '';
			},
			
			doBookSearch(){
				this.filter.curr_page = 1;
				this.getBooksList();
			},
			
			//request books list
			getBooksList(){
				this.loading = true;
				
				const book_filter = JSON.parse(JSON.stringify(this.filter));
				this.$httpapi.post('/api/backend/book/list', book_filter, 
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
			
			//go to the specific page
			changeCurrentPage(e) {
			  this.filter.curr_page = e;
			  this.getBooksList();
			},
			
			//change the page size of paginate
			handlePageSizeChange(e) {
			  this.filter.curr_page = 1;
			  this.filter.per_page = e;
			  this.getBooksList();
			},
			
			//initialize these book basic options
			initBooksBasicOptions() {
				if(this.$store.state.sys_authors == null || this.$store.state.sys_bookcategories == null){
					this.$httpapi.get(
						'api/backend/book/basics',
						{},
						(res)=>{
							this.sys_authors = res.sys_authors;
							this.sys_bookcategories = res.sys_bookcategories;
							
							//save these static data into state for less backend requests
							this.$store.state.sys_authors = res.sys_authors;
							this.$store.state.sys_bookcategories = res.sys_bookcategories;
						},
						(error) => {}
					);
				}else{//so no need to request the backend for this data frequently
					this.sys_authors = this.$store.state.sys_authors;
					this.sys_bookcategories = this.$store.state.sys_bookcategories;
				}			
			},
		}
	}
</script>

<style>
	.books_container{
		padding: 20px;
		box-sizing: border-box;
	}
	
	.books_container .filter-form{
		overflow: hidden;
	}
	
	.books_container .filter-form .li{
		float: left;
		min-width: 255px;
		margin-bottom: 20px;
	}
	
	.books_container .el-table .cell {
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
	
	.books_table{
		margin:0 auto;
		border:1px solid #d3cece;
	}
	.books_paginater{
		margin:20px 0 10px 600px;
	}
	.book-intro-expand span{
		margin:0 0 0 100px;
	}
	.lsa-lose {
		background-color: #ffaa7f!important;
	}
	.lsa-warning{
		background-color: #ffe8ae!important;
	}
</style>
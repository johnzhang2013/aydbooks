<template>
	<div class="books_page">
		<div class="login_languge_switcher">
			<LanguageSwitcher></LanguageSwitcher>
		</div>
		<div class="books_container">
			<h1 style="text-align: center;">{{ this.$t('pages.home.title') }}</h1>		
			<el-divider />
			<ul class="filter-form">
				<li class="li">
					<span>{{ this.$t('pages.home.filter.title') }}</span>
					<el-input v-model="filter.title" :placeholder="lang_texts.placeholders.title" size="small" class="w160" clearable @keyup.enter.native="doBookSearch"></el-input>
				</li>
				<li class="li">
					<span>{{ this.$t('pages.home.filter.isbn') }}</span>
					<el-input v-model="filter.isbn" :placeholder="lang_texts.placeholders.isbn" size="small" class="w160" clearable @keyup.enter.native="doBookSearch"></el-input>
				</li>
				<li class="li">
					<span>{{ this.$t('pages.home.filter.onshelfdate') }}</span>
					<el-date-picker v-model="filter.onshelf_datetime" type="daterange" clearable unlink-panels 
						range-separator="To" 
						format="yyyy-MM-dd" 
						value-format="yyyy-MM-dd" 
						:start-placeholder="lang_texts.placeholders.date_start" 
						:end-placeholder="lang_texts.placeholders.date_end" 
						@change="doBookSearch">
					</el-date-picker>
				</li>
				<li class="li">
					<span>{{ this.$t('pages.home.filter.authors') }}</span>
					<el-select v-model="filter.author_id" :placeholder="lang_texts.placeholders.author" size="small" @change="doBookSearch">
						<el-option :label="0" value="All"></el-option>
						<el-option v-for="author in sys_authors" :label="author.label" :value="author.value" :key="author.value"></el-option>
					</el-select>
				</li>
				<li class="li">
					<span>{{ this.$t('pages.home.filter.categories') }}</span>
					<el-select v-model="filter.category_id" :placeholder="lang_texts.placeholders.category" size="small" @change="doBookSearch">
						<el-option :label="0" value="All"></el-option>
						<el-option v-for="category in sys_bookcategories" :label="category.label" :value="category.value" :key="category.value"></el-option>
					</el-select>
				</li>
				<li><el-button icon="el-icon-search" type="success"  size='large' @click.native="doBookSearch"></el-button></li>
			</ul>		
			<div class="books_table">
				<div v-if="loading" class="my-loading">
					<i class="el-icon-loading"></i>
				</div>
				<div v-else-if="list_data.total == 0">
					<el-empty :description="lang_texts.empty_results"></el-empty>
				</div>
				<div else>
					<el-table :data="list_data.list" style="width: 100%" :cell-class-name="lowStockAlert" stripe border>
						<el-table-column type="expand">
							<template slot-scope="props">
								<el-form label-position="left" inline class="book-intro-expand">
									<el-form-item>
										<span>{{ props.row.brief_intro }}</span>
									</el-form-item>
								</el-form>
							</template>
						</el-table-column>
						<el-table-column prop="isbn" :label="lang_texts.columns_label.isbn" width="130px"></el-table-column>
						<el-table-column prop="title" :label="lang_texts.columns_label.title" width="500px"></el-table-column>
						<el-table-column prop="author" :label="lang_texts.columns_label.author" width="400px"></el-table-column>
						<el-table-column prop="category" :label="lang_texts.columns_label.category" width="150px"></el-table-column>
						<el-table-column prop="stock" :label="lang_texts.columns_label.stock" width="100px"></el-table-column>
						<el-table-column prop="borrowed_count" :label="lang_texts.columns_label.borrowed_count" width="100px"></el-table-column>
						<el-table-column prop="onshelf_datetime" :label="lang_texts.columns_label.onshelfat" width="200px"></el-table-column>
						<el-table-column :label="lang_texts.columns_label.actions" fixed="right" width="200px">
							<template slot-scope="scope">
								<el-button type="text" size="small">{{ lang_texts.columns_label.btn_borrow }}</el-button>
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
	</div>	
</template>

<script>
	import LanguageSwitcher from "../../components/languages.vue";
	export default {
		components: {LanguageSwitcher},
		
		data(){
			return{
				loading: false,
				lang_texts:{
					empty_results: this.$t('pages.home.list.empty_result'),
					columns_label: {
						isbn: this.$t('pages.home.list.column.isbn'),
						title: this.$t('pages.home.list.column.title'),
						author: this.$t('pages.home.list.column.author'),
						category: this.$t('pages.home.list.column.category'),
						stock: this.$t('pages.home.list.column.stock'),
						borrowed_count: this.$t('pages.home.list.column.borrowed'),
						onshelfat: this.$t('pages.home.list.column.onshelfat'),
						actions: this.$t('pages.home.list.column.actions'),
						btn_borrow: this.$t('pages.home.list.column.btn_borrow')
					},
					placeholders: {
						isbn: this.$t('placeholder.home.filter.isbn'),
						title: this.$t('placeholder.home.filter.title'),
						author: this.$t('placeholder.home.filter.author'),
						category: this.$t('placeholder.home.filter.category'),
						date_start: this.$t('placeholder.home.filter.date_start'),
						date_end: this.$t('placeholder.home.filter.date_end'),
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
					total: 0,
					per_page: 10,
					curr_page: 1,
					total_page: 0,
					list: []
				},				
				sys_authors: [],
				sys_bookcategories: []
			};
		},
		
		mounted(){
			this.initBooksBasicOptions();
			this.getBooksList();
		},
		
		methods: {
			lowStockAlert({row, column, rowIndex, columnIndex}) {
				if(columnIndex != 5) return;

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
				const book_filter = JSON.parse(JSON.stringify(this.filter));
				this.$httpapi.post('/api/frontend/book/list', book_filter, 
					(res) => {
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
						'api/frontend/book/basics',
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
	.books_page{
		
	}
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
	.login_languge_switcher {
		position: relative;
		float: right;
		height: 10%;
		width:100px;
		margin:10px 20px 0 0;
	}
	.login_languge_switcher .el-dropdown-link {
		cursor: pointer;
		color: #000000!important;
	}
</style>
<template>
	<div class="books_page">
		<div class="login_languge_switcher">
			<LanguageSwitcher></LanguageSwitcher>
		</div>
		<div class="common_nav_bar">
			<CommonNavBar :workfor="page_name"></CommonNavBar>
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
				<div v-if="list_data.total == 0">
					<el-empty :description="lang_texts.empty_results"></el-empty>
				</div>
				<div else>
					<el-table :data="list_data.list" style="width: 100%" :cell-class-name="lowStockAlert" stripe border
						v-loading="loading"
						:element-loading-text="lang_texts.loading_show_texts"
						element-loading-spinner="el-icon-loading"
						element-loading-background="rgba(238, 236, 226, 0.8)"
					>
						<el-table-column prop="isbn" fixed :label="lang_texts.columns_label.isbn" width="130px"></el-table-column>
						<el-table-column prop="title" :label="lang_texts.columns_label.title" width="500px"></el-table-column>
						<el-table-column prop="author" :label="lang_texts.columns_label.author" width="400px"></el-table-column>
						<el-table-column prop="category" :label="lang_texts.columns_label.category" width="150px"></el-table-column>
						<el-table-column prop="stock" :label="lang_texts.columns_label.stock" width="100px"></el-table-column>
						<el-table-column prop="borrowed_count" :label="lang_texts.columns_label.borrowed_count" width="100px"></el-table-column>
						<el-table-column prop="onshelf_datetime" :label="lang_texts.columns_label.onshelfat" width="200px"></el-table-column>
						<el-table-column :label="lang_texts.columns_label.actions" fixed="right" width="200px">
							<template slot-scope="scope">
								<el-button type="success" plain size="small" @click="viewBookDetail(scope.row)">{{ lang_texts.columns_label.btn_view }}</el-button>
								<el-button type="primary" size="small" @click="borrowIt(scope.row.isbn)">{{ lang_texts.columns_label.btn_borrow }}</el-button>
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
		<el-dialog :title="lang_texts.book_detail.description_title" :visible.sync="bookdetail_form.visible">
			<el-descriptions class="margin-top" :title="bookdetail_form.title" column="2" size="medium" border labelClassName="bookdetail_label">
			    <el-descriptions-item>
					<template slot="label"><i class="el-icon-mobile-phone"></i>{{lang_texts.book_detail.isbn}}</template>{{bookdetail_form.isbn}}
			    </el-descriptions-item>
			    <el-descriptions-item>
					<template slot="label"><i class="el-icon-user"></i>{{lang_texts.book_detail.author}}</template>{{bookdetail_form.author}}
			    </el-descriptions-item>
			    <el-descriptions-item>
					<template slot="label"><i class="el-icon-location-outline"></i>{{lang_texts.book_detail.category}}</template>{{bookdetail_form.category}}
			    </el-descriptions-item>
				<el-descriptions-item>
					<template slot="label"><i class="el-icon-location-outline"></i>{{lang_texts.book_detail.onshelf_at}}</template>{{bookdetail_form.onshelf_at}}
				</el-descriptions-item>
			    <el-descriptions-item>
					<template slot="label"><i class="el-icon-tickets"></i>{{lang_texts.book_detail.stock}}</template>
					<el-tag size="small">{{bookdetail_form.stock}}</el-tag>
			    </el-descriptions-item>
				<el-descriptions-item>
					<template slot="label"><i class="el-icon-tickets"></i>{{lang_texts.book_detail.borrowed_count}}</template>
					<el-tag size="small">{{bookdetail_form.borrowed_count}}</el-tag>
				</el-descriptions-item>
				
			    <el-descriptions-item>
					<template slot="label"><i class="el-icon-office-building"></i>{{lang_texts.book_detail.intro}}</template>{{bookdetail_form.brief_intro}}
			    </el-descriptions-item>
			</el-descriptions>
			<div slot="footer" class="dialog-footer">
				<el-button  type="primary" @click="bookdetail_form.visible = false">{{lang_texts.book_detail.return}}</el-button>
			</div>
		</el-dialog>
	</div>
</template>

<script>
	import LanguageSwitcher from "../../components/languages.vue";
	import CommonNavBar from "./comm_navbar.vue";
	
	export default {
		components: {LanguageSwitcher, CommonNavBar},
		
		data(){
			return{
				bookdetail_form: {
					visible: false,
					isbn: '',
					title: '',
					brief_intro: '',
					stock: 0,
					category: '',
					author: '',
					onshelf_at: '',
					borrowed_count: 0
				},
				page_name: 'home',
				loading: false,
				lang_texts:{
					loading_show_texts: this.$t('messages.common.loading_show_texts'),
					empty_results: this.$t('pages.home.list.empty_result'),
					columns_label: {
						isbn: this.$t('pages.home.list.column.isbn'),
						title: this.$t('pages.home.list.column.title'),
						author: this.$t('pages.home.list.column.author'),
						category: this.$t('pages.home.list.column.category'),
						stock: this.$t('pages.home.list.column.stock'),
						borrowed_count: this.$t('pages.home.list.column.borrowed'),
						onshelfat: this.$t('pages.home.list.column.onshelf_at'),
						actions: this.$t('pages.home.list.column.actions'),
						btn_borrow: this.$t('pages.home.list.column.btn_borrow'),
						btn_view: this.$t('pages.home.list.column.btn_view')
					},
					placeholders: {
						isbn: this.$t('placeholder.home.filter.isbn'),
						title: this.$t('placeholder.home.filter.title'),
						author: this.$t('placeholder.home.filter.author'),
						category: this.$t('placeholder.home.filter.category'),
						date_start: this.$t('placeholder.home.filter.date_start'),
						date_end: this.$t('placeholder.home.filter.date_end'),
					},
					book_detail: {
						description_title: this.$t('pages.common.entity.book.ele_title'),
						isbn: this.$t('pages.common.entity.book.isbn'),
						title: this.$t('pages.common.entity.book.title'),
						intro: this.$t('pages.common.entity.book.intro'),
						author: this.$t('pages.common.entity.book.author'),
						category: this.$t('pages.common.entity.book.category'),
						stock: this.$t('pages.common.entity.book.stock'),
						borrowed_count: this.$t('pages.common.entity.book.borrowed_count'),
						onshelf_at: this.$t('pages.common.entity.book.onshelf_at'),
						return: this.$t('pages.common.entity.book.return'),
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
			
			viewBookDetail(book) {
				this.bookdetail_form.visible = true;
				this.bookdetail_form.isbn = book.isbn;
				this.bookdetail_form.title = book.title;
				this.bookdetail_form.brief_intro = book.brief_intro;
				this.bookdetail_form.category = book.category;
				this.bookdetail_form.author = book.author;
				this.bookdetail_form.stock = book.stock;
				this.bookdetail_form.borrowed_count = book.borrowed_count;
				this.bookdetail_form.onshelf_at = book.onshelf_datetime;
			},
			
			borrowIt(isbn) {
				//step1 - It requires a normal user to borrow it
				let isLogged = this.checkAppLoginAsUser();
				if(!isLogged){
					this.$message({
						message: this.$t('messages.borrow.not_logged'),
						type: 'warning',
						duration: 2000,//2 seconds
						showClose: true
					});
					return;
				}
				
				this.doBorrowBook(isbn);
			},
			
			checkAppLoginAsUser() {
				let u_token = window.localStorage.getItem('u_token');
				if(u_token) {
					let u_gt = window.localStorage.getItem('u_gt');
					return (u_gt == 'user') ? true : false;
				}else{
					return false;
				}
			},
			
			doBorrowBook(isbn) {
				let can_borrow = false;
				
				this.$httpapi.post(
					'api/frontend/book/borrowit',
					{isbn: isbn},
					(res)=>{
						if(res.status == true && res.code == 200){
							this.$message({
								message: '[' + res.code +'] ' + res.msg,
								type:'success',
								duration: 2000,
								showClose: true
							});
						}else{
							this.$message({
								message: '[' + res.code +'] ' + res.msg,
								type: 'error',
								duration: 2000,//2 seconds
								showClose: true
							});
						}
					},
					(error) => {
						this.$message({
								message: this.$t(error),
								type: 'error',
								duration: 2000,//2 seconds
								showClose: true
						});
					}
				);
				
				return can_borrow;
			},
			
			doBookSearch(){
				this.filter.curr_page = 1;
				this.getBooksList();
			},
			
			//request books list
			getBooksList(){
				this.loading = true;
				
				const book_filter = JSON.parse(JSON.stringify(this.filter));
				this.$httpapi.post('/api/frontend/book/list', book_filter, 
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

	.lsa-lose {
		background-color: #ffaa7f!important;
	}
	.lsa-warning{
		background-color: #ffe8ae!important;
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
	.bookdetail_label {
		width:20%;
		background-color: #0056B3;
	}
</style>
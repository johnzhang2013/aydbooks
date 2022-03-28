<template>
	<layout>
		<div class="books_container">
			<ul class="filter-form">
				<li class="li">
					<span>Title:</span>
					<el-input v-model="filter.title" placeholder="Please input a book title" size="small" class="w160" clearable @keyup.enter.native="doBookSearch"></el-input>
				</li>
				<li class="li">
					<span>ISBN:</span>
					<el-input v-model="filter.isbn" placeholder="Please input a book ISBN" size="small" class="w160" clearable @keyup.enter.native="doBookSearch"></el-input>
				</li>
				<li class="li">
					<span>Onshelf Date Range:</span>
					<el-date-picker v-model="filter.onshelf_datetime" type="daterange" clearable unlink-panels 
						range-separator="To" 
						format="yyyy-MM-dd" 
						value-format="yyyy-MM-dd" 
						start-placeholder="Date Start" 
						end-placeholder="Date End" 
						@change="doBookSearch">
					</el-date-picker>
				</li>
				<li class="li">
					<span>Authors:</span>
					<el-select v-model="filter.author_id" placeholder="Please choose an author" size="small" @change="doBookSearch">
						<el-option :label="0" value="All"></el-option>
						<el-option v-for="author in sys_authors" :label="author.label" :value="author.value" :key="author.value"></el-option>
					</el-select>
				</li>
				<li class="li">
					<span>Category:</span>
					<el-select v-model="filter.category_id" placeholder="Please choose an book category" size="small" @change="doBookSearch">
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
					<el-empty description="There are no books available."></el-empty>
				</div>
				<div else>
					<el-table :data="list_data.list" style="width: 100%" :cell-class-name="lowStockAlert" stripe border>
						<el-table-column type="expand" fixed>
							<template slot-scope="props">
								<el-form label-position="left" inline class="book-intro-expand">
									<el-form-item>
										<span>{{ props.row.brief_intro }}</span>
									</el-form-item>
								</el-form>
							</template>
						</el-table-column>
						<el-table-column prop="isbn" fixed label="ISBN" width="130px"></el-table-column>
						<el-table-column prop="title" label="Title" width="500px"></el-table-column>
						<el-table-column prop="author" label="Author" width="400px"></el-table-column>
						<el-table-column prop="category" label="Category" width="150px"></el-table-column>
						<el-table-column prop="stock" label="StockQty" width="100px"></el-table-column>
						<el-table-column prop="borrowed_count" label="Borrowed" width="100px"></el-table-column>
						<el-table-column prop="onshelf_datetime" label="Onshelf At" width="200px"></el-table-column>
						<el-table-column prop="is_active" label="Active" width="100px">
							<template slot-scope="scope">
								<el-switch v-model="scope.row.is_active" active-color="#13ce66" inactive-color="#DCDFE6" :active-value="1" :inactive-value="0" />
							</template>
						</el-table-column>
						<el-table-column label="Actions" fixed="right" width="300px">
							<template slot-scope="scope">
								<el-button type="danger" icon="el-icon-delete" circle title="Delete" @click="formvisible.book_edit_form = true"></el-button>
								<el-button type="primary" icon="el-icon-edit" circle title="Update" @click=""></el-button>
								<el-button type="success" icon="el-icon-check" circle title="Borrow Records" @click=""></el-button>
								<el-button type="warning" icon="el-icon-star-off" circle title="Overdue Records" @click=""></el-button>
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
		<BookEntity />
		<BookBorrowHistory />
	</layout>
</template>

<script>
	import BookEntity from "./components/book_entity";
	import BookBorrowHistory from "./components/book_borrow_history";
	
	export default {
		data(){
			return{
				loading: false,
				formvisible: {
					book_edit_form: false,
					book_borrow_record_table: false
				},
				formLabelWidth: '120px',
				BookEditForm: {
					name: '',
					region: ''
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
		
		components:{
			BookEntity, 
			BookBorrowHistory
		},
		
		mounted(){
			this.initBooksBasicOptions();
			this.getBooksList();
		},
		
		methods: {
			lowStockAlert({row, column, rowIndex, columnIndex}) {
				if(column.label != 'StockQty') return;
			
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
				this.$httpapi.post('/api/backend/book/list', book_filter, 
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
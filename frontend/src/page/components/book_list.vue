<template>
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
				<el-table-column v-if="isAdmin" prop="overdued_count" :label="lang_texts.column.overdued_count" width="150px"></el-table-column>
				<el-table-column prop="onshelf_datetime" :label="lang_texts.column.onshelf_at" width="200px"></el-table-column>
				<el-table-column prop="is_active" :label="lang_texts.column.active" width="100px">
					<template slot-scope="scope">
						<el-switch :disabled="isSwitcherDisabled" v-model="scope.row.is_active" active-color="#13ce66" inactive-color="#DCDFE6" :active-value="1" :inactive-value="0" />
					</template>
				</el-table-column>
				
				<el-table-column v-if="vuse == 'booksAdmin'" :label="lang_texts.column.actions" fixed="right" width="300px">
					<template slot-scope="scope">
						<el-button type="success" icon="el-icon-view" circle :title="lang_texts.column.btn_action_view" @click=""></el-button>
						<el-button type="danger" icon="el-icon-delete" circle :title="lang_texts.column.btn_action_delete" @click=""></el-button>
						<el-button type="primary" icon="el-icon-edit" circle :title="lang_texts.column.btn_action_edit" @click=""></el-button>
						<el-button type="success" icon="el-icon-check" circle :title="lang_texts.column.btn_action_records" @click=""></el-button>
					</template>
				</el-table-column>
				
				<el-table-column v-if="isHomePublic" :label="lang_texts.column.actions" fixed="right" width="200px">
					<template slot-scope="scope">
						<el-button type="success" plain size="small" @click="viewBookDetail(scope.row)">{{ lang_texts.column.btn_action_view }}</el-button>
						<el-button type="primary" size="small" @click="borrowIt(scope.row.isbn)">{{ lang_texts.column.btn_action_borrow }}</el-button>
					</template>
				</el-table-column>
				
			</el-table>
			<el-pagination 
				class="books_paginater" 
				background layout="total,sizes,prev,pager,next"  
				@size-change="handlePageSizeChange"
				:page-size="filter.per_page"
				:current-page="filter.curr_page"
				:page-sizes="[10, 20, 50, 80, 100]"
				@current-change="changeCurrentPage"
				:total="list_data.total">
			</el-pagination>
		</div>
		<el-dialog :title="lang_texts.book_detail.description_title" :visible.sync="bookdetail_form.visible">
			<el-descriptions class="margin-top" :title="bookdetail_form.title" column=2 size="medium" border labelClassName="bookdetail_label">
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
				<el-button type="primary" @click="bookdetail_form.visible = false">{{lang_texts.book_detail.return}}</el-button>
			</div>
		</el-dialog>
	</div>
</template>

<script>
	export default {
		name: '',
		props:["vfilter", "vuse"],
		
		data() {
			return {
				loading: true,
				isSwitcherDisabled: true,
				isAdmin: false,
				isHomePublic: false,
				
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
				
				lang_texts: {
					loading_show_texts: this.$t('messages.common.loading_show_texts'),
					empty_results: this.$t('components.book_list.empty_results'),

					column: {
						isbn: this.$t('components.book_list.column.isbn'),
						title: this.$t('components.book_list.column.title'),
						author: this.$t('components.book_list.column.author'),
						category: this.$t('components.book_list.column.category'),
						stock_qty: this.$t('components.book_list.column.stock_qty'),
						borrowed_count: this.$t('components.book_list.column.borrowed_count'),
						overdued_count: this.$t('components.book_list.column.overdued_count'),
						onshelf_at: this.$t('components.book_list.column.onshelf_at'),
						active: this.$t('components.book_list.column.active'),
						actions: this.$t('components.book_list.column.actions'),
						btn_action_view: this.$t('components.book_list.column.btn_action_view'),
						btn_action_edit: this.$t('components.book_list.column.btn_action_edit'),
						btn_action_delete: this.$t('components.book_list.column.btn_action_delete'),
						btn_action_records: this.$t('components.book_list.column.btn_action_records'),
						btn_action_borrow: this.$t('components.book_list.column.btn_action_borrow')
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
			}
		},
		
		created() {
			this.filter = Object.assign(this.filter, this.vfilter);
			
			if(this.vuse == 'authors' || this.vuse == 'bcates' || this.vuse == 'booksAdmin'){//this component is invoked from admin panel
				this.isAdmin = true;
			}
			
			if(this.vuse == 'home'){//this component is invoked from home page
				this.isHomePublic = true;
			}
			
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
				if(this.isHomePublic == false) return;
				
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
				if(this.isHomePublic == false) return;
				
				let u_token = window.localStorage.getItem('u_token');
				if(u_token) {
					let u_gt = window.localStorage.getItem('u_gt');
					return (u_gt == 'user') ? true : false;
				}else{
					return false;
				}
			},
			
			doBorrowBook(isbn) {
				if(this.isHomePublic == false) return;

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
			},
			
			//request books list
			getBooksList(){
				this.loading = true;
				let book_list_url = null;
				if(this.isHomePublic){
					book_list_url = '/api/frontend/book/list';
				}else{
					book_list_url = '/api/backend/book/list';
				}
				
				const book_filter = JSON.parse(JSON.stringify(this.filter));
				this.$httpapi.post(book_list_url, book_filter, 
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
			}
		}
	}
</script>

<style>
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
	
	.bookdetail_label {
		width:20%;
		background-color: #0056B3;
	}
</style>

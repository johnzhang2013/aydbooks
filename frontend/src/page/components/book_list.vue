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
						<el-switch disabled=true v-model="scope.row.is_active" active-color="#13ce66" inactive-color="#DCDFE6" :active-value="1" :inactive-value="0" />
					</template>
				</el-table-column>
				
				<el-table-column v-if="vuse == 'books'" :label="lang_texts.column.actions" fixed="right" width="300px">
					<template slot-scope="scope">
						<el-button type="success" icon="el-icon-view" circle :title="lang_texts.column.btn_action_view" @click=""></el-button>
						<el-button type="danger" icon="el-icon-delete" circle :title="lang_texts.column.btn_action_delete" @click=""></el-button>
						<el-button type="primary" icon="el-icon-edit" circle :title="lang_texts.column.btn_action_edit" @click=""></el-button>
						<el-button type="success" icon="el-icon-check" circle :title="lang_texts.column.btn_action_records" @click=""></el-button>
					</template>
				</el-table-column>
				
				<el-table-column v-if="isHomePublic" :label="lang_texts.columns_label.actions" fixed="right" width="200px">
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
				:page-sizes="[10, 20, 50, 80, 100]"
				@current-change="changeCurrentPage"
				:total="list_data.total">
			</el-pagination>
		</div>
	</div>
</template>

<script>
	export default {
		name: '',
		props:["vfilter", "vuse"],
		
		data() {
			return {
				loading: true,
				isAdmin: false,
				isHomePublic: false,
				
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
			
			if(this.vuse == 'authors' || this.vuse == 'bcates' || this.vuse == 'books'){//this component is invoked from admin panel
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
			}
		}
	}
</script>

<style>
</style>

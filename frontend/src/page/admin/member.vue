<template>
	<layout>
		<div class="members_container">
			<div v-if="list_data.total == 0">
				<el-empty :description="lang_texts.empty_results"></el-empty>
			</div>
			<div class="members_table" else>
				<el-table :data="list_data.list" style="width: 100%" stripe border :cell-class-name="memberOverduedAlert"
					v-loading="loading"
					:element-loading-text="lang_texts.loading_show_texts"
					element-loading-spinner="el-icon-loading"
					element-loading-background="rgba(238, 236, 226, 0.8)"
				>
					<el-table-column prop="name" fixed :label="lang_texts.name" width="200px"></el-table-column>
					<el-table-column prop="email" :label="lang_texts.email" width="200px"></el-table-column>
					<el-table-column prop="is_active" :label="lang_texts.is_active" width="100px">
						<template slot-scope="scope">
							<el-switch disabled="true" v-model="scope.row.is_active" active-color="#13ce66" inactive-color="#DCDFE6" :active-value="1" :inactive-value="0" />
						</template>
					</el-table-column>
					<el-table-column prop="lendable_qty" :label="lang_texts.lendable_qty" width="150px"></el-table-column>

					<el-table-column prop="borrowing_normal_total" :label="lang_texts.borrowing_normal_total" width="150px"></el-table-column>
					<el-table-column prop="borrowing_overdued_total" :label="lang_texts.borrowing_overdued_total" width="180px"></el-table-column>
					<el-table-column prop="returned_normal_total" :label="lang_texts.returned_normal_total" width="150px"></el-table-column>
					<el-table-column prop="returned_overdued_total" :label="lang_texts.returned_overdued_total" width="180px"></el-table-column>
					
					<el-table-column width="350px">
						<template slot="header" slot-scope="scope">
							<el-input v-model="filter.name" size="mini" :placeholder="lang_texts.filter_placeholder_name" @keyup.native.enter="doMemberSearch()"/>
							<el-divider></el-divider>
							<el-input v-model="filter.email" size="mini" :placeholder="lang_texts.filter_placeholder_email" @keyup.native.enter="doMemberSearch()"/>
						</template>
						<template slot-scope="scope">
							<el-button type="primary" size="small">{{ lang_texts.btn_edit }}</el-button>
							<el-button type="primary" size="small">{{ lang_texts.btn_viewbrrs }}</el-button>
						</template>
					</el-table-column>
				</el-table>
				<el-pagination 
					class="members_paginater" 
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
		</div>
		
	</layout>
</template>

<script>
	export default {
		data() {
			return{
				loading: true,
				lang_texts: {
					loading_show_texts: this.$t('messages.common.loading_show_texts'),
					empty_results: this.$t('pages.members.empty_results'),
					
					id: this.$t('pages.members.id'),
					name: this.$t('pages.members.name'),
					email: this.$t('pages.members.email'),
					is_active: this.$t('pages.members.is_active'),
					lendable_qty: this.$t('pages.members.lendable_qty'),
					
					borrowing_normal_total: this.$t('pages.members.borrowing_normal_total'),
					borrowing_overdued_total: this.$t('pages.members.borrowing_overdued_total'),
					returned_normal_total: this.$t('pages.members.returned_normal_total'),
					returned_overdued_total: this.$t('pages.members.returned_overdued_total'),
					
					filter_placeholder_name: this.$t('pages.members.filter_placeholder_name'),
					filter_placeholder_email: this.$t('pages.members.filter_placeholder_email'),
					
					btn_edit: this.$t('pages.members.btn_edit'),
					btn_viewbrrs: this.$t('pages.members.btn_viewbrrs')
				},
				filter: {
					name: '',
					email: '',
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
		
		mounted() {
			this.getMembersList();
		},
		
		methods: {
			memberOverduedAlert({row, column, rowIndex, columnIndex}) {
				if(columnIndex != 5) return;
			
				if(columnIndex == 5){//Borrowing Overdue Alert
					if (row.borrowing_overdued_total > 5) {//ovrdued
						return 'lsa-warning';
					} else if (row.borrowing_overdued_total >3) {
						return 'lsa-lose';
					}
				}
				
				return '';
			},
			
			doMemberSearch(){
				this.filter.curr_page = 1;
				this.getMembersList();
			},
			
			//go to the specific page
			changeCurrentPage(e) {
			  this.filter.curr_page = e;
			  this.getMembersList();
			},
			
			//change the page size of paginate
			handlePageSizeChange(e) {
			  this.filter.curr_page = 1;
			  this.filter.per_page = e;
			  this.getMembersList();
			},
			
			//request members list
			getMembersList(){
				this.loading = true;
			
				const members_filter = JSON.parse(JSON.stringify(this.filter));
				this.$httpapi.post('/api/backend/members/list', members_filter, 
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
		}
	}
</script>

<style>
	.members_paginater{
		padding: 20px;
		box-sizing: border-box;
		margin: 0 auto;
	}
	
	.members_paginater .el-table .cell {
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis
	}
	
	.members_table{
		margin:0 auto;
		border:1px solid #d3cece;
		padding: 20px 20px 0 20px;
	}
	
	.members_table .el-divider--horizontal {
		margin:5px 0!important;
	}
	.members_paginater{
		margin:20px 0 10px 300px;
	}
	
	.lsa-lose {
		background-color: #ffaa7f!important;
	}
	.lsa-warning{
		background-color: #ffe8ae!important;
	}
</style>
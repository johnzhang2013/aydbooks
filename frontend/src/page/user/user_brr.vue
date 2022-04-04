<template>
	<div class="brr_page">
		<div v-if="list_data.total == 0">
			<el-empty :description="lang_texts.empty_results"></el-empty>
		</div>
		<div else>
			<el-table :data="list_data.list" style="width: 100%" stripe border
				v-loading="loading"
				:element-loading-text="lang_texts.loading_show_texts"
				element-loading-spinner="el-icon-loading"
				element-loading-background="rgba(238, 236, 226, 0.8)"
			>
				<el-table-column prop="record_no" fixed :label="lang_texts.columns_label.record_no" width="300px"></el-table-column>
				<el-table-column prop="isbn" :label="lang_texts.columns_label.isbn" width="150px"></el-table-column>
				<el-table-column prop="title" :label="lang_texts.columns_label.title" width="500px"></el-table-column>
				<el-table-column prop="status" :label="lang_texts.columns_label.status" width="200px"></el-table-column>
				<el-table-column prop="borrowed_datetime" :label="lang_texts.columns_label.borrowed_datetime" width="200px"></el-table-column>
				<el-table-column prop="deadline_datetime" :label="lang_texts.columns_label.deadline_datetime" width="200px"></el-table-column>
				<el-table-column prop="returned_datetime" :label="lang_texts.columns_label.returned_datetime" width="200px"></el-table-column>
				<el-table-column prop="overdued_days" :label="lang_texts.columns_label.overdued_days" width="150px"></el-table-column>
			</el-table>
			<el-pagination 
				class="brr_paginater" 
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
</template>

<script>
	export default {
		data() {
			return {
				loading: true,
				lang_texts: {
					empty_results: this.$t('pages.profile.tabs_brr.empty_result'),
					columns_label: {
						record_no: this.$t('pages.profile.tabs_brr.column.record_no'),
						isbn: this.$t('pages.profile.tabs_brr.column.isbn'),
						title: this.$t('pages.profile.tabs_brr.column.title'),
						status: this.$t('pages.profile.tabs_brr.column.status'),
						borrowed_datetime: this.$t('pages.profile.tabs_brr.column.borrowed_datetime'),
						deadline_datetime: this.$t('pages.profile.tabs_brr.column.deadline_datetime'),
						returned_datetime: this.$t('pages.profile.tabs_brr.column.returned_datetime'),
						overdued_days: this.$t('pages.profile.tabs_brr.column.overdued_days')
					}
				},
				
				filter: {
					per_page: 10,
					curr_page: 1
				},
				
				list_data: {
					total: 0,
					per_page: 10,
					curr_page: 1,
					total_page: 0,
					list: []
				}
			}
		},
		
		mounted(){
			this.getMemberBorrowReturnRecords();
		},
		
		methods: {
			getMemberBorrowReturnRecords() {
				const brr_filter = JSON.parse(JSON.stringify(this.filter));
				this.$httpapi.post('/api/frontend/user/brr', {},
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
			  this.getMemberBorrowReturnRecords();
			},
			
			//change the page size of paginate
			handlePageSizeChange(e) {
			  this.filter.curr_page = 1;
			  this.filter.per_page = e;
			  this.getMemberBorrowReturnRecords();
			}
		}
	}
</script>

<style>
	
</style>
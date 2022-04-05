<template>
	<div class="brr_table">
		<div v-if="list_data.total == 0">
			<el-empty :description="lang_texts.loading_show_texts"></el-empty>
		</div>
		<div else>
			<el-table :data="list_data.list" style="width: 100%" :cell-class-name="setCellClassStyle" stripe border
				v-loading="loading"
				:element-loading-text="lang_texts.loading_show_texts"
				element-loading-spinner="el-icon-loading"
				element-loading-background="rgba(238, 236, 226, 0.8)"
			>
				<el-table-column prop="record_no" fixed :label="lang_texts.column.record_no" width="300px"></el-table-column>
				<el-table-column prop="member_name" :label="lang_texts.column.member_name" width="150px"></el-table-column>
				<el-table-column prop="book_isbn" :label="lang_texts.column.book_isbn" width="150px"></el-table-column>
				<el-table-column prop="book_title" :label="lang_texts.column.book_title" width="400px"></el-table-column>
				<el-table-column prop="status" :label="lang_texts.column.status" width="100px"></el-table-column>
				<el-table-column prop="overdued_days" :label="lang_texts.column.overdued_days" width="100px"></el-table-column>
				<el-table-column prop="deadline_datetime" :label="lang_texts.column.deadline_datetime" width="200px"></el-table-column>
				<el-table-column prop="deadline_daysleft" :label="lang_texts.column.deadline_daysleft" width="100px"></el-table-column>
				<el-table-column prop="borrowed_datetime" :label="lang_texts.column.borrowed_datetime" width="200px"></el-table-column>
				<el-table-column prop="returned_datetime" :label="lang_texts.column.returned_datetime" width="200px"></el-table-column>	
			</el-table>
			<el-pagination
				class="brr_paginater" 
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
				isPublic: false,
				
				lang_texts: {
					loading_show_texts: this.$t('messages.common.loading_show_texts'),
					empty_results: this.$t('components.brr_list.empty_results'),
					
					column: {
						record_no: this.$t('components.brr_list.column.record_no'),
						member_name: this.$t('components.brr_list.column.member_name'),
						book_isbn: this.$t('components.brr_list.column.book_isbn'),
						book_title: this.$t('components.brr_list.column.book_title'),
						status: this.$t('components.brr_list.column.status'),
						overdued_days: this.$t('components.brr_list.column.overdued_days'),
						deadline_daysleft: this.$t('components.brr_list.column.deadline_daysleft'),
						deadline_datetime: this.$t('components.brr_list.column.deadline_datetime'),
						borrowed_datetime: this.$t('components.brr_list.column.borrowed_datetime'),
						returned_datetime: this.$t('components.brr_list.column.returned_datetime'),
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
			
			if(this.vuse == 'members' || this.vuse == 'books' || this.vuse == 'brrAdmin'){//this component is invoked from admin panel
				this.isAdmin = true;
			}
			
			if(this.vuse == 'memberProfile'){//this component is invoked from member profile page
				this.isPublic = true;
			}
			
			this.getBRRsList();
		},
		
		methods: {
			setCellClassStyle({row, column, rowIndex, columnIndex}) {
				if(columnIndex == 7){
					if(row.deadline_daysleft < 3){
						return 'lsa-lose';
					}else if(row.deadline_daysleft < 7){
						return 'lsa-warning';
					}
				}

				return '';
			},
			
			//request BRR list
			getBRRsList(){
				this.loading = true;
				
				const brr_filter = JSON.parse(JSON.stringify(this.filter));
				this.$httpapi.post('/api/backend/brr/list', brr_filter, 
					(res) => {
						this.loading = false;
						
						if(res.status == true && res.code == 200){
							this.list_data = res.data;
						}else{
							if(res.code == 404){
								this.list_data = res.data;
							}
							this.$message.waring(res.msg);
						}
					}
				);
			},
			
			//go to the specific page
			changeCurrentPage(e) {
				this.filter.curr_page = e;
				this.getBRRsList();
			},
			
			//change the page size of paginate
			handlePageSizeChange(e) {
				this.filter.curr_page = 1;
				this.filter.per_page = e;
				this.getBRRsList();
			}
		}
	}
</script>

<style>
	.brr_table{
		margin:0 auto;
		border:1px solid #d3cece;
	}
	.brr_paginater{
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
	.textcenter{
		text-align: center;
	}
</style>

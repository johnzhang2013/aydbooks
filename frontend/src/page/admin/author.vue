<template>
	<layout>
		<div class="authors_container">
			<div v-if="loading" class="my-loading">
				<i class="el-icon-loading"></i>
			</div>
			<div v-else-if="list_data.total == 0">
				<el-empty description="There are no authors available."></el-empty>
			</div>
			<div class="authors_table" else>
				<el-table :data="list_data.list" style="width: 100%" stripe border>
					<el-table-column prop="id" label="ID" width="130px"></el-table-column>
					<el-table-column prop="name" label="Author Name" width="400px"></el-table-column>
					<el-table-column prop="books_total" label="Books Total" width="100px"></el-table-column>
					<el-table-column width="300px">
						<template slot="header" slot-scope="scope">
							<el-input v-model="filter.name" size="mini" placeholder="Please type an author name" @keyup.native.enter="doAuthorSearch()"/>
						</template>
						<template slot-scope="scope">
							<el-button type="text" size="small">Edit</el-button>
						</template>
					</el-table-column>
				</el-table>
				<el-pagination 
					class="authors_paginater" 
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
		data(){
			return{
				loading: false,
				filter: {
					name: '',
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
			};
		},
		
		mounted(){
			this.getAuthorsList();
		},
		
		methods: {
			doAuthorSearch(){				
				this.filter.curr_page = 1;
				this.getAuthorsList();
			},			
			//request authors list
			getAuthorsList(){
				const authors_filter = JSON.parse(JSON.stringify(this.filter));
				this.$httpapi.post('/api/backend/author/list', authors_filter, 
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
			  this.getAuthorsList();
			},
			
			//change the page size of paginate
			handlePageSizeChange(e) {
			  this.filter.curr_page = 1;
			  this.filter.per_page = e;
			  this.getAuthorsList();
			},
		}
	}
</script>

<style>
	.authors_container{
		padding: 20px;
		box-sizing: border-box;
		margin: 0 auto;
	}
	
	.authors_container .filter-form{
		overflow: hidden;
	}
	
	.authors_container .filter-form .li{
		float: left;
		min-width: 255px;
		margin-bottom: 20px;
	}
	
	.authors_container .el-table .cell {
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
	
	.authors_table{
		margin:0 auto;
		border:1px solid #d3cece;
	}
	.authors_paginater{
		margin:20px 0 10px 200px;
	}
</style>
<template>
	<layout>
		<div class="brr_container">
			<ul class="filter-form">
				<li class="li">
					<span>{{lang_texts.filter.title}}</span>
					<el-input v-model="filter.book_title" :placeholder="lang_texts.filter.title_placeholder" size="small" class="w160" clearable @keyup.enter.native="doBRRSearch"></el-input>
				</li>
				
				<li class="li">
					<span>{{lang_texts.filter.isbn}}</span>
					<el-input v-model="filter.book_isbn" :placeholder="lang_texts.filter.isbn_placeholder" size="small" class="w160" clearable @keyup.enter.native="doBRRSearch"></el-input>
				</li>
				
				<li class="li">
					<span>{{lang_texts.filter.status}}</span>
					<el-select v-model="filter.status" size="small" @change="doBRRSearch">
						<el-option :label="lang_texts.filter.all_status" value="-1"></el-option>
						<el-option v-for="status in sys_brr_status" :label="status.label" :value="status.value" :key="status.value"></el-option>
					</el-select>
				</li>
				
				<li class="li">
					<span>{{lang_texts.filter.member}}</span>
					<el-select v-model="filter.user_id" size="small" @change="doBRRSearch">
						<el-option :label="lang_texts.filter.all_members" value="-1"></el-option>
						<el-option v-for="member in sys_brr_members" :label="member.label" :value="member.value" :key="member.value"></el-option>
					</el-select>
				</li>
				
				<li class="li">
					<span>{{lang_texts.filter.borrowed_date}}</span>
					<el-date-picker v-model="filter.borrowed_datetime" type="daterange" clearable unlink-panels 
						:range-separator="lang_texts.filter.date_to" 
						format="yyyy-MM-dd" 
						value-format="yyyy-MM-dd" 
						:start-placeholder="lang_texts.filter.date_start" 
						:end-placeholder="lang_texts.filter.date_end" 
						@change="doBRRSearch">
					</el-date-picker>
				</li>
				<li class="li">
					<span>{{lang_texts.filter.returned_date}}</span>
					<el-date-picker v-model="filter.returned_datetime" type="daterange" clearable unlink-panels 
						:range-separator="lang_texts.filter.date_to" 
						format="yyyy-MM-dd" 
						value-format="yyyy-MM-dd" 
						:start-placeholder="lang_texts.filter.date_start" 
						:end-placeholder="lang_texts.filter.date_end" 
						@change="doBRRSearch">
					</el-date-picker>
				</li>
				<li class="li">
					<span>{{lang_texts.filter.deadline_date}}</span>
					<el-date-picker v-model="filter.deadline_datetime" type="daterange" clearable unlink-panels 
						:range-separator="lang_texts.filter.date_to" 
						format="yyyy-MM-dd" 
						value-format="yyyy-MM-dd" 
						:start-placeholder="lang_texts.filter.date_start" 
						:end-placeholder="lang_texts.filter.date_end" 
						@change="doBRRSearch">
					</el-date-picker>
				</li>
				
				<li><el-button icon="el-icon-search" type="success"  size='large' @click.native="doBRRSearch"></el-button></li>
			</ul>
			<BRRList v-if="isShowed" :vfilter="filter" vuse="brrAdmin"></BRRList>
		</div>
	</layout>
</template>

<script>
	import BRRList from "@/page/components/brr_list.vue";
	export default {
		components: {BRRList},
		data() {
			return {
				isShowed: false,
				lang_texts: {
					filter: {
						title: this.$t('pages.brr.filter.title'),
						title_placeholder: this.$t('pages.brr.filter.title_placeholder'),
						isbn: this.$t('pages.brr.filter.isbn'),
						isbn_placeholder: this.$t('pages.brr.filter.isbn_placeholder'),
						
						member: this.$t('pages.brr.filter.member'),
						all_members: this.$t('pages.brr.filter.all_members'),
						
						status: this.$t('pages.brr.filter.status'),
						all_status: this.$t('pages.brr.filter.all_status'),
		
						borrowed_date: this.$t('pages.brr.filter.borrowed_date'),
						returned_date: this.$t('pages.brr.filter.returned_date'),
						deadline_date: this.$t('pages.brr.filter.deadline_date'),
						
						date_start: this.$t('pages.brr.filter.date_start'),
						date_end: this.$t('pages.brr.filter.date_end'),
						date_to: this.$t('pages.brr.filter.date_to')
					}					
				},
				
				filter: {
					book_isbn: '',
					book_title: '',
					user_id: null,
					status: null,
					borrowed_datetime: '',
					returned_datetime: '',
					deadline_datetime: '',
				},
				
				sys_brr_status: [
					{value: 0, label: this.$t('pages.brr.filter.sys_status.returned_normal')},
					{value: 1, label: this.$t('pages.brr.filter.sys_status.returned_overdued')},
					{value: 2, label: this.$t('pages.brr.filter.sys_status.borrowing_normal')},
					{value: 3, label: this.$t('pages.brr.filter.sys_status.borrowing_overdued')}
				],
				
				sys_brr_members: []
			}
		},
		
		mounted(){
			this.initBRRMembersOptions();
			this.doBRRSearch();
		},
		
		methods: {
			doBRRSearch() {
				this.isShowed = false;
				
				this.$nextTick(()=> {
					this.isShowed = true;
				});
			},
			
			//initialize all members of the borrow return records
			initBRRMembersOptions() {
				this.$httpapi.get(
					'api/backend/brr/members',
					{},
					(res)=>{
						if(res.status == true && res.code == 200){
							this.sys_brr_members = res.data;
						}
					},
					(error) => {}
				);
			},
		}
	}
</script>

<style>
	.brr_container{
		padding: 20px;
		box-sizing: border-box;
	}
	
	.brr_container .filter-form{
		overflow: hidden;
	}
	
	.brr_container .filter-form .li{
		float: left;
		min-width: 255px;
		margin-bottom: 20px;
	}
	
	.brr_container .el-table .cell {
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis
	}
</style>
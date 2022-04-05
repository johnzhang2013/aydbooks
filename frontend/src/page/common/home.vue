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
			<BookList v-if="isShowed" :vfilter="filter" vuse="home"></BookList>
		</div>
	</div>
</template>

<script>
	import LanguageSwitcher from "@/components/languages.vue";
	import CommonNavBar from "./comm_navbar.vue";
	import BookList from "@/page/components/book_list.vue";
	
	export default {
		components: {LanguageSwitcher, CommonNavBar, BookList},
		
		data(){
			return{
				page_name: 'home',
				isShowed: false,
				
				lang_texts:{
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
					is_active: true
				},
			
				sys_authors: [],
				sys_bookcategories: []
			};
		},
		
		mounted(){
			this.initBooksBasicOptions();
			this.doBookSearch();
		},
		
		methods: {
			doBookSearch(){
				this.isShowed = false;
				this.$nextTick(()=> {
					this.isShowed = true;
				});
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

</style>
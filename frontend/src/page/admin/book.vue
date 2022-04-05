<template>
	<layout>
		<div class="books_container">
			<ul class="filter-form">
				<li class="li">
					<span>{{lang_texts.filter.title}}</span>
					<el-input v-model="filter.title" :placeholder="lang_texts.filter.title_placeholder" size="small" class="w160" clearable @keyup.enter.native="doBookSearch"></el-input>
				</li>
				<li class="li">
					<span>{{lang_texts.filter.isbn}}</span>
					<el-input v-model="filter.isbn" :placeholder="lang_texts.filter.isbn_placeholder" size="small" class="w160" clearable @keyup.enter.native="doBookSearch"></el-input>
				</li>
				<li class="li">
					<span>{{lang_texts.filter.onshelf_date}}</span>
					<el-date-picker v-model="filter.onshelf_datetime" type="daterange" clearable unlink-panels 
						:range-separator="lang_texts.filter.onshelf_to" 
						format="yyyy-MM-dd" 
						value-format="yyyy-MM-dd" 
						:start-placeholder="lang_texts.filter.onshelf_start" 
						:end-placeholder="lang_texts.filter.onshelf_end" 
						@change="doBookSearch">
					</el-date-picker>
				</li>
				<li class="li">
					<span>{{lang_texts.filter.author}}</span>
					<el-select v-model="filter.author_id" :placeholder="lang_texts.filter.author_select_default" size="small" @change="doBookSearch">
						<el-option :label="0" :value="lang_texts.filter.all_author"></el-option>
						<el-option v-for="author in sys_authors" :label="author.label" :value="author.value" :key="author.value"></el-option>
					</el-select>
				</li>
				<li class="li">
					<span>{{lang_texts.filter.category}}</span>
					<el-select v-model="filter.category_id" :placeholder="lang_texts.filter.category_select_default" size="small" @change="doBookSearch">
						<el-option :label="0" :value="lang_texts.filter.all_category"></el-option>
						<el-option v-for="category in sys_bookcategories" :label="category.label" :value="category.value" :key="category.value"></el-option>
					</el-select>
				</li>
				<li><el-button icon="el-icon-search" type="success"  size='large' @click.native="doBookSearch"></el-button></li>
			</ul>
			<BookList v-if="isShowed" :vfilter="filter" vuse="booksAdmin"></BookList>
		</div>
	</layout>
</template>

<script>
	import BookList from "@/page/components/book_list.vue";
	
	export default {
		components: {BookList},
		data(){
			return{
				isShowed: false,
				lang_texts: {
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
					}					
				},
				
				filter: {
					isbn: '',
					title: '',
					author_id: '',
					onshelf_datetime: '',
					category_id: '',
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

</style>
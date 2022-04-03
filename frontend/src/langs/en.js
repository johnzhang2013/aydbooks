module.exports = {
	applangs: {
		english: 'English',
		chinese: 'Chinese',
		swedish: 'Swedish'
	},
	
	messages: {
		common: {
			lang_switch_success: 'Switch the language successfully!',
			loading_show_texts: 'Loading...',
		},

		borrow: {
			not_logged: 'You need to logged as a user to borrow it!'
		}
	},
	
	placeholder: {
		home: {
			filter: {
				title: 'Please input a book title',
				isbn: 'Please input a book ISBN', 
				author: 'Please choose an author name',
				category: 'Please choose an book category',
				date_start: 'Date start',
				date_end: 'Date end'
			}
		},
		login: {
			email: 'Your email-address',
			password: 'Your password'
		}
	},
	
	forms: {
		login: {
			validation : {
				empty_email: 'You must enter your email',
				invalid_email: 'Email address is invalid',
				passwd_length: 'You need to enter at least 6 characters'
			}
		},

		uploadimg: {
			validation: {
				upload_file_type: 'We only accept jpg/png image.',
				upload_file_size: 'The uploadable image size cannot exceed {file_size_max}MB!',
				upload_files_max: 'Sorry, we only accept {limit_total} images at max each time.'
			}
		}
	},
	
	pages: {
		common: {
			admin_menus: {
				dashboard: 'Dashboard',
				member: 'Members',
				books: {
					title: 'Books',
					author: 'Authors',
					category: 'Book Categories',
					book: 'Book'
				},
				bbr: {
					title: 'Borrows and Returns',
					records: 'Records',
					stats: 'Statistics',
					return: 'Return Book'
				}
			},
			
			entity: {
				book: {
					return: 'Return',
					ele_title: 'Book Information',
					isbn: 'ISBN',
					title: 'Title',
					intro: 'Introduction',
					author: 'Author',
					category: 'Category',
					stock: 'Stock',
					onshelf_at: 'Onsheft Datetime',
					borrowed_count: 'Borrowing Count',
					overdued_count: 'Overdued Count',
				}
			}
		},
		
		home:{
			title: 'Welcome to AYD Books system',
			filter: {
				title: 'Title',
				isbn: 'ISBN',
				onshelfdate: 'Onshelf Date',
				authors:'Author',
				categories: 'Category'
			},
			list: {
				empty_result: 'There are no books available',
				column: {
					isbn: 'ISBN',
					title: 'Title',
					author: 'Author',
					category: 'Category',
					stock: 'Stock',
					borrowed: 'Borrow Count',
					onshelf_at: 'Onshelf At',
					actions: 'Actions',
					btn_borrow: 'Borrow It',
					btn_view: 'Detail'
				}
			}
		},
		
		login: {
			title: 'AYD Book Login',
			loginas: 'Login as',
			rememberme: 'Remember me',
			login_as_admin: 'Librarian',
			login_as_member: 'Member',			
			btn_login: 'Login',
			btn_loging: 'Try to log in...'
		},
		
		uploadimg: {
			upload_btn_text1: 'Please drag a file here, or',
			upload_btn_text2: 'Click here to upload',
			upload_tip: 'Only a jpg/png file can be accepted, and each image more than {file_size_max}MB,{limit_total} images at max'
		},
		
		pdfmerge: {
			btn_merge: 'Generate',
			number_input_tip: 'Please input any numbers, A PDF file merged with a barcode will be created.',
			number_length: 'Vänligen ange {min_length} och {max_length} nummers',
			success_generate: 'The new PDF file is generated successfully!',
			download_it: 'Download'
		},
		
		dashboard: {
			bookstat: {
				barchart_title: 'Book Borrowings and Returns Statistics',
				xaxia_borrowing_normal: 'Borrowing(Normal)',
				xaxia_borrowing_overdued: 'Borrowing(Overdued)',
				xaxia_returned_normal: 'Returned(Normal)',
				xaxia_returned_overdued: 'Returned(Overdued)',
				yaxia_qty: 'Quantity',
				
				piechart_title: 'Books borrowing and Stock',
				all_borrowings: 'Borrowing',
				all_stocks: 'Stock',
			},
			
			booktops: {
				book_borrowed_top_title: 'Most Popular Books Top {topn}',
				book_overdued_top_title: 'Most Overdued Books Top {topn}',
				bookcate_borrowed_top_title: 'Most Popular Book Categories Top {topn}',
				bookcate_overdued_top_title: 'Most Overdued Books Categories Top {topn}'
			}
		},
		
		members: {
			empty_results: 'There are no member records in the system yet',
			
			id: 'ID',
			email: 'Email',
			name: 'Username',
			is_active: 'Actived',
			lendable_qty: 'Lendable Qty',
			
			borrowing_normal_total: 'Borrowing[Normal]',
			borrowing_overdued_total: 'Borrowing[Overdued]',
			returned_normal_total: 'Returned[Normal]',
			returned_overdued_total: 'Returned[Overdued]',
			
			filter_placeholder_name: 'Please input an username',
			filter_placeholder_email: 'Please input an Email',
			btn_edit: 'Edit',
			btn_viewbrrs: 'Borrow&Return Records'
		},
		
		author: {
			empty_results: 'There is currently no author information in the system',
			id: 'ID',
			author_name: 'Author Name',
			book_total: 'Number of Works',
			filter_placeholder: 'Please enter the author name',
			btn_edit: 'Edit',
			btn_viewbooks: 'Book List'
		},
		
		book_category: {
			empty_results: 'There is currently no book category information in the system',
			id: 'ID',
			category_name: 'Category Name',
			book_total: 'Books Total',
			filter_placeholder: 'Please input the category name',
			btn_edit: 'Edit',
			btn_viewbooks: 'Books List'
		},
		
		books: {
			empty_results: 'There are no any books available',
			fliter: {
				isbn: 'ISBN',
				isbn_placeholder: 'Please input the ISBN of a book',
				title: 'Title',
				title_placeholder: 'Please input the title of a book',
				all_author: 'All',
				author: 'Author',
				author_select_default: 'Please choose an author',
				all_category: 'All',
				category: 'Category',
				category_select_default: 'Please choose a category',
				onshelf_date: 'Onshelf Date',
				onshelf_start: 'Start',
				onshelf_to: 'To',
				onshelf_end: 'End'
			},
			column: {
				isbn: 'ISBN',
				title: 'Title',
				author: 'Author',
				category: 'Category',
				stock_qty: 'Stocks',
				onshelf_at: 'Onshelf Date',
				borrowed_count: 'Borrowed Total',
				overdued_count: 'Overdued Total',
				active: 'Active',
				actions: 'Actions',
				btn_action_view: 'Detail',
				btn_action_edit: 'Edit',
				btn_action_delete: 'Delete',
				btn_action_records: 'Records'
			}
		},
		
		profile: {
			tab_profile: 'Account Information',
			tab_brr: 'Borrow Return Records',
			tab_pwd: 'Password Update',
			tabs_profile: {
				init_error: 'Failure to get member information.',
				title: 'Profile',
				name: 'Username',
				email: 'E-mail',
				lendable_qty: 'Borrowing credits(book)',
				is_active: 'Allowed to borrow',
				brr_count: 'Total borrows(Not return/All)'
			},
			tabs_brr: {
				empty_result: 'You have no any borrow records',
				column: {
					record_no: 'Recordno',
					isbn:'ISBN',
					title: 'Title',
					status: 'Status',
					borrowed_datetime: 'Borrowed Date',
					deadline_datetime: 'Deadline Date',
					returned_datetime: 'Returned Date',
					overdued_days: 'Overdued Days'
				}
			}
		}
	},
	
	navbar: {
		greeting: 'Hello',
		login: 'Log in',
		logout: 'Log out',
		home: 'Home',
		admin_dashboard: 'Library Management',
		user_profile: 'My Profile',
		upload_img: 'Image Upload',
		pdf_merge: 'PDF Merge'
	}
}
module.exports = {
	applangs: {
		english: 'English',
		chinese: 'Chinese',
		swedish: 'Swedish'
	},
	
	messages: {
		common: {
			lang_switch_success: 'Switch the language successfully!',
		},
		
		auth: {
			
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
					onshelfat: 'Onshelf At',
					actions: 'Actions',
					btn_borrow: 'Borrow It'
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
		}
	},
	
	navbar: {
		greeting: 'Hello',
		login: 'Log in',
		home: 'Home',
		admin_dashboard: 'Library Management',
		user_profile: 'My Profile',
		upload_img: 'Image Upload'
	}
}
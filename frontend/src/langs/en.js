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
		}
	},
	
	navbar: {
		greeting: 'Hello',
		login: 'Log in',
		home: 'Home',
		admin_dashboard: 'Library Management',
		user_profile: 'My Profile'
	}
}
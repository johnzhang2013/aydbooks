module.exports = {
	applangs: {
		english: '英文',
		chinese: '中文',
		swedish: '瑞典语'
	},
	
	messages: {
		common: {
			lang_switch_success: '系统语言切换成功',
		},
		
		auth: {
			
		}
	},
	
	placeholder: {
		home: {
			filter: {
				title: '请输入书名',
				isbn: '请输入图书ISBN', 
				author: '请选择一个作者',
				category: '请选择一个类目',
				date_start: '开始日期',
				date_end: '结束日期'
			}
		},
		login: {
			email: '您的邮箱',
			password: '您的密码',
		}
	},
	
	forms: {
		login: {
			validation : {
				empty_email: '您必须输入您的邮箱',
				invalid_email: '您的邮箱格式有误',
				passwd_length: '您必须至少输入6个字符'
			}
		}
	},
	
	pages: {
		home:{
			title: '欢迎来到AYD图书系统',
			filter: {
				title: '书名',
				isbn: 'ISBN',
				onshelfdate: '上架日期',
				authors:'作者',
				categories: '类目'
			},
			list: {
				empty_result: '没有可用的书籍',
				column: {
					isbn: 'ISBN',
					title: '书名',
					author: '作者',
					category: '类目',
					stock: '库存',
					borrowed: '借阅量',
					onshelfat: '上架日期',
					actions: '操作',
					btn_borrow: '借书'
				}
			}
		},
		
		login: {
			title: '登录AYD图书系统',
			loginas: '登录角色',
			login_as_admin: '管理员',
			login_as_member: '用户',			
			rememberme: '记住我',
			btn_login: '登录',
			btn_loging: '登录中...'
		}
	},
	
	navbar: {
		greeting: '您好',
		login: '登录',
		home: '首页',
		admin_dashboard: '图书管理',
		user_profile: '个人中心'
	}	
}
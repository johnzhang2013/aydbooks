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
			validation: {
				empty_email: '您必须输入您的邮箱',
				invalid_email: '您的邮箱格式有误',
				passwd_length: '您必须至少输入6个字符'
			}
		},
		uploadimg: {
			validation: {
				upload_file_type: '上传的图片只能是jpg/png格式!',
				upload_file_size: '上传的图片大小不能超过{file_size_max}MB!',
				upload_files_max: '已达最大允许上传的图片数量{limit_total}张'
			}
		}
	},
	
	pages: {
		common: {
			entity: {
				book: {
					return: '返回',
					ele_title: '图书信息',
					isbn: 'ISBN',
					title: '书名',
					intro: '简介',
					author: '作者',
					category: '类目',
					stock: '库存',
					onshelf_at: '上架日期',
					borrowed_count: '借阅次数',
					overdued_count: '超期次数',
				}
			}
		},
		
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
					onshelf_at: '上架日期',
					actions: '操作',
					btn_borrow: '借书',
					btn_view: '查看'
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
		},
		
		uploadimg: {
			upload_btn_text1: '将图片拖到此处，或',
			upload_btn_text2: '点击上传',
			upload_tip: '只能上传jpg/png文件且不超过{file_size_max}MB，最多{limit_total}张图片!'
		},
		
		dashboard: {
			bookstat: {
				barchart_title: '图书借阅及归还情况统计',
				xaxia_borrowing_normal: '在借(正常)',
				xaxia_borrowing_overdued: '在借(超期)',
				xaxia_returned_normal: '已还(正常)',
				xaxia_returned_overdued: '已还(超期)',
				yaxia_qty: '数量',
	
				piechart_title: '图书借出未还及库存',
				all_borrowings: '所有在借',
				all_stocks: '现有库存'
			},			
			booktops: {
				book_borrowed_top_title: '最受欢迎书籍Top{topn}',
				book_overdued_top_title: '最多超期书籍Top{topn}',
				bookcate_borrowed_top_title: '最受欢迎书籍类目Top{topn}',
				bookcate_overdued_top_title: '最多超期书籍类目Top{topn}'
			}
		}
	},
	
	navbar: {
		greeting: '您好',
		login: '登录',
		home: '首页',
		admin_dashboard: '图书管理',
		user_profile: '个人中心',
		upload_img: '图片上传'
	}	
}
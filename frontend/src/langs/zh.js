module.exports = {
	applangs: {
		english: '英文',
		chinese: '中文',
		swedish: '瑞典语'
	},
	
	messages: {
		common: {
			lang_switch_success: '系统语言切换成功',
			loading_show_texts: '系统正在拼命加载中...'
		},

		borrow: {
			not_logged: '你必须以用户身份登录系统才能借书!'
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
				passwd_length: '您必须至少输入6个字符',
				login_role: '请选择您的登录身份'
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
			admin_menus: {
				dashboard: '控制台',
				member: '会员',
				books: {
					title: '书籍管理',
					author: '作家',
					category: '书籍类目',
					book: '书籍'
				},
				bbr: {
					title: '借阅管理',
					records: '借还记录',
					stats: '借阅统计',
					return: '还书操作'
				}
			},
			
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
			upload_tip: '只能上传jpg/png文件且不超过{file_size_max}MB，最多{limit_total}张图片!',
			remove_confirm_tip: '您确定要删除文件[{fname}]吗?'
		},
		
		pdfmerge: {
			btn_merge: '生成',
			number_input_tip: '请输入任何数字，系统生成对应的条形码并合并到左边示例的PDF文件中',
			number_length: '请输入{min_length} 到 {max_length} 个数字.',
			success_generate: 'PDF文件生成成功!',
			download_it: '下载'
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
		},
		
		members: {
			empty_results: '系统中尚未有任何会员记录',
			
			id: 'ID',
			email: '会员邮箱',
			name: '会员用户名',
			is_active: '是否禁止借书',
			lendable_qty: '借书额度(本)',
			
			borrowing_normal_total: '在借[正常]',
			borrowing_overdued_total: '在借[逾期]',
			returned_normal_total: '已还[正常]',
			returned_overdued_total: '已还[逾期]',
			
			filter_placeholder_name: '请输入会员用户名',
			filter_placeholder_email: '请输入会员邮箱',
			
			btn_edit: '编辑',
			btn_viewbrrs: '会员-借阅记录',
			brr_list_title: '会员 {member_name} 的借阅记录'
		},
		
		author: {
			empty_results: '系统当前无任何作家信息',
			id: 'ID',
			author_name: '作家名称',
			book_total: '著作数量',
			filter_placeholder: '请输入作家名称',
			btn_edit: '编辑',
			btn_viewbooks: '著作清单',
			book_list_title: '作家 {author_name} 的著作清单'
		},
		
		book_category: {
			empty_results: '系统当前无书籍类目信息',
			id: 'ID',
			category_name: '类目名称',
			book_total: '作品数量',
			filter_placeholder: '请输入类目名称',
			btn_edit: '编辑',
			btn_viewbooks: '书籍列表',
			book_list_title: '分类 {category_name} 下的书籍列表'
		},
		
		books: {
			fliter: {
				isbn: 'ISBN',
				isbn_placeholder: '请输入一个书籍的ISBN',
				title: '书名',
				title_placeholder: '请输入一个书名',
				all_author: '所有',
				author: '作家',
				author_select_default: '请选择一个作家',
				all_category: '所有',
				category: '类目',
				category_select_default: '请选择一个类目',
				onshelf_date: '上架日期',
				onshelf_start: '开始日期',
				onshelf_to: '到',
				onshelf_end: '结束日期'
			}
		},
		
		brr: {
			filter: {
				isbn: 'ISBN',
				isbn_placeholder: '请输入书籍的ISBN',	
				title: '书名',
				title_placeholder: '请输入书籍的名称',
				member: '用户名',
				all_members: '所有',	
				status: '借阅状态',
				all_status: '所有',
				borrowed_date: '借书日期',
				returned_date: '还书日期',
				deadline_date: '截止期限',
				date_start: '开始日期',
				date_end: '结束日期',
				date_to: '到',
				sys_status: {
					borrowing_normal: '正常在借',
					borrowing_overdued: '逾期在借',
					returned_normal: '正常归还',
					returned_overdued: '逾期归还'
				}
			}
		},
		
		profile: {
			tab_profile: '个人信息',
			tab_brr: '借阅记录',
			tab_pwd: '密码更新',
			tabs_profile: {
				init_error: '用户信息拉取失败',
				title: '资料概览',
				name: '用户名',
				email: '登录邮箱',
				lendable_qty: '借书额度(本)',
				is_active: '是否允许借书',
				brr_count: '已借阅次数(未还/所有)'
			},
			tabs_brr: {
				empty_result: '目前你还未有任何借阅记录',
				column: {
					record_no: '系统编号',
					isbn:'ISBN',
					title: '书名',
					status: '借阅状态',
					borrowed_datetime: '借书日期',
					deadline_datetime: '还书期限',
					returned_datetime: '还书日期',
					overdued_days: '超期天数'
				}
			}
		}
	},
	
	navbar: {
		greeting: '您好',
		login: '登录',
		logout: '退出',
		home: '首页',
		admin_dashboard: '图书管理',
		user_profile: '个人中心',
		upload_img: '图片上传',
		pdf_merge: 'PDF文件合并'
	},
	
	components: {
		book_list: {			
			empty_results: '系统当前无书籍信息',
			column: {
				isbn: 'ISBN',
				title: '书名',
				author: '作家',
				category: '类目',
				stock_qty: '库存',
				onshelf_at: '上架日期',
				borrowed_count: '借阅量',
				overdued_count: '逾期量',
				active: '是否可借',
				actions: '操作',
				btn_action_view: '查看',
				btn_action_edit: '编辑',
				btn_action_delete: '删除',
				btn_action_records: '借阅记录',
				btn_action_borrow: '借书'
			}
		},
		
		brr_list: {
			empty_results: '系统当前无图书借阅记录',
			column: {
				record_no: '编号',
				member_name: '用户名',
				book_isbn: 'ISBN',
				book_title: '书名',
				status: '状态',
				overdued_days: '超期天数',
				deadline_daysleft: '剩余天数',
				deadline_datetime: '截止日期',
				borrowed_datetime: '借书日期',
				returned_datetime: '还书日期',
			}
		}
	}
}
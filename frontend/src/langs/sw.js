module.exports = {
	applangs: {
		english: 'Engelsk',
		chinese: 'Kinesiska',
		swedish: 'Svenska'
	},
	
	messages: {
		common: {
			lang_switch_success: 'Byt språk framgångsrikt!',
			loading_show_texts: 'Läser in...',
		},

		borrow: {
			not_logged: 'Du måste logga in som användare för att låna den!'
		}
	},
	
	placeholder: {
		home: {
			filter: {
				title: 'Vänligen ange en boktitel',
				isbn: 'Vänligen ange en bok ISBN', 
				author: 'Välj ett författarnamn',
				category: 'Välj en bokkategori',
				date_start: 'Datum start',
				date_end: 'Datum slut'
			}
		},
		login: {
			email: 'Din e-postadress',
			password: 'Ditt lösenord'
		}
	},
	
	forms: {
		login: {
			validation : {
				empty_email: 'Du måste ange din e-postadress',
				invalid_email: 'Din e-post är i fel format',
				passwd_length: 'Du måste ange minst 6 tecken',
				login_role: 'Välj din inloggningsroll'
			}
		},
		uploadimg: {
			validation: {
				upload_file_type: 'Uppladdade bilder kan endast vara i jpg/png-format!',
				upload_file_size: 'Storleken på bilden du vill ladda upp får inte överstiga {file_size_max}MB!',
				upload_files_max: 'Tyvärr, vi accepterar bara {limit_total} bilder vid max varje gång'
			}
		}
	},
	
	pages: {
		common: {
			admin_menus: {
				dashboard: 'System översikt',
				member: 'Medlemmar',
				books: {
					title: 'Böcker',
					author: 'Författare',
					category: 'Bokkategorier',
					book: 'Bok'
				},
				bbr: {
					title: 'Lånar och Returnerar',
					records: 'Låna Skivor',
					stats: 'Statistik',
					return: 'Returnera Bok'
				}
			},
			
			entity: {
				book: {
					return: 'Lämna Tillbaka',
					ele_title: 'Bokinformation',
					isbn: 'ISBN',
					title: 'Boktitel',
					intro: 'Introduktion',
					author: 'Författare',
					category: 'Kategori',
					stock: 'Lagermängd',
					onshelf_at: 'Lanseringsdag',
					borrowed_count: 'Läsvolym',
					overdued_count: 'Försenad statistik',
				}
			}
		},

		home:{
			title: 'Välkommen till AYD Bok Systemet',
			filter: {
				title: 'Boktitel',
				isbn: 'ISBN',
				onshelfdate: 'Lanseringsdag',
				authors:'Författare',
				categories: 'Kategori'
			}
		},
		
		login: {
			title: 'Logga in på AYD Bok Systemet',
			loginas: 'Inloggning Roll',
			rememberme: 'Kom ihåg mig',
			login_as_admin: 'Bibliotekarie',
			login_as_member: 'Medlem',
			btn_login: 'Logga in',
			btn_loging: 'Försök att logga in...'
		},
		
		uploadimg: {
			upload_btn_text1: 'Dra filer hit, eller',
			upload_btn_text2: 'Klicka för att ladda upp',
			upload_tip: 'Endast jpg/png filer kan laddas upp, och bildstorleken bör inte överstiga {file_size_max}MB, Upp till {limit_total} bilder',
			remove_confirm_tip: 'Är du säker på att du vill ta bort filen [{fname}]?'
		},
		
		pdfmerge: {
			btn_merge: 'Generera',
			number_input_tip: 'Du matar in siffror du vill ha, och vi slår samman det som en streckkod till en PDF-fil.',
			number_length: 'Ange minst {number_length} nummer.',
			success_generate: 'Den nya PDF-filen har skapats framgångsrikt!',
			download_it: 'Ladda ner'
		},
		
		dashboard: {
			bookstat: {
				barchart_title: 'Bokstatistik',
				xaxia_borrowing_normal: 'Obetalt(Normalt)',
				xaxia_borrowing_overdued: 'Obetald(Försenad)',
				xaxia_returned_normal: 'Betald(Normalt)',
				xaxia_returned_overdued: 'Betald(försenad)',
				yaxia_qty: 'Kvantitet',
				
				piechart_title: 'Böckerlån och Stock',
				all_borrowings: 'Utestående',
				all_stocks: 'Befintliga Lager',
			},
			
			booktops: {
				book_borrowed_top_title: 'Mest populära böcker Top {topn}',
				book_overdued_top_title: 'Mest försenade böcker Top {topn}',
				bookcate_borrowed_top_title: 'Mest populära bokkategorier Top {topn}',
				bookcate_overdued_top_title: 'Mest försenade böcker Kategorier Top {topn}'
			}
		},
		
		members: {
			empty_results: 'Det finns inga medlemsregister i systemet ännu',
			
			id: 'ID',
			email: 'Medlemsmail',
			name: 'Användarnamn',
			is_active: 'Aktiverad',
			lendable_qty: 'Lånebelopp (bok)',
			
			borrowing_normal_total: 'Låna[Normal]',
			borrowing_overdued_total: 'Låna[Försenad]',
			returned_normal_total: 'Returnerad[Normal]',
			returned_overdued_total: 'Returnerad[Försenad]',	
			
			filter_placeholder_name: 'Vänligen ange medlemmens användarnamn',
			filter_placeholder_email: 'Vänligen ange medlemsmail',
			btn_edit: 'Redigera',
			btn_viewbrrs: 'Låna Skivor'
		},
		
		author: {
			empty_results: 'Det finns för närvarande ingen författarinformation i systemet',
			id: 'ID',
			author_name: 'Författarens namn',
			book_total: 'Antal Verk',
			filter_placeholder: 'Ange författarens namn',
			btn_edit: 'Redigera',
			btn_viewbooks: 'Bok Lista',
			book_list_title: 'Lista över verk av författaren [{author_name}]'
		},
		
		book_category: {
			empty_results: 'Det finns för närvarande ingen bokkategoriinformation i systemet',
			id: 'ID',
			category_name: 'Kategori Namn',
			book_total: 'Böcker Totalt',
			filter_placeholder: 'Vänligen ange kategorinamnet',
			btn_edit: 'Redigera',
			btn_viewbooks: 'Böcker Lista',
			book_list_title: 'Böckerlistan i kategorin {category_name}'
		},
		
		books: {
			fliter: {
				isbn: 'ISBN',
				isbn_placeholder: 'Ange ISBN för en bok',
				title: 'Titel',
				title_placeholder: 'Vänligen ange titeln på en bok',
				all_author: 'Allt',
				author: 'Författare',
				author_select_default: 'Välj en författare',
				all_category: 'Allt',
				category: 'Kategori',
				category_select_default: 'Vänligen välj en kategori',
				onshelf_date: 'Datum på hyllan',
				onshelf_start: 'Start',
				onshelf_to: 'Till',
				onshelf_end: 'Slutet'
			}
		},
		
		profile: {
			tab_profile: 'Personlig information',
			tab_brr: 'Låna skivor',
			tab_pwd: 'Lösenordsuppdatering',
			tabs_profile: {
				init_error: 'Användarinformation pull misslyckades',
				title: 'Dataöversikt',
				name: 'Användarnamn',
				email: 'Din brevlåda',
				lendable_qty: 'Lånebelopp (bok)',
				is_active: 'Är det tillåtet att låna böcker',
				brr_count: 'Lånade tider(enastående/alla)'
			},
			tabs_brr: {
				empty_result: 'Du har inga låneuppgifter ännu',
				column: {
					record_no: 'Serienummer',
					isbn:'ISBN',
					title: 'Boktitel',
					status: 'Lånestatus',
					borrowed_datetime: 'Lånedatum',
					deadline_datetime: 'Returperiod',
					returned_datetime: 'Deadline datum',
					overdued_days: 'Försenade dagar'
				}
			}
		}
	},
	
	navbar: {
		login: 'Logga in',
		logout: 'Logga ut',
		home: 'Hem',
		greeting: 'Hallå',
		admin_dashboard: 'Hantera Böcker',
		user_profile: 'Ditt konto',
		upload_img: 'Ladda Upp Bild',
		pdf_merge: 'PDF Fungerar'
	},
	
	components: {
		book_list: {
			empty_results: 'Det finns inga tillgängliga böcker',
			column: {
				isbn: 'ISBN',
				title: 'Titel',
				author: 'Författar',
				category: 'Kategori',
				stock_qty: 'Lagermängd',
				onshelf_at: 'Datum på hyllan',
				borrowed_count: 'Lånade Totalt',
				overdued_count: 'Försenad Totalt',
				active: 'Aktiva',
				actions: 'Handlingar',
				btn_action_view: 'Detaljer',
				btn_action_edit: 'Redigera',
				btn_action_delete: 'Radera',
				btn_action_records: 'Uppgifter',
				btn_action_borrow: 'Låna den'
			}
		}
	}
}
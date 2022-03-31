module.exports = {
	applangs: {
		english: 'Engelsk',
		chinese: 'Kinesiska',
		swedish: 'Svenska'
	},
	
	messages: {
		common: {
			lang_switch_success: 'Byt språk framgångsrikt!',
		},
		
		auth: {
			
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
				passwd_length: 'Du måste ange minst 6 tecken'
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
			},
			list: {
				empty_result: 'Det finns inga böcker tillgängliga',
				column: {
					isbn: 'ISBN',
					title: 'Titel',
					author: 'Författare',
					category: 'Kategori',
					stock: 'Stock',
					borrowed: 'Låna räkna',
					onshelf_at: 'Lanseringsdag',
					actions: 'Fungera',
					btn_borrow: 'Låna den',
					btn_view: 'Detaljer'
				}
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
			upload_tip: 'Endast jpg/png filer kan laddas upp, och bildstorleken bör inte överstiga {file_size_max}MB, Upp till {limit_total} bilder'
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
		}
	},
	
	navbar: {
		login: 'Logga in',
		home: 'Hem',
		greeting: 'Hallå',
		admin_dashboard: 'Hantera Böcker',
		user_profile: 'Ditt konto',
		upload_img: 'Ladda Upp Bild'
	}
}
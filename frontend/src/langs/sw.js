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
		}
	},
	
	pages: {
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
					onshelfat: 'Lanseringsdag',
					actions: 'Fungera',
					btn_borrow: 'Låna böcker'
				}
			}
		},
		
		login: {
			title: 'Logga in på AYD Bok Systemet',
			loginas: 'Inloggningsroll',
			rememberme: 'Kom ihåg mig',
			login_as_admin: 'Bibliotekarie',
			login_as_member: 'Medlem',
			btn_login: 'Logga in',
			btn_loging: 'Försök att logga in...'
		}
	}
}
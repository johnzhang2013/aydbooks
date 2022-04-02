//The public common page
const Home = () => import("../page/common/home.vue")
const Login = () => import("../page/common/login.vue")
const ImageUpload = () => import("../page/common/upload_image.vue");
const PdfMerge = () => import("../page/common/pdf_merge.vue");

//The user private page
//const MyBorrowed = () => import("../page/user/myborrowed.vue")
const Profile = () => import("../page/user/profile.vue")

//The admin panel page
const Dashboard = () => import("../page/admin/dashboard.vue")

const Books = () => import("../page/admin/book.vue")
const BookCategory = () => import("../page/admin/book_category.vue")
const Author = () => import("../page/admin/author.vue")

const BRRrecords = () => import("../page/admin/brr_records.vue")
const BRRstats = () => import("../page/admin/brr_stats.vue")
const BRRreturn = () => import("../page/admin/brr_return.vue")
//const Member = () => import("../page/admin/member.vue")

export default [
	{ path: '/',  name: 'home', component: Home },
	{ path: '/login', name: 'user_login', component: Login },
	{ path: '/uploadimg', name: 'uploadimg', component: ImageUpload },
	{ path: '/pdfmerge', name: 'pdfmerge', component: PdfMerge },
	
	//{ path: '/myborrowed', name: 'myborrowed', component: MyBorrowed },
	{ path: '/profile', name: 'user_profile', component: Profile },
	
	{ path: '/dashboard', name: 'dashboard', component: Dashboard},
	{ path: '/books', name: 'books', component: Books},
	{ path: '/bookcategory', name: 'bookcategory', component: BookCategory},
	{ path: '/authors', name: 'author', component: Author},
	
	{ path: '/brr_records', name: 'brr_records', component: BRRrecords},
	{ path: '/brr_stats', name: 'brr_stats', component: BRRstats},
	{ path: '/brr_return', name: 'brr_return', component: BRRreturn},
	//{ path: '/member', name: 'member', component: Member},
];
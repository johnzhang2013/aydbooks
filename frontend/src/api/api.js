import axios from 'axios';
import store from '../store';

axios.interceptors.request.use(
	config => {
		let token = window.localStorage.getItem('u_token');
		if(token){
			config.headers.Authorization = 'Bearer '+ token;
		}
		return config;
	},
	error => {
		return Promise.reject(error)
	}
);
axios.interceptors.response.use(
	response => {
		return response;
	}, 
	error => {
		let error_code = error.response.status;
		if(error_code == 401 || error_code == 400){//Unauthenticated access or Invalid request
			store.commit("logout");//Force to log out as it may be a malicious request
			window.location.replace('/#/login');//we can not use this.$router here
		}		
		return Promise.reject(error.response.data);
	}
);
var request = {
	get: (url, data, success, error) =>{
		axios.get(url, data).then((res) => {
			success(res.data);
		}).catch(err => {
			console.log(err);
			error && error(err);
		});
	},
	post: (url, data, success, error) => {
		axios.post(url, data).then((res) => {
			success(res.data);
		}).catch((res) => {
			error && error(res);
		});
	}
}
export default request;
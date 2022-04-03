<template>
	<div class="upload_page">
		<div class="upload_languge_switcher">
			<LanguageSwitcher></LanguageSwitcher>
		</div>
		<div class="common_nav_bar">
			<CommonNavBar workfor="image_upload"></CommonNavBar>
		</div>
		<div class="upload_panel">
			<el-upload class="upload-demo" list-type="picture" drag name="uimage"
				action="api/frontend/uploadimg"
				:headers="request_headers"
				:before-upload="beforeUploadCheck"
				:on-exceed="handleFilesCountExceed"
				:on-success="handleUploadSuccess"
				:on-error="handleUploadError"
				:file-list="image_files_list"
				:limit="this.files_limit_max"
			>
				<i class="el-icon-upload"></i>
				<div class="el-upload__text">
					{{ this.lang_texts.upload_btn_text1 }}
					<em>{{ this.lang_texts.upload_btn_text2 }}</em>
				</div>
				<div class="el-upload__tip" slot="tip">
					{{ this.$t('pages.uploadimg.upload_tip', {file_size_max: this.file_size_max, limit_total: this.files_limit_max}) }}
				</div>
			</el-upload>
			<el-image v-for="url in resized_image_urls" :key="url" :src="url" lazy></el-image>
		</div>
	</div>
</template>

<script>
	import LanguageSwitcher from "../../components/languages.vue";
	import CommonNavBar from "./comm_navbar.vue";
	export default {
		components: {LanguageSwitcher, CommonNavBar},
		data() {
			return {
				request_headers: null,
				files_limit_max: 1,
				file_size_max: 5,
				image_files_list: [],
				resized_image_urls: [],
				lang_texts: {
					upload_btn_text1: this.$t('pages.uploadimg.upload_btn_text1'),
					upload_btn_text2: this.$t('pages.uploadimg.upload_btn_text2')
				},
			}
		},
		
		created(){
			//set this applocale header manually as we don't use the axios to upload
			this.request_headers = {
				AppLocale: window.localStorage.getItem('u_lang') || 'en'
			}
		},
		
		methods: {
			//check file type and size before upload it
			beforeUploadCheck(file) {
				const isJPG = (file.type === 'image/jpeg');
				const isPNG = (file.type === 'image/png')
				const imageSizeChk = (file.size / 1024 / 1024) < this.file_size_max;
		
				if (!(isJPG || isPNG)) {
					this.$message.error(this.$t('forms.uploadimg.validation.upload_file_type'));
				}
				if (!imageSizeChk) {
					this.$message.error(this.$t('forms.uploadimg.validation.upload_file_size', {file_size_max: this.file_size_max}));
				}
				
				return ((isJPG || isPNG) && imageSizeChk);
			},
			
			//show messages if file count exceed
			handleFilesCountExceed(files, fileList) {
				let t_params = { limit_total: this.files_limit_max }
				this.$message.warning(this.$t('forms.uploadimg.validation.upload_files_max', t_params));
			},
			
			//show images and message after uploaded successfully
			handleUploadSuccess(res, file) {
				if(res.status == true && res.code == 200){
					this.resized_image_urls = res.data.local_img_urls;
					
					this.$message('[' + res.code +'] ' + res.msg);
				}else{
					this.$message('[' + res.code +'] ' + res.msg);
				}
			},
			
			//show message after it failured
			handleUploadError(res, file) {
				this.image_files_list = [];
				this.$message('[' + res.code +'] ' + res.msg);
			}
		}
	}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
	.upload_page {
		height: 100%;
		background-size: cover;
	}
	.upload_panel {
		display: flex;
		justify-content: center;
		align-items: center;
		margin:0 auto;
		height: 100%;
		padding-left:300px;
	}
	.upload_panel .title {
		margin: 0px auto 30px auto;
		text-align: center;
		color: #707070;
	}
	
	.upload-form {
		border-radius: 6px;
		background: #ffffff;
		width: 400px;
		padding: 25px 25px 5px 25px;
		.el-input {
			height: 38px;
			input {
				height: 38px;
			}
		}
		.input-icon {
			height: 39px;
			width: 14px;
			margin-left: 2px;
		}
	}
		
	.common_nav_bar{
		position: relative;
		float: right;
		height: 10%;
		margin:12px 0 0 0px;
		padding-right:20px;
	}
	.upload_languge_switcher {
		position: relative;
		float: right;
		height: 10%;
		width:100px;
		margin:15px 20px 0 0;
	}
	.upload_languge_switcher .el-dropdown-link {
		cursor: pointer;
		color: #ffffff!important;
	}
</style>

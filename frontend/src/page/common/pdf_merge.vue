<template>
	<div class="pdfmerge_page">
		<div class="upload_languge_switcher">
			<LanguageSwitcher></LanguageSwitcher>
		</div>
		<div class="common_nav_bar">
			<CommonNavBar workfor="pdfmerge"></CommonNavBar>
		</div>
		<div class="pdfmerge_panel">
			<div class="pdfmerge_sample">
				<el-image :src="src_pdf_image_url" lazy></el-image>
			</div>
			<div class="pdfmerge_instruction">
				<el-form ref="form">
					<span>{{ lang_texts.number_input_tip }}</span>
					<el-divider></el-divider>
					<el-form-item class="number_input_text">
					    <el-input type="number" v-model="barcode_number" placecoder="12345353453"></el-input>
					</el-form-item>
					<el-form-item>
						<el-button class="btn_merge" size="medium" type="primary" @click.native.prevent="doMerge">{{ lang_texts.btn_merge }}</el-button>
					</el-form-item>
					<el-divider></el-divider>
					<el-form-item v-if="is_generated">
						<a :href="new_pdf_url" target="_blank" class="download_pdf">{{ lang_texts.download_it }}</a>
					</el-form-item>
				</el-form>
			</div>
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
				src_pdf_image_url: 'src_pdf_image.png',
				new_pdf_url: '',
				is_generated:false,
				barcode_number:null,
				lang_texts: {
					number_input_tip: this.$t('pages.pdfmerge.number_input_tip'),
					btn_merge: this.$t('pages.pdfmerge.btn_merge'),
					download_it: this.$t('pages.pdfmerge.download_it')
				}
			}
		},
		
		methods: {
			doMerge() {
				let bnumber = new String(this.barcode_number);
				if(bnumber.length < 8 || bnumber.length > 10){
					this.$message.warning(this.$t('pages.pdfmerge.number_length', {max_length: 10, min_length: 8}));
					return;
				}
				this.is_generated = false;
				
				this.$httpapi.post(
					'api/frontend/pdfmerge',
					{'number': this.barcode_number},
					(res)=>{
						if(res.status == true && res.code == 200){
							this.is_generated = true;
							this.new_pdf_url = res.data;
							this.$message.success(this.$t('pages.pdfmerge.success_generate'));
						}else{
							this.is_generated = false;
							this.$message.error('[' + res.code +'] ' + res.msg);
						}
					},
					(error) => {
						this.$message(error);
					}
				);
			}
		}
	}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
	.pdfmerge_page {
		height: 100%;
		background-size: cover;
	}
	.pdfmerge_panel {
		display: flex;
		justify-content: center;
		align-items: center;
		margin:0 auto;
		height: 100%;
		padding-left:300px;
	}
	.pdfmerge_panel .title {
		margin: 0px auto 30px auto;
		text-align: center;
		color: #707070;
	}
	.pdfmerge_sample {
		float:left;
		position: relative;
	}
	.pdfmerge_instruction {
		float:right;
		padding-left:50px;
	}
	.number_input_text{
		width:200px;
		margin:0 auto;
	}
	.btn_merge{
		width:20%;
		margin:0 auto;
		float:right;
		margin:20px 200px 0 0;
	}
	.download_pdf {
		color:green;
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

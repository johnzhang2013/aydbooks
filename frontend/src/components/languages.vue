<template>
	<el-dropdown :hide-on-click="false" trigger="click" @command="handleSetLanguage">
		<span class="el-dropdown-link">{{curr_lang_text}}<i class="el-icon-arrow-down el-icon--right"></i></span>
		<el-dropdown-menu slot="dropdown">
			<el-dropdown-item command="zh" :disabled="language == 'zh'">{{ this.$t("applangs.chinese") }}</el-dropdown-item>
			<el-dropdown-item command="en" :disabled="language == 'en'">{{ this.$t("applangs.english") }}</el-dropdown-item>
			<el-dropdown-item command="sw" :disabled="language == 'sw'">{{ this.$t("applangs.swedish") }}</el-dropdown-item>
		</el-dropdown-menu>
	</el-dropdown>
</template>

<script>
	export default {
		name: 'LanguageSwitcher',
		data(){
			return {
				curr_lang_text: null
			}
		},		
		computed: {
		    language() {
				let curr_lang = this.$store.state.u_lang
				switch(true){
					case curr_lang == 'zh':
						this.curr_lang_text = this.$t("applangs.chinese")
					break;
					case curr_lang == 'sw':
						this.curr_lang_text = this.$t("applangs.swedish")
					break;
					default:
						this.curr_lang_text = this.$t("applangs.english")
					break;
				}
				return curr_lang
		    }
		},
		methods: {
			handleSetLanguage(lang) {
				//Set the language
				this.$i18n.locale = lang
				
				//store it
				this.$store.dispatch('setLanguage', lang)
				
				this.$message({
					message: this.$t("messages.common.lang_switch_success"),
					type: 'success'
				})
				
				//trigger the reload event
				this.$emit('handerevent')
				
				location.reload();
			}
		}
	}
</script>

<style>	
	.el-icon-arrow-down {
		font-size: 12px;
	}
</style>

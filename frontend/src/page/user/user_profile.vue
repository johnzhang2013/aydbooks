<template>
	<el-descriptions class="margin-top" :title="this.$t('pages.profile.tabs_profile.title')" column=1 size="medium" border>
		<el-descriptions-item>
			<template slot="label">{{ this.$t('pages.profile.tabs_profile.name') }}</template>{{userprofile_form.name}}
		</el-descriptions-item>
		<el-descriptions-item>
			<template slot="label">{{ this.$t('pages.profile.tabs_profile.email') }}</template>{{userprofile_form.email}}
		</el-descriptions-item>
		<el-descriptions-item>
			<template slot="label">{{ this.$t('pages.profile.tabs_profile.lendable_qty') }}</template>{{userprofile_form.lendable_qty}}
		</el-descriptions-item>
		<el-descriptions-item>
			<template slot="label">{{ this.$t('pages.profile.tabs_profile.is_active') }}</template>{{userprofile_form.is_active}}
		</el-descriptions-item>
		<el-descriptions-item>
			<template slot="label">{{ this.$t('pages.profile.tabs_profile.brr_count') }}</template>{{userprofile_form.brr_count}}
		</el-descriptions-item>
	</el-descriptions>
</template>

<script>
	export default {
		data() {
			return {
				userprofile_form: {
					name: '',
					email: '',
					lendable_qty: '',
					is_active: '',
					brr_count: 0
				}
			}
		},
		
		mounted() {
			this.initMemeberInfo();
		},
		
		methods: {
			initMemeberInfo() {
				this.$httpapi.get(
					'api/frontend/user/profile',
					{},
					(res)=>{
						if(res.status == true && res.code == 200){
							this.userprofile_form.name = res.data.name;
							this.userprofile_form.email = res.data.email;
							this.userprofile_form.lendable_qty = res.data.lendable_qty;
							this.userprofile_form.is_active = res.data.is_active;
							this.userprofile_form.brr_count = res.data.brr_count;
						}else{
							this.$message({
								message: '[' + res.code +'] ' + res.msg,
								type: 'error',
								duration: 2000,//2 seconds
								showClose: true
							});
						}
					},
					(error) => {
						this.$message({
								message: this.$t('pages.profile.tabs_profile.init_error'),
								type: 'error',
								duration: 2000,//2 seconds
								showClose: true
						});
					}
				);
			}
		}
	}
</script>

<style>
</style>

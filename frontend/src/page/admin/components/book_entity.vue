<template>
	<el-dialog title="Book Edit" :visible.sync="formvisible.book_edit_form">
		<el-form :model="BookEditForm">
			<el-form-item label="活动名称" :label-width="formLabelWidth">
				<el-input v-model="BookEditForm.name" autocomplete="off"></el-input>
			</el-form-item>
			<el-form-item label="活动区域" :label-width="formLabelWidth">
				<el-select v-model="BookEditForm.region" placeholder="请选择活动区域">
				<el-option label="区域一" value="shanghai"></el-option>
				<el-option label="区域二" value="beijing"></el-option>
				</el-select>
			</el-form-item>
		</el-form>
		<div slot="footer" class="dialog-footer">
			<el-button @click="formvisible.book_edit_form = false">取 消</el-button>
			<el-button type="primary" @click="formvisible.book_edit_form = false">确 定</el-button>
		</div>
	</el-dialog>
</template>

<script>
	export default {
		name: 'BookEntity'
	}
</script>

<style>
</style>

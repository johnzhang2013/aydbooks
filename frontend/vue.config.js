const path = require('path')
function resolve(dir) {
	return path.join(__dirname, dir)
}
module.exports = {  
    runtimeCompiler: true,
	//outputDir: '',
	productionSourceMap: false,
	devServer: {
	    proxy: 'http://aydbook.test'
	},
	configureWebpack: {
		resolve: {
			alias: {
				// eslint-disable-next-line no-undef
				'@': resolve('src'),
			},
		},
	},
}
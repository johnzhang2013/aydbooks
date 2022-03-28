module.exports = {  
    runtimeCompiler: true,
	//outputDir: '',
	productionSourceMap: false,
	devServer: {
	    proxy: 'http://aydbook.test'
	}
}
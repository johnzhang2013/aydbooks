<template>
	<div>
		<div id="bookstat_pchart" style="height:300px; width:30%;float:left"></div>
		<div id="bookstat_bchart" style="height:300px; width:70%;float:right"></div>
	</div>
</template>

<script>
	let echarts = require('echarts/lib/echarts');
	require('echarts/lib/chart/bar');
	require('echarts/lib/chart/pie');
	require('echarts/lib/chart/line');
	require('echarts/lib/component/tooltip');
	require('echarts/lib/component/title');
	require('echarts/lib/component/legend')
	
	export default {
		name: 'BookStat',
		data() {
			return {
				bookstat_bchart: {},
				bookstat_pchart: {},
				bookstat_bchart_option: {
					type:'bar',
					backgroundColor: '#ffffff',
					title:{
						text: this.$t('pages.dashboard.bookstat.barchart_title')
					},
					tooltip: {},
					xAxis:{
						data: [
							this.$t('pages.dashboard.bookstat.xaxia_borrowing_normal'),
							this.$t('pages.dashboard.bookstat.xaxia_borrowing_overdued'),
							this.$t('pages.dashboard.bookstat.xaxia_returned_normal'),
							this.$t('pages.dashboard.bookstat.xaxia_returned_overdued')
						]
					},
					yAxis:{},
					series: {
						type: 'bar',
						showBackground: true,
						itemStyle:{						
							color:function(p){
								return ["#55aa00","#ff6c17","#00aa00","#ffaa00"][p.dataIndex]
							}
						},
						name: this.$t('pages.dashboard.bookstat.yaxia_qty'),
						type: 'bar',
						data: []
					}
				},
				bookstat_pchart_option: {
					type: 'pie',
					backgroundColor: '#ffffff',
					title: {
						text: this.$t('pages.dashboard.bookstat.piechart_title'),
						subtext: '',
						x:'left',
						textStyle:{
							color:"#222",
							fontStyle:"normal",
							fontWeight:"600",
							fontFamily:"san-serif",
							fontSize:16
						}
					},
					tooltip: {
						trigger: 'item',
						formatter: "{a} {b}\n{c}"
					},
					legend: {
						x: '70%',
						y: '25%',
						orient: 'vertical',
						left: 'left',
						itemWidth:10,
						itemHeight:10,                		
						selectedMode:false, //prevent to click
						textStyle: {  
							fontSize: 12,
							color:"#999",     
						}, 
						formatter: function (name) { //show only 4 letters
							return (name.length > 20) ? (name.slice(0, 20) + "...") : name
						},
						data:[this.$t('pages.dashboard.bookstat.all_borrowings'), this.$t('pages.dashboard.bookstat.all_stocks')]
					},
					series : [
						{
							name: '',
							type: 'pie',
							radius : '75%',
							center: ['50%', '50%'], 
							hoverAnimation:false, //whether let it hover to enlarge
							selectedMode:'single',//whether let it select multiple or signle
							selectedOffset:5, //the offset distance of selected
							data: [],
							itemStyle: {
								normal:{
									label:{
										show:true,
										textStyle: {
											fontSize: 12  
										},
										formatter: function(params){//handle the name length
											var name = params.name;
											var percent = params.percent;
											var value = params.value;
											if(name.length > 20){
												return name.slice(0, 20) + "..." + "\n" + "(" + value + ")" + percent + "%";
											}else{
												return name + "\n" + "(" + value + ")" + percent + "%";
											}
										}
									},
									labelLine:{
										show:false
									}
								},
								emphasis: {
									shadowBlur: 10,
									shadowOffsetX: 0,
									shadowColor: 'rgba(0, 0, 0, 0.5)'
								}
							}
						}
					],
					color: ['rgb(255, 170, 127)','rgb(0, 170, 0)'] //the color of pie zone
				},
				book_bbr_count: [],
				stock_borrowing_count: []
			}
		},

		mounted() {
			this.$nextTick(() => {
				this.queryBookStat()
			})
		},

		methods: {
			queryBookStat() {
				this.$httpapi.get('/api/backend/dashboard/book_stat', {},
					(res) => {
						if(res.status == true && res.code == 200){
							this.book_bbr_count = res.data.bbr_count;
							this.stock_borrowing_count = res.data.stocks_and_borrowings;
							
							//assign the returned value to echart related option
							this.bookstat_bchart_option.series.data = this.book_bbr_count;
							this.bookstat_pchart_option.series[0].data = this.stock_borrowing_count;
							
							//then we draw it
							this.drawBooksStat();
						}else{
							this.$message(res.msg);
						}
					}
				);
			},
			
			drawBooksStat() {
				let _this = this;
				//Draw the borrow and return record statistics
				this.bookstat_bchart = echarts.init(document.getElementById('bookstat_bchart'));
				this.bookstat_bchart.setOption(this.bookstat_bchart_option);
				window.addEventListener("resize", function(){
					_this.bookstat_bchart.resize();
				});
				
				//Draw the ratio of all book borrowing and stock
				this.bookstat_pchart = echarts.init(document.getElementById('bookstat_pchart'));
				this.bookstat_pchart.setOption(this.bookstat_pchart_option);
				
				window.addEventListener("resize", function(){
					_this.bookstat_pchart.resize();
				});
			}			
		}
	}
</script>

<style>
</style>

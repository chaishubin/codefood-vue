<template>
	<div class="container">

		<el-form :inline="true" class="demo-form-inline" size="mini">
			<el-row type="flex">
				<el-col :span="15">
					<el-form-item label="订单ID">
						<el-input v-model.trim="order_id" placeholder="请输入内容"></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="15">
					<el-form-item label="产品名称">
						<el-input v-model.trim="goods_name" placeholder="请输入内容"></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="15">
					<el-form-item label="订单金额">
						<el-input v-model.trim="order_money" placeholder="请输入内容"></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex">
				<el-col :span="15">
					<el-form-item label="订单时间">
						<el-date-picker
						@change="changetime"
						format="yyyy-MM-dd"
						value-format="yyyy-MM-dd"
						v-model="order_time"
						type="daterange"
						range-separator="至"
						start-placeholder="开始日期"
						end-placeholder="结束日期">
						</el-date-picker>
					</el-form-item>
				</el-col>
				<el-col :span="15">
					<el-form-item label="姓名">
						<el-input v-model.trim="user_name" placeholder="请输入内容"></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="15">
					<el-form-item label="联系方式">
						<el-input v-model.trim="tel" placeholder="请输入内容"></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex">
				<el-col :span="15">
					<el-form-item label="性别">
						<el-select v-model="sex" clearable placeholder="请选择">
							<el-option label="男" value="1"></el-option>
							<el-option label="女" value="2"></el-option>
							<el-option label="其他" value="3"></el-option>
						</el-select>
					</el-form-item>
				</el-col>
				<el-col :span="15">
					<el-form-item label="支付方式">
						<el-select v-model="pay_way" clearable placeholder="请选择">
							<el-option v-for="item in paywayOptions" :key="item.id" :label="item.name" :value="item.id"></el-option>
						</el-select>
					</el-form-item>
				</el-col>
				<el-col :span="15">
					<el-form-item label="订单状态">
						<el-select v-model="order_status" clearable placeholder="请选择">
							<el-option v-for="item in orderstatusOptions" :key="item.id" :label="item.name" :value="item.id"></el-option>
						</el-select>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="space-between" style="margin-bottom:20px;">
				<el-button @click="exportexcel">导出</el-button>
				<el-button type="primary" @click="search">搜索</el-button>
			</el-row>
		</el-form>
		<!--  table  -->
		<div class="one-table-container">
			<el-table :data="tableData" border style="width: 100%">
				<el-table-column fixed prop="order_id" label="订单ID">
				</el-table-column>
				<el-table-column prop="goods_name" label="产品名称">
				</el-table-column>
				<el-table-column prop="order_money" label="订单金额">
				</el-table-column>
				<el-table-column prop="front_money" label="定金">
				</el-table-column>
				<el-table-column prop="coupon" label="优惠券">
				</el-table-column>
				<el-table-column prop="pay_money" label="实付金额">
				</el-table-column>
				<el-table-column prop="pay_way" :formatter="formatpayway" label="支付方式">
				</el-table-column>
				<el-table-column prop="order_time" label="订单时间">
				</el-table-column>
				<el-table-column prop="order_status" label="订单状态">
				</el-table-column>
				<el-table-column prop="user_name" label="姓名">
				</el-table-column>
				<el-table-column prop="relationship" label="关系">
				</el-table-column>
				<el-table-column prop="sex" :formatter="formatsex" label="性别">
				</el-table-column>
				<el-table-column prop="birthdate" label="出生日期">
				</el-table-column>
				<el-table-column prop="tel" label="联系方式">
				</el-table-column>
				<el-table-column prop="eamil" label="Email">
				</el-table-column>
			</el-table>
		</div>
		<!--Pagination-->
		<div class="pagination" style="margin:20px 0;">
			<el-row type="flex" align="middle" justify="end">
				<el-pagination @current-change="handleCurrentChange" background layout="total,prev, pager, next" :total="total" :page-size="pagesize">
				</el-pagination>
			</el-row>
		</div>
	</div>
</template>
<script>
	import { getlist,paywaylist,orderstatuslist,excelexport } from '@/api/HICustomer.js'
	export default {
		data() {
			return {
				paywayOptions: [

                ],
                orderstatusOptions: [

                ],
				tableData: [

				],
				order_id:'',
				goods_name:'',
				order_money:'',
				order_time:[],
				user_name:'',
				tel:'',
				sex:'',
				pay_way:'',
				order_status:'',
				total:0,
				pagesize:10,
				cur_page: 1,
			}
		},
		created(){
			this.getData();
			this.getpaywaylist();
			this.getorderstatuslist();
		},
		mounted() {
　　　	 
  		},
		methods: {
			getData(){
				getlist(this.cur_page,this.pagesize,this.order_id,this.goods_name,this.order_money,this.order_time,this.user_name,this.tel,this.sex,this.pay_way,this.order_status).then(res => {
					console.log(res.data.data)
					this.total = res.data.data.total;
					this.tableData = res.data.data[0];
				}).catch(err => {
					console.log(err)
				})
			},
			search(){
				this.getData();
			},
			handleCurrentChange(val){
				this.cur_page = val;
				this.getData();
			},
			changetime(val){
                this.order_time = val;
                console.log(this.order_time);
            },
			formatpayway(row, column, cellValue){
				if (cellValue == '101'){
					return '支付全额';
				}else if (cellValue == '102'){
					return '支付定金';
				}
			},
			formatsex(row, column, cellValue){
				if (cellValue == '1'){
					return '男';
				}else if (cellValue == '2'){
					return '女';
				}else if (cellValue == '3'){
					return '其他';
				}
			},
			//导出
			exportexcel() {
				excelexport('1','1000000',this.order_id,this.goods_name,this.order_money,this.order_time,this.user_name,this.tel,this.sex,this.pay_way,this.order_status).then(res => {
					console.log(res.data)
					window.location.href = process.env.IMG_API + res.data;
				}).catch(err => {
					console.log(err)
				})
			},
			//支付方式下拉菜单
			getpaywaylist() {
				paywaylist().then(res => {
					console.log(res.data.data)
					this.paywayOptions = res.data.data;
				}).catch(err => {
					console.log(err)
				})
			},
			//支付方式下拉菜单
			getorderstatuslist() {
				orderstatuslist().then(res => {
					console.log(res.data.data)
					this.orderstatusOptions = res.data.data;
				}).catch(err => {
					console.log(err)
				})
			},
		}
	}
</script>

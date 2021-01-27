<template>
	<view class="content" @click="startLogin">
		页面 - 1
	</view>
</template>

<script>
	import Lockr from 'lockr';
export default {
	data() {
		return {
			title: 'Hello'
		};
	},
	onLoad() {},
	methods: {
		startLogin(e){
			console.log( Lockr.rm('x-token'))
		}
			
	}
};
</script>

<style>
.content {
	text-align: center;
	height: 400upx;
	margin-top: 200upx;
}
</style>

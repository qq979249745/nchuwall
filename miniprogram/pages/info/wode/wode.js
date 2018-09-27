 var me;
const app = getApp();
var url = app.globalData.baseUrl;
var start = 0;
var end = 5;
var d = [];
 Page({
  data: {

  },
   onShow: function () {
     start = 0;
     end = 5;
     me = this;
     d = [];
     this.getData();
   },
   onPullDownRefresh: function () {
     this.onShow();
   },
   getData: function () {
     wx.request({
       url: app.globalData.baseUrl + 'suoyou.php',
       method: 'POST',
       header: { 'content-type': 'application/x-www-form-urlencoded' },
       data: {
         fbid: '%',
         openid: wx.getStorageSync('openid'),
         self: wx.getStorageSync('openid'),
         start: start,
         end: end,
       },
       success: function (res) {
         console.log(res);
         for (var i = 1; i <= res.data.length; i++) {
           d.push(res.data[i]);
         }
         me.setData({
           data: d
         });
         console.log(me.data);
         wx.hideNavigationBarLoading();
         wx.stopPullDownRefresh();
       }
     });
     wx.showNavigationBarLoading();
   },
   xiangqing: function (r) {
     if (wx.getStorageSync('userInfo')) {
       wx.navigateTo({
         url: '/pages/details/details?fbid=' + r.currentTarget.dataset.fbid
       });
     } else {
       wx.switchTab({
         url: '/pages/info/info',
       });
       wx.showToast({
         icon: 'none',
         title: '请先授权登陆',
       });
     }
   },
   dianzan: function (r) {

     var data = me.data.data[r.currentTarget.dataset.index];
     if (!data.content) {
       if (wx.getStorageSync('userInfo')) {
         console.log('dianzan');
         wx.request({
           url: url + 'index1.php',
           method: 'POST',
           header: { 'content-type': 'application/x-www-form-urlencoded' },
           data: {
             fbid: r.currentTarget.dataset.fbid,
             openid: wx.getStorageSync('openid'),
             content: 'true',
             table: 'praiseNum',
           },
         });
         // var content = "data[" + r.currentTarget.dataset.index +"].content";
         var praiseNum = parseInt(me.data.data[r.currentTarget.dataset.index].praiseNum) + 1;

         me.setData({
           ["data[" + r.currentTarget.dataset.index + "].content"]: "true",
           ["data[" + r.currentTarget.dataset.index + "].praiseNum"]: praiseNum
         });
         console.log(me.data);
       } else {
         wx.switchTab({
           url: '/pages/info/info',
         });
         wx.showToast({
           icon: 'none',
           title: '请先授权登陆',
         });
       }
     } else {
       console.log("不能重复点赞")
     }
   },
   onReachBottom: function (res) {
     start += 5;
     end += 5;
     this.getData();
   },
 })
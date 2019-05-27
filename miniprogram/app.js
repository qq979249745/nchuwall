//app.js
App({
  onLaunch: function() {
    // wx.cloud.init({
    //   traceUser: true,
    // })
    // wx.getSetting({
    //   success: res => {
    //     if (res.authSetting['scope.userInfo']) {
    //       // 已经授权，可以直接调用 getUserInfo 获取头像昵称，不会弹框
    //       wx.getUserInfo({
    //         success: r => {
    //           this.globalData.userInfo = r.userInfo;
    //         }
    //       })
    //     };
    //   }
    // });
    if (!wx.getStorageSync("openid")) {
      wx.login({
        success: function(res) {
          if (res.code) {
            //发起网络请求
            // console.log(res.code);
            wx.request({
              url: "https://api.weixin.qq.com/sns/jscode2session?appid=wxdb885643ba93abc8&secret=c4d64a113b3aed5545809e3a5061efa7&js_code=" + res.code + "&grant_type=authorization_code",
              success: function(res) {
                console.log(res);
                wx.setStorageSync("openid", res.data.openid);
              },
            })
          } else {
            console.log('登录失败！' + res.errMsg)
          }
        }
      });
    }

  },
  globalData: {
    userInfo: null,
    baseUrl: 'http://192.168.43.1:8080/'
  }
})
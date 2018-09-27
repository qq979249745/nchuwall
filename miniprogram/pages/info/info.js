var app = getApp();
var url = app.globalData.baseUrl;
// const db = wx.cloud.database();
Page({
  data: {
    show: true,
    userInfo: null
  },
  onLoad: function(options) {
    this.getinfo();
  },
  onShow: function() {
    wx.getSetting({
      success: res => {
        if (res.authSetting['scope.userInfo']) {
          this.setData({
            show: false,
          });
        } else {
          this.setData({
            show: true
          })
        }
      }
    })
  },
  getinfo: function() {
    wx.getSetting({
      success: res => {
        if (res.authSetting['scope.userInfo']) {
          // 已经授权，可以直接调用 getUserInfo 获取头像昵称，不会弹框
          wx.getUserInfo({
            success: res => {
              // 可以将 res 发送给后台解码出 unionId
              console.log(res);
              wx.setStorageSync('userInfo', res.userInfo);
              //app.globalData.userInfo=res.userInfo;
              this.setData({
                show: false,
                userInfo: res.userInfo
              });


              // db.collection('user').where({
              //   _openid: wx.getStorageSync("openid")
              // }).get().then(res => {
              //   console.log(res);
              //   if (res.data.length > 0) {
              //     db.collection('user').doc(res.data._id).update({
              //       data: {
              //         dengTime: db.serverDate()
              //       }
              //     }).then(res => { console.log(res);})
              //   } else {
              // db.collection('user').doc(wx.getStorageSync("openid")).set({
              //       data: {
              //         avatarUrl: r.userInfo.avatarUrl,
              //         nickName: r.userInfo.nickName,
              //         gender: r.userInfo.gender,
              //         dengTime: new Date
              //       }}).then(res=>{
              //         console.log(res);
              //       })

              //   }
              // })

              // db.collection('user').add({
              //   data: {
              //     avatarUrl: res.userInfo.avatarUrl,
              //     nickName: res.userInfo.nickName,
              //     gender: res.userInfo.gender,
              //     createTime: db.serverDate()
              //   },
              //   success: res => {
              //     console.log('[数据库] [新增记录] 成功，记录 _id: ', res._id)
              //   },
              //   fail: err => {
              //     wx.showToast({
              //       icon: 'none',
              //       title: '新增记录失败'
              //     })
              //     console.error('[数据库] [新增记录] 失败：', err)
              //   }
              // })

              wx.request({
                url: url + 'login.php',
                method: 'POST',
                header: {
                  'content-type': 'application/x-www-form-urlencoded'
                },
                data: {
                  openid: wx.getStorageSync("openid"),
                  avatarUrl: res.userInfo.avatarUrl,
                  nickName: res.userInfo.nickName,
                  gender: res.userInfo.gender
                },
                success: function(res) {
                  console.log(res);
                }
              });
            }
          })
        } else {
          this.setData({
            show: true
          })
        }
      }
    })
  },
  wode: function(res) {
    console.log(res.currentTarget.dataset);
    wx.navigateTo({
      url: 'wode/wode',
    })
  },
})
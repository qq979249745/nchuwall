var app = getApp();
var url = app.globalData.baseUrl;
// const db = wx.cloud.database();
var util = require('../../../utils/util.js');
var me;
Page({
  data: {
    imgPath: '/images/empty.png',
    value: null,
    data: {
      title: '物品名称：',
      titleTip: '在此填写宝贝名称',
      content: '物品描述：',
      contentTip: '在此描述你的宝贝：如品牌、规格、成色、出售原因等',
    },
  },
  
  onShow: function () {
    me = this;
    if (!wx.getStorageSync('userInfo')) {
      wx.switchTab({
        url: '/pages/info/info',
      });
      wx.showToast({
        icon: 'none',
        title: '请先授权登陆',
      });
    }
  },
  submit: function (res) {
    console.log(res.detail.value);
    var value = res.detail.value;
    if (value.neirong.length > 0) {
      if ('/images/empty.png' == me.data.imgPath) {
        wx.request({
          url: url + 'fabu.php',
          method: 'POST',
          header: {
            'content-type': 'application/x-www-form-urlencoded'
          },
          data: {
            openid: wx.getStorageSync('openid'),
            biaoti: value.biaoti.length > 0 ? value.biaoti : '所有人',
            neirong: value.neirong,
            niming: value.niming ? true : 'NULL',
          },
          success: function (res) {
            console.log(res);
            if (res.statusCode == 200) {
              wx.switchTab({
                url: '/pages/index/index',
              });
              wx.showToast({
                title: '发布成功',
              });
              me.setData({
                value: null,
                imgPath: '/images/empty.png',
              });
            } else {
              wx.showToast({
                title: '发布失败',
                icon: 'none'
              });
            }
          }
        });
      } else {
        wx.uploadFile({
          url: url + 'fabu.php',
          filePath: me.data.imgPath,
          name: 'file',
          formData: {
            openid: wx.getStorageSync('openid'),
            biaoti: value.biaoti.length > 0 ? value.biaoti : '所有人',
            neirong: value.neirong,
            niming: value.niming ? true : 'NULL',
          },
          success: function (res) {
            console.log(res);
            if (res.statusCode == 200) {
              wx.switchTab({
                url: '/pages/index/index',
              });
              wx.showToast({
                title: '发布成功',
              });
              me.setData({
                value: null,
                imgPath: '/images/empty.png',
              });
            } else {
              wx.showToast({
                title: '发布失败',
                icon: 'none'
              });
            }
          }
        });
      }

    } else {
      wx.showToast({
        icon: 'none',
        title: '内容不能为空',
      });
    }
  },
  chooseImg: function () {
    wx.chooseImage({
      count: 1,
      success: function (res) {
        console.log(res);
        me.setData({
          imgPath: res.tempFilePaths[0]
        });

      },
    })
  }
})
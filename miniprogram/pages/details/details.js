// const db=wx.cloud.database();
var util = require('../../utils/util.js');
var fbid;
var me;
var app=getApp();
var url=app.globalData.baseUrl;
Page({
  data: {
    value:null,
    show:false,
    imgPath:null
  },
  onLoad: function (options) {
    me=this;
    fbid = options.fbid;
    // db.collection('fabu').doc(options._id).get().then(res => {
    //   console.log(res);
    //   me.setData({
    //     data: res.data,
    //     fabuTime: util.formatTime(res.data.fabuTime)
    //   });
    //   if (wx.getStorageSync('openid') != res.data._openid){
    //     console.log('你是过客');
    //     db.collection('fabu').doc(_id).update({
    //       data: {
    //         watchNum: me.data.data.watchNum + 1
    //       }
    //     });
    //     db.collection('passengers').doc(_id).set({
    //       data:{
    //         avatarUrl: app.globalData.userInfo.avatarUrl,
    //       }
    //     });
    //   }
    // });
    wx.showNavigationBarLoading();
    wx.request({
      url: app.globalData.baseUrl + 'suoyou.php',
      method: 'POST',
      header: { 'content-type': 'application/x-www-form-urlencoded' },
      data: {
        fbid: fbid,
        openid: '%',
        self: wx.getStorageSync('openid'),
        start: 0,
        end: 1,
      },
      success: function (res) {
        console.log(res.data[1]);
        me.setData({
          data: res.data[1],
          
        });
        if (res.data[1].imgPath!='NULL'){
          me.setData({
            imgPath: app.globalData.baseUrl + 'images/' + res.data[1].imgPath
          });
        }
        if (res.data[1].openid == wx.getStorageSync('openid')){
          me.setData({
            show: true
          });
        }
        wx.hideNavigationBarLoading();
        if (wx.getStorageSync('openid') != res.data[1].openid) {
          console.log('你是过客' + wx.getStorageSync('userInfo').avatarUrl);
          wx.request({
            url: url + 'index1.php',
            method: 'POST',
            header: { 'content-type': 'application/x-www-form-urlencoded' },
            data: {
              fbid: fbid,
              openid: wx.getStorageSync('openid'),
              content: wx.getStorageSync('userInfo').avatarUrl,
              table: 'watchNum',
            },});
          // wx.request({
          //   url: url + 'index3.php',
          //   method: 'POST',
          //   header: { 'content-type': 'application/x-www-form-urlencoded' },
          //   data: {
          //     fbid: fbid,
          //     content: 'ping',
          //   }, success: function (r) {
          //     console.log(r);
          //   }
          // });
        }
      }
    });
    
  },
  onShow: function () {
    wx.request({
      url: url + 'index2.php',
      method: 'POST',
      header: { 'content-type': 'application/x-www-form-urlencoded' },
      data: {
        fbid: fbid,
        table: 'commentNum',
      },
      success:function(res){
        console.log(res);
        me.setData({
          comment:res.data
        });
      }}
    );
    wx.request({
      url: url + 'index2.php',
      method: 'POST',
      header: { 'content-type': 'application/x-www-form-urlencoded' },
      data: {
        fbid: fbid,
        table: 'watchNum',
      },
      success: function (res) {
        me.setData({
          watch: res.data
        });
      }
    }
    );
  },
  inputValue:function(res){
    this.setData({
      inputValue:res.detail.value
    })
  },
  send:function(){
    if (this.data.inputValue && this.data.inputValue.length>0){
      console.log(this.data.inputValue);
      wx.request({
        url: url + 'index1.php',
        method: 'POST',
        header: { 'content-type': 'application/x-www-form-urlencoded' },
        data: {
          fbid: fbid,
          openid: wx.getStorageSync('openid'),
          content: me.data.inputValue,
          table:'commentNum',
        },
        success: function (res) {
          console.log(res);
          if ('200'==res.statusCode) {
            me.onShow();
            me.setData({
              inputValue:null
            });
            // wx.request({
            //   url: url + 'index3.php',
            //   method: 'POST',
            //   header: { 'content-type': 'application/x-www-form-urlencoded' },
            //   data: {
            //     fbid: fbid,
            //     content: 'ping',
            //   },success:function(r){
            //     console.log(r);
            //   }});
            // db.collection('fabu').doc(_id).update({
            //   data:{
            //     commentNum: me.data.data.commentNum+1
            //   }
            // }).then(res=>{
            //   console.log(res);
            // });
            wx.showToast({
              title: '发送成功！',
            });
          } else {
            wx.showToast({
              title: '发布失败',
              icon: 'none'
            });
          }
        }
      });
      // db.collection('comment').add({
      //     data: {
      //       fabu_id:_id,
      //       neirong: me.data.inputValue,
      //       avatarUrl: app.globalData.userInfo.avatarUrl,
      //       nickName: app.globalData.userInfo.nickName,
      //       gender: app.globalData.userInfo.gender,
      //       fabuTime: util.formatTime(new Date()),
      //     },}
      // ).then(res=>{
      //   if ('collection.add:ok'==res.errMsg){
      //     me.onShow();
      //     me.setData({
      //       inputValue:null
      //     })
      //     db.collection('fabu').doc(_id).update({
      //       data:{
      //         commentNum: me.data.data.commentNum+1
      //       }
      //     }).then(res=>{
      //       console.log(res);
      //     });
      //     wx.showToast({
      //       title: '发送成功！',
      //     })
      //   }
      // });
    }
  },
  delete:function(){
    wx.showModal({
      title: '删除',
      content: '删除后不能恢复',
      success:function(res){
        console.log(res);
        if(res.confirm){
          wx.request({
            url: url + 'delete.php',
            method: 'POST',
            header: { 'content-type': 'application/x-www-form-urlencoded' },
            data: {
              fbid: fbid,
            },
            success: function (r) {
              wx.switchTab({
                url: '/pages/index/index',
              });
              wx.showToast({
                title: '删除成功',
              })
            }
          });
        }
      }
    });
  },
})
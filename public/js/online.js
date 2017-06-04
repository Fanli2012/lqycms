$(function(){
    // cms客服浮动面板
    if($("#cmsFloatPanel"))
    {
        $("#cmsFloatPanel > .ctrolPanel > a.arrow").click(function(){$("html,body").animate({scrollTop :0}, 800);return false;});
        var objServicePanel = $("#cmsFloatPanel > .servicePanel");
        var objMessagePanel = $("#cmsFloatPanel > .messagePanel");
        var objQrcodePanel = $("#cmsFloatPanel > .qrcodePanel");
        var w_s = objServicePanel.outerWidth();
        var w_m = objMessagePanel.outerWidth();
        var w_q = objQrcodePanel.outerWidth();
        $("#cmsFloatPanel .ctrolPanel > a.service").bind({
          click : function(){return false;},
          mouseover : function(){
              objMessagePanel.stop().hide();objQrcodePanel.stop().hide();
              if(objServicePanel.css("display") == "none"){
                 objServicePanel.css("width","0px").show();
                 objServicePanel.animate({"width" : w_s + "px"},600);
              }
              return false;
          }
        });
        $(".servicePanel-inner > .serviceMsgPanel > .serviceMsgPanel-hd > a",objServicePanel).bind({
          click : function(){
              objServicePanel.animate({"width" : "0px"},600,function(){
                objServicePanel.hide();  
              });
              return false;
          }
        });
        $("#cmsFloatPanel > .ctrolPanel > a.message").bind({
          click : function(){return false;},
          mouseover : function(){
              objServicePanel.stop().hide();objQrcodePanel.stop().hide();
              if(objMessagePanel.css("display") == "none"){
                 objMessagePanel.css("width","0px").show();
                 objMessagePanel.animate({"width" : w_m + "px"},600);
              }
              return false;
          }
        });
        $(".messagePanel-inner > .formPanel > .formPanel-bd > a",objMessagePanel).bind({
          click : function(){
              objMessagePanel.animate({"width" : "0px"},600,function(){
                objMessagePanel.stop().hide();  
              });
              return false;
          }
        });
        $("#cmsFloatPanel > .ctrolPanel > a.qrcode").bind({
          click : function(){return false;},
          mouseover : function(){
              objServicePanel.stop().hide();objMessagePanel.stop().hide();
              if(objQrcodePanel.css("display") == "none"){
                 objQrcodePanel.css("width","0px").show();
                 objQrcodePanel.animate({"width" : w_q + "px"},600);
              }
              return false;
          }
        });
        $(".qrcodePanel-inner > .codePanel > .codePanel-hd > a",objQrcodePanel).bind({
          click : function(){
              objQrcodePanel.animate({"width" : "0px"},600,function(){
                objQrcodePanel.stop().hide();  
              });
              return false;
          }
        });
    } 
});
function p(t,c){function o(i){return i.match(/\d+/g).map(Number)}function n(i){const s=i.map(a=>(a/=255,a<=.03928?a/12.92:Math.pow((a+.055)/1.055,2.4)));return .2126*s[0]+.7152*s[1]+.0722*s[2]}const r=o(t),e=o(c),_=n(r),f=n(e),u=(Math.max(_,f)+.05)/(Math.min(_,f)+.05),g=4.5,d=7,m=u>=g,b=u>=d;return{passesAA:m,passesAAA:b}}function l(t,c){const o=document.querySelector(".sftExt_type");let n=p(t,c);if(n.passesAA&&n.passesAAA){document.querySelector(".sftExt_alert")&&document.querySelector(".sftExt_alert").remove();return}const r=document.createElement("tr");r.classList.add("sftExt_alert"),r.innerHTML=`<th>Warning:</th><td>The contrast ratio between the background color and text color does not meet the accessibility standards.<br/>AA: ${n.passesAA?"Passing":"Failing"}<br/>AAA: ${n.passesAAA?"Passing":"Failing"}`,o&&o.parentNode&&(document.querySelector(".sftExt_alert")&&document.querySelector(".sftExt_alert").remove(),o.parentNode.insertBefore(r,o))}jQuery(function(t){t("#sftExt_type").on("change",function(e){t(this).val()=="rectangle"?t(".rectangle-only").removeClass("hidden"):t(".rectangle-only").addClass("hidden"),t(this).val()=="round"?t(".round-only").removeClass("hidden"):t(".round-only").addClass("hidden")}),t("#sftExt_rectangle_font_size_units").on("change",function(e){t(".sftExt_units").text(t(this).val())}),t("#sftExt_fontawesome_icon_classes_btn").on("click",function(e){e.preventDefault()}),t("#sftExt_fontawesome_icon_classes").iconpicker({hideOnSelect:!1,placement:"inline"}),t("#sftExt_fontawesome_icon_classes").on("iconpickerSelected",function(e){t("#sftExt_icon_display i").attr("class","fa-3x "+e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue))});var c=document.querySelector("#sftExt_color_picker_btn_bg_color"),o=document.querySelector("#sftExt_color_picker_btn_font_color"),n=new Picker({parent:c,color:t("#sftExt_bg_color").val()}),r=new Picker({parent:o,color:t("#sftExt_font_color").val()});n.onChange=function(e){t("#sftExt_bg_color").val(e.rgbaString),l(e.rgbaString,r.color.rgbaString),t("#sftExt_color_picker_btn_bg_color").css({"background-color":e.rgbaString})},r.onChange=function(e){t("#sftExt_font_color").val(e.rgbaString),l(n.color.rgbaString,e.rgbaString),t("#sftExt_color_picker_btn_font_color").css({"background-color":e.rgbaString})},l(n.color.rgbaString,r.color.rgbaString)});

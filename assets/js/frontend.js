document.addEventListener("DOMContentLoaded",function(){var t=document.getElementById("sftExt-frontend-button");if(window.sftExtBtn.shouldShow)if(t)t.addEventListener("click",function(i){var n=t.dataset.newTab,d=t.dataset.url,a=window.open(n,"_blank");a.focus(),window.location.replace(d)});else{var t=document.createElement("button");t.id="sftExt-frontend-button",t.className=window.sftExtBtn.classes||"",t.setAttribute("data-new-tab",window.sftExtBtn.newTabUrl),t.setAttribute("data-url",window.sftExtBtn.currentTabUrl);var e=document.createElement("div");e.className="sftExt-inner",e.innerHTML=window.sftExtBtn.icon;let n=document.createElement("span");window.sftExtBtn.btnType!="round"&&window.sftExtBtn.btnType!="square"?n.textContent=window.sftExtBtn.text:(n.className="sr-only",n.textContent="Safety Exit"),e.appendChild(n),t.appendChild(e),t.addEventListener("click",function(d){var a=t.dataset.newTab,o=t.dataset.url,s=window.open(a,"_blank");s.focus(),window.location.replace(o)}),document.body.appendChild(t)}});

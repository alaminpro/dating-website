$(document).ready(function(){var e=$("#filter__container");$("#cancel__filter").on("click",function(){e.slideUp()}),$(".filter__btn").on("click",function(){e.slideToggle()}),$(".noUi-handle").on("click",function(){$(this).width(50)});var n=document.getElementById("slider-range"),t=[],a=$("#formFilter").data("min"),i=$("#formFilter").data("max");if(document.location.search){var c={};$.each(document.location.search.substr(1).split("&"),function(e,n){var t=n.split("=");c[t[0].toString()]=t[1].toString()}),t=[c.min_age,c.max_age]}else t=""!=a&&""!=i?[a,i]:[18,90];if(noUiSlider.create(n,{start:t,step:1,range:{min:[18],max:[90]},connect:!0,format:wNumb({decimals:0})}),n.noUiSlider.on("update",function(e,n){document.getElementById("slider-range-value1").innerHTML=e[0],document.getElementById("slider-range-value2").innerHTML=e[1];var t=$("#min-value"),a=$("#max-value");t.val(e[0]),a.val(e[1])}),$("#location__icon").click(function(){$(".location__search").toggle()}),$(".range").change(function(){$("#distance").val($(this).val())}),document.location.search){c={};$.each(document.location.search.substr(1).split("&"),function(e,n){var t=n.split("=");c[t[0].toString()]=t[1].toString()}),$(".range").val(c.distance),$("#rangevalue1").val(c.distance),$("#distance").val(c.distance)}var o=document.querySelector('input[type="range"]');o.addEventListener("input",function(){var e=o.value;document.querySelector("#rangevalue1").innerHTML=e})});


$(document).ready(function() {
    var filter_container  = $('#filter__container');
   $('#cancel__filter').on('click',function(){
       filter_container.slideUp();
   })
   $('.filter__btn').on('click',function(){
       filter_container.slideToggle();
   })

   $('.noUi-handle').on('click', function() {
       $(this).width(50);
   });
   var rangeSlider = document.getElementById('slider-range');
   var start = [];
   
   var min = $('#formFilter').data('min');
   var max = $('#formFilter').data('max'); 
  
   if(document.location.search){
           var queries = {};
           $.each(document.location.search.substr(1).split('&'),function(c,q){
               var i = q.split('=');
               queries[i[0].toString()] = i[1].toString();
           }); 
           start = [queries.min_age, queries.max_age] 
   }else{
       if(min != '' && max != ''){
           start = [min, max];
       }else{
           start = [18, 90]
       } 
   }
   noUiSlider.create(rangeSlider, {
       start: start,
       step: 1,
       range: {
           'min': [18],
           'max': [90]
       }, 
       connect: true,
       format: wNumb({
           decimals: 0
       }),
   });
   
   // Set visual min and max values and also update value hidden form inputs
   rangeSlider.noUiSlider.on('update', function(values, handle) {
       document.getElementById('slider-range-value1').innerHTML = values[0];
       document.getElementById('slider-range-value2').innerHTML = values[1];  
       var minVal = $('#min-value');
       var maxVal = $('#max-value'); 
       minVal.val(values[0]) 
       maxVal.val(values[1]) 
   });

   $('#location__icon').click(function(){
       $('.location__search').toggle();
   });
   $('.range').change(function(){
       $('#distance').val($(this).val())
   })
   if(document.location.search){
       var queries = {};
       $.each(document.location.search.substr(1).split('&'),function(c,q){
           var i = q.split('=');
           queries[i[0].toString()] = i[1].toString();
       });

       $('.range').val(queries.distance)
       $('#rangevalue1').val(queries.distance)
       $('#distance').val(queries.distance)
   } 
   var elem = document.querySelector('input[type="range"]');

   var rangeValue = function(){
   var newValue = elem.value;
   var target = document.querySelector('#rangevalue1');
   target.innerHTML = newValue;
   } 
   elem.addEventListener("input", rangeValue); 
   
}); 
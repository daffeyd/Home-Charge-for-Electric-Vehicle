 
<!DOCTYPE html>
<html>
<head>

<script>
    var time = 0;
var running = 0;
function startPause(){
    if(running == 0){
        running = 1;
        increment();
   
    }	
}
function reset(){
    running = 0;
    time = 0;
}
function increment(){
    if(running == 1){
        setTimeout(function(){
            time++;
            var mins = Math.floor(time/10/60);
            var secs = Math.floor(time/10 % 60);
            var hours = Math.floor(time/10/60/60); 
            if(mins < 10){
                mins = "0" + mins;
            } 
            if(secs < 10){
                secs = "0" + secs;
            }
            document.getElementById("output").innerHTML = hours + ":" + mins + ":" + secs  ;
            increment();
        },100)
    }
}
</script>

<script
src="https://code.jquery.com/jquery-2.2.4.min.js"
integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
crossorigin="anonymous"></script>
</head>
<body>

<h2 id="timestamp"></h2>
 
<script>
// Function ini dijalankan ketika Halaman ini dibuka pada browser
$(function(){
setInterval(timestamp, 1000);//fungsi yang dijalan setiap detik, 1000 = 1 detik
});
 
//Fungi ajax untuk Menampilkan Jam dengan mengakses File ajax_timestamp.php
function timestamp() {
$.ajax({
url: 'index1.php',
success: function(data) {
$('#timestamp').html(data);
},
});
}
</script>
</div>		
</body>
</html>
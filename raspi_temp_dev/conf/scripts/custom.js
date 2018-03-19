 $(document).ready(function(){
         function getdate(){
                var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
             if(s<10){
                 s = "0"+s;
             }

            document.getElementById('time_clock_p').innerHTML = h+" : "+m+" : "+s;

            setTimeout(function(){getdate()}, 500);
            }

        getdate();
    });
<script src="chart.js"></script> 
<canvas id="myChart" width="400" height="400"></canvas>
<script type="text/javascript">

    var lineChartData = {
        labels : ["January","February","March","April","May","June","July","August","September","October","November","December"],
        datasets : [
            {
                label: "Target",
                fillColor : "rgba(220,220,220,0.2)",
                strokeColor : "rgba(220,220,220,1)",
                pointColor : "rgba(220,220,220,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(220,220,220,1)",
                data : [160000,175000,185000,180000,185000,185000,185000,195000,200000,0,0]
            },
            {
                label: "Sales",
                fillColor : "rgba(151,187,205,0.2)",
                strokeColor : "rgba(151,187,205,1)",
                pointColor : "rgba(151,187,205,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(151,187,205,1)",
        	data: [20000,21000,30000,29000,29000,29000,31000,32000,33000,0,0]    
	}
        ]

    }
            window.onload = function(){
    var ctx = document.getElementById("canvas1").getContext("2d");
    window.myLine = new Chart(ctx).Line(lineChartData, {
        responsive: true
    });
}
</script>
<script type="text/javascript">

    var lineChartData = {
        labels : ["January","February","March","April","May","June","July","August","September","October","November","December"],
        datasets : [
            {
                label: "Target",
                fillColor : "rgba(220,220,220,0.2)",
                strokeColor : "rgba(220,220,220,1)",
                pointColor : "rgba(220,220,220,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(220,220,220,1)",
                data : [19000,21000,23000,25000,27000,29000,31000,32000,33000,0,0]
            },
            {
                label: "Sales",
                fillColor : "rgba(151,187,205,0.2)",
                strokeColor : "rgba(151,187,205,1)",
                pointColor : "rgba(151,187,205,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(151,187,205,1)",
		data: [20000,21000,30000,29000,29000,29000,31000,32000,33000,0,0]            
}
        ]

    }

    window.onload = function(){
    var ctx = document.getElementById("canvas2").getContext("2d");
    window.myLine = new Chart(ctx).Line(lineChartData, {
    responsive: true
    });



}

</script>


        

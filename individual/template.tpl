<html>
<head>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
        {literal}
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('datetime', 'Date/Time');
            data.addColumn('number', 'Miles');
            var raw_data = {/literal}{$graphJson}{literal};
            for (i = 0; i < raw_data.length; i++) {
                data.addRow([new Date(raw_data[i][0]), raw_data[i][1]]);
            }
            var chart = new google.visualization.ScatterChart(document.getElementById('visualization'));
            chart.draw(data, {
                lineWidth: 1,
            });
        }
        {/literal}
    </script>
    <style>
        {literal}
        #visualization {
            width: 100%;
            height: 75%;
        }
        {/literal}
    </style>
</head>
<body>

<p><a href='..'>Go Back</a></p>
<h1>{$title}</h1>
<div id='visualization'>coming soon</div>

</body>
</html>

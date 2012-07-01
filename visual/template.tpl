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
            var raw_data = {/literal}{$milesPerPoint}{literal};
            for (i = 0; i < raw_data.length; i++) {
                data.addRow([new Date(raw_data[i][0]), raw_data[i][1]]);
            }
            var chart = new google.visualization.ScatterChart(document.getElementById('milesPerPoint'));
            chart.draw(data, {
                lineWidth: 1,
            });
            
            var data = new google.visualization.DataTable();
            data.addColumn('datetime', 'Date/Time');
            data.addColumn('number', 'Miles per day');
            var raw_data = {/literal}{$milesPerDay}{literal};
            for (i = 0; i < raw_data.length; i++) {
                data.addRow([new Date(raw_data[i][0]), raw_data[i][1]]);
            }
            var chart = new google.visualization.ScatterChart(document.getElementById('milesPerDay'));
            chart.draw(data, {
                lineWidth: 1,
            });
            
            var data = new google.visualization.DataTable();
            data.addColumn('datetime', 'Date/Time');
            data.addColumn('number', 'Miles per day since last checkin');
            var raw_data = {/literal}{$milesPerDaySinceLast}{literal};
            for (i = 0; i < raw_data.length; i++) {
                data.addRow([new Date(raw_data[i][0]), raw_data[i][1]]);
            }
            var chart = new google.visualization.ScatterChart(document.getElementById('milesPerDaySinceLast'));
            chart.draw(data, {
                lineWidth: 1,
            });
        }
        {/literal}
    </script>
    <style>
        {literal}
        .visualization {
            width: 50%;
            height: 350px;
            float: left;
        }
        p {
            clear: both;
        }
        {/literal}
    </style>
</head>
<body>

<div id='milesPerPoint' class='visualization'>coming soon</div>
<div id='milesPerDay' class='visualization'>coming soon</div>
<div id='milesPerDaySinceLast' class='visualization'>coming soon</div>

<p><a href='..'>Go Back</a></p>

</body>
</html>

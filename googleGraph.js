/**
 * Created by: Antonio Tagliente
 * Date: 24.01.17
 * Time: 22:25
 */

$(function() {

	google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function returnGraphData() {
	    var jsonData = $.ajax({
	        url: "../common_assets/php/QueryToDataTable.php",
	        dataType: "json",
	        async: false
	    }).responseText;
	    alert(jsonData);
	    var data = new google.visualization.DataTable(jsonData);
	    return data;
	}

    function drawChart() {

        var data = returnGraphData();

        var options = {
            title: 'Temperature',
            curveType: 'function',
            legend: { position: 'bottom' }
        };

        /*
         * In html there has to be a div with "curve_chart" as an id
         */
        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    }
})
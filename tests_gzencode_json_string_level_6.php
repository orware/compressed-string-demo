<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<title>Compressed String Comparison Tests</title>
</head>
<body style="font-family: monospace">
	<h1>Compressed String Comparison Tests</h1>

	<div id="logging-info">

	</div>

	<script type="application/javascript">
	  function getResponse(id, url, repeat) {

		var helper = function (id, url, start, repeat) {
			if (repeat > 0)
			{
				if (window.XMLHttpRequest)
				{
				  var r = new XMLHttpRequest();
				  r.open("GET", url, true);
				  r.onreadystatechange = function () {
					if (r.readyState != 4 || r.status != 200) return;

					var elem = document.getElementById(id);

					elem.innerHTML += "<h3>Test #" + start + " for " + url + "</h3>";
					elem.innerHTML += r.responseText;
					elem.innerHTML += "#####################";
					helper(id, url, start + 1, repeat - 1);
				  };
				  r.send(null);
				}
			}
		};

		helper(id, url, 1, repeat);


	  }

	  var repetitions = 100;
	  getResponse("logging-info", "tests/gzencode_json_string_level_6.php", repetitions);

	</script>
</body>
</html>

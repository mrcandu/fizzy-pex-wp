<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Example Fizzy PEX Search</title>
</head>

<body>
<h1>Example Fizzy PEX Search</h1>
<?php
echo fizzy_pex_wp_search();

echo "<pre>";
print_r(fizzy_pex_wp_availability());
echo "</pre>";

?>

</body>
</html>
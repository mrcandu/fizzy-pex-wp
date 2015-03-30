<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Example Fizzy PEX Property</title>
</head>

<body>
<h1>Example Fizzy PEX Property</h1>
<?php 
if(isset($wp_query->query_vars['property'])){
	echo "property=".$wp_query->query_vars['property']; 
}
echo "<pre>";
print_r(fizzy_pex_wp_unit());
echo "</pre>";
?>

</body>
</html>
<?php

require_once "post.php";
 

$results = $data_cache = "";
$results_err = $data_cache_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["results"]))){
        $results_err = "Введите число ваше число!";
    } else{
        $sql = "SELECT id FROM fibonacci WHERE results = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["results"]);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $results_err = "This username is already taken.";
                } else{
                    $results = trim($_POST["results"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Закрываю подключения
            mysqli_stmt_close($stmt);
        }
    }
    /*  здесь крч я сломался, писал срочно. И data_cache должен был загрузить кэш, но так как на часах 3:00 я  вообще ни черта не сображаю. Ну уж так получилось!*/
    if(empty($results_err) && empty($data_cache_err)){
        
        $sql = "INSERT INTO fibonacci (results, data_cache) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            $param_username = $results;
            $param_password = $data_cache;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: index.php");
            } else{
                echo "Запрос не удался, пробуйте еще раз";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>
<head>
		<title>Фибоначи</title>
		<link rel="stylesheet" href="main.css">
		<script src="main.js"></script>
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Langar&display=swap" rel="stylesheet">
</head>

<body id="body" style="overflow:hidden;">
<div id="abc">
	<div id="popupContact">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="form" method="post" name="form">
			<h3 id="close" onclick="div_hide()">x</h3>
			<h2>Фибоначи</h2><hr>
			<input id="name" name="results" placeholder="Fibonacci" type="text"><hr>
			<span>Результат:</span> 
			<input type="hidden" name="data_cache">
			<span id="texter"></span>
			<hr>
			<input type="button" value="Найти" id="submit">
		</form>
	</div>
</div>

<div class="centered">
	<h3>Нажмите чтобы найти фибоначи</h3>
	<button id="popup" onclick="div_show()">Открыть окно</button>
	<h4 style="color: #fff; padding: 20px; text-shadow: 2px 2px 0 #000;">Результат можете смотреть сразу, если хотите посмотреть загрузку в БД, измените тип кнопки с <strong style="color: red; font-family: Arial;">button <em>to</em> submit</strong></h4>
</div>

<script>
	function add(a, b) {
        while (a.length < b.length) a.unshift(0);
        while (a.length > b.length) b.unshift(0);
        var carry = 0,
            sum = [];
        for (var i = a.length - 1; i >= 0; i--) {
            var s = a[i] + b[i] + carry;
            if (s >= 10) {
                s = s - 10;
                carry = 1;
            } else {
                carry = 0;
            }
            sum.unshift(s);
        }
        if (carry) sum.unshift(carry);
        return sum;
    }

    function fib(n) {
        var f1 = [0];
        var f2 = [1];

        while (n--) {
            var f3 = add(f1, f2);
            f1 = f2;
            f2 = f3;
        }
        return f1.join("");
    }

document.getElementById("submit").onclick = function () {
        var inputnum = parseFloat(document.getElementById("name").value);
        document.getElementById("texter").innerHTML = fib(inputnum).toString();
};
</script>
</body>
</html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;  charset=utf-8">
    <title>Companies</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"
            defer></script>
    <script src="scripts/companies.js" defer></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/border.css">

</head>
<body class="ml-5">
<h1>Company</h1>
<a href="contract.php">Contracts</a>
<a href="company.php">Company</a><br/><br/>


<div name="companies-list">
    <?php
    require_once 'dbconnection/mysqli.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['id'])) {
        $stmt = $conn->prepare("SELECT * FROM company WHERE id_company=?");
        $stmt->bind_param("i", $_GET['id']);
    } else {
        exit('Wrong company id');
    }
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) exit('No company found');
    $row = $result->fetch_assoc()
    ?>
    <div name="company-block" class="green-border-block">
        <label>Company name:</label><br/>
        <input type="text" name="name"
               value="<?php echo $row['name'] ?>"><br/>

        <label>Company chief:</label><br/>
        <input type="text" name="chief"
               value="<?php echo $row['chief'] ?>"><br/>

        <label>Company address:</label><br/>
        <input type="text" name="address"
               value="<?php echo $row['address'] ?>"><br/>

        <button data-id="<?php echo $row['id_company'] ?>" name="update-company-btn" type="button">
            Update
        </button>

        <button data-id="<?php echo $row['id_company'] ?>" name="remove-company-btn" type="button">
            Remove
        </button>
    </div>
</div>
</body>
</html>

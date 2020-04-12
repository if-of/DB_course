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
<h1>Companies</h1>
<a href="contract.php">Contracts</a><br/><br/>


<button class="mb-2" type="button" data-toggle="collapse" data-target="#add-company-block" aria-expanded="false">
    Show add company block
</button>
<div name="company-block" id="add-company-block" class="collapse mb-2 red-border-block">
    <label>Company name:</label><br/>
    <input type="text" name="name"><br/>

    <label>Company chief:</label><br/>
    <input type="text" name="chief"><br/>

    <label>Company address:</label><br/>
    <input type="text" name="address"><br/>

    <button id="add-company-btn" type="button">Add</button>
</div>

<button class="mb-2" type="button" data-toggle="collapse" data-target="#filter-block">
    Show filter block
</button>
<div class="collapse mb-2 red-border-block" id="filter-block">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="name-filter">Company name filter:</label><br/>
        <input type="text" id="name-filter" name="name-filter">

        <button type="submit">Find</button>
    </form>
</div>

<div name="companies-list">
    <?php
    require_once 'dbconnection/mysqli.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['name-filter'])) {
        $stmt = $conn->prepare("SELECT * FROM company WHERE name LIKE ?");
        $param = "%{$_GET['name-filter']}%";
        $stmt->bind_param("s", $param);
    } else {
        echo "<h1>Please use filter</h1>";
        exit();
    }
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) exit('No rows');
    while ($row = $result->fetch_assoc()) {
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

            <a href="one_company.php?id=<?php echo $row['id_company'] ?>">Details</a><br/>

            <button data-id="<?php echo $row['id_company'] ?>" name="update-company-btn" type="button">
                Update
            </button>

            <button data-id="<?php echo $row['id_company'] ?>" name="remove-company-btn" type="button">
                Remove
            </button>
            <br/>
        </div>
        <br/>
        <?php
    }
    ?>
</div>
</body>
</html>

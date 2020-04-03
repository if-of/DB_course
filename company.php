<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;  charset=utf-8">
    <title>Companies</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
    <script src="scripts/companies.js" defer></script>

</head>
<body>
<h1>Companies</h1><br/><br/>
<a href="contract.php">Contracts</a><br/><br/>

<div name="company-block">
    <label>Company name:</label><br/>
    <input type="text" name="name"><br/>

    <label>Company chief:</label><br/>
    <input type="text" name="chief"><br/>

    <label>Company address:</label><br/>
    <input type="text" name="address"><br/>

    <button id="add-company-btn" type="button">Add</button>
    <br/>
    <br/>
</div>
<br/>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="name-filter">Company name filter:</label><br/>
    <input type="text" id="name-filter" name="name-filter">

    <button type="submit">Find</button>
</form>

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
        $stmt = $conn->prepare("SELECT * FROM company");
    }
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) exit('No rows');
    while ($row = $result->fetch_assoc()) {
        ?>
        <div name="company-block">
            <label>Company id: <?php echo $row['id_company'] ?></label><br/>
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
            <br/>
            <br/>
        </div>
        <?php
    }
    ?>
</div>
</body>
</html>

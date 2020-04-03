<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;  charset=utf-8">
    <title>Companies</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
    <script src="scripts/contracts.js" defer></script>

</head>
<body>
<h1>Contracts</h1>
<a href="company.php">Companies</a><br/><br/>

<div name="contract-block">
    <label>Contract company:</label><br/>
    <input type="number" name="company"><br/>

    <label>Contract number:</label><br/>
    <input type="number" name="number"><br/>

    <label>Contract name:</label><br/>
    <input type="text" name="name"><br/>

    <label>Contract sum:</label><br/>
    <input type="text" name="sum"><br/>

    <label>Contract data start:</label><br/>
    <input type="date" name="data-start"><br/>

    <label>Contract data end:</label><br/>
    <input type="date" name="data-end"><br/>

    <label>Contract prepaid:</label><br/>
    <input type="text" name="prepaid"><br/>

    <button id="add-contract-btn" type="button">Add</button>
    <br/>
    <br/>
</div>
<br/>

<form style="border: 1px solid blue;" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="number-filter">Number filter:</label><br/>
    <input type="number" id="number-filter" name="number-filter">

    <button type="submit">Find</button>
</form>

<form style="border: 1px solid blue;" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="company-filter">Company filter:</label><br/>
    <input type="number" id="company-filter" name="company-filter">

    <button type="submit">Find</button>
</form>

<form style="border: 1px solid blue;" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="min-price-filter">Min price filter:</label><br/>
    <input type="number" id="min-price-filter" name="min-price-filter"><br/>

    <label for="max-price-filter">Max price filter:</label><br/>
    <input type="number" id="max-price-filter" name="max-price-filter"><br/>

    <button type="submit">Find</button>
</form>

<div name="contracts-list">
    <?php
    require_once 'dbconnection/pdo.php';


    if (!empty($_GET['company-filter'])) {
        $stmt = $conn->prepare("SELECT * FROM contract WHERE id_company = ?");
        $stmt->execute(array($_GET['company-filter']));
    } else if (!empty($_GET['number-filter'])) {
        $stmt = $conn->prepare("SELECT * FROM contract WHERE number = ?");
        $stmt->execute(array($_GET['number-filter']));
    } else if (!empty($_GET['min-price-filter']) && !empty($_GET['max-price-filter'])) {
        $stmt = $conn->prepare("SELECT * FROM contract WHERE sum BETWEEN ? AND ?");
        $stmt->bindValue(1, $_GET['min-price-filter'], PDO::PARAM_INT);
        $stmt->bindValue(2, $_GET['max-price-filter'], PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $stmt = $conn->query("SELECT * FROM contract");
        $stmt->execute();
    }
    foreach ($stmt as $row) {
        ?>
        <div name="contract-block">
            <label>Contract id: <?php echo $row['id_contract'] ?></label><br/>

            <label>Contract company:</label><br/>
            <input type="number" name="company" value="<?php echo $row['id_company'] ?>"><br/>

            <label>Contract number:</label><br/>
            <input type="number" name="number" value="<?php echo $row['number'] ?>"><br/>

            <label>Contract name:</label><br/>
            <input type="text" name="name" value="<?php echo $row['name'] ?>"><br/>

            <label>Contract sum:</label><br/>
            <input type="text" name="sum" value="<?php echo $row['sum'] ?>"><br/>

            <label>Contract data start:</label><br/>
            <input type="date" name="data-start" value="<?php echo $row['data_start'] ?>"><br/>

            <label>Contract data end:</label><br/>
            <input type="date" name="data-end" value="<?php echo $row['data_end'] ?>"><br/>

            <label>Contract prepaid:</label><br/>
            <input type="text" name="prepaid" value="<?php echo $row['prepaid'] ?>"><br/>

            <button data-id="<?php echo $row['id_contract'] ?>" name="update-contract-btn" type="button">
                Update
            </button>

            <button data-id="<?php echo $row['id_contract'] ?>" name="remove-contract-btn" type="button">
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

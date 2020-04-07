<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;  charset=utf-8">
    <title>Companies</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"
            defer></script>
    <script src="scripts/contracts.js" defer></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/border.css">
</head>
<body class="ml-5">
<h1>Contracts</h1>
<a href="company.php">Companies</a><br/><br/>

<button class="mb-2" type="button" data-toggle="collapse" data-target="#add-contract-block" aria-expanded="false">
    Show add company block
</button>
<div name="contract-block" id="add-contract-block" class="collapse mb-2 red-border-block">
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
</div>


<button class="mb-2" type="button" data-toggle="collapse" data-target="#filter-block" aria-expanded="false">
    Show filter block
</button>
<div class="collapse mb-2" id="filter-block">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="red-border-block">
        <label for="number-filter">Number filter:</label><br/>
        <input type="number" id="number-filter" name="number-filter">

        <button type="submit">Find</button>
    </form>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="red-border-block">
        <label for="company-filter">Company filter:</label><br/>
        <input type="number" id="company-filter" name="company-filter">

        <button type="submit">Find</button>
    </form>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="red-border-block">
        <label for="min-price-filter">Min price filter:</label><br/>
        <input type="number" id="min-price-filter" name="min-price-filter"><br/>

        <label for="max-price-filter">Max price filter:</label><br/>
        <input type="number" id="max-price-filter" name="max-price-filter"><br/>

        <button type="submit">Find</button>
    </form>
</div>

<div name="contracts-list">
    <?php
    require_once 'dbconnection/pdo.php';

    $companyMap = [];
    $stmt = $conn->query("SELECT id_company, name FROM company");
    $stmt->execute();
    foreach ($stmt as $row) {
        $companyMap[$row['id_company']] = $row['name'];
    }

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
        $companyId = $row['id_company'];
        ?>
        <div name="contract-block" class="green-border-block">
            <label>Contract company:</label><br/>
            <select name="company">
                <?php
                foreach ($companyMap as $key => $value) {
                    if ($key == $companyId) {
                        echo '<option value="' . $key . '" selected>' . $value . '</option>';
                    } else {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
                ?>
            </select> <br/>

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
        </div>
        <br/>
        <?php
    }
    ?>
</div>
</body>
</html>

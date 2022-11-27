<?php
include './config.php';
$query = "SELECT e.employeeNumber as id, e.firstName AS employeeFName, e.lastName AS employeeLName, e.email AS employeeEmail, e.jobTitle AS employeeJobTitle, e.picPath AS picPath ,o.addressLine1 AS add1, o.addressLine2 AS add2, o.city AS city, o.state AS state, o.country AS country, r.firstName AS reportsFName, r.lastName AS reportsLName, r.jobTitle AS reportsJobTitle FROM employees e NATURAL JOIN offices o LEFT JOIN employees r ON (e.reportsTo=r.employeeNumber);";
$exec = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>task1</title>
    <link rel="stylesheet" href="./index.css">
</head>

<body>
    <a href="./add.php">Add New Employee</a>
    <table>
        <thead>
            <tr>
                <td>Picture</td>
                <td>Name</td>
                <td>Email</td>
                <td>Job Title</td>
                <td>Emp Office Address</td>
                <td>Reports To</td>
                <td>Update</td>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($result = mysqli_fetch_assoc($exec)) {
            ?>
                <tr>
                    <td>
                        <?php
                        $imgPath = $result['picPath'];
                        if (!$imgPath) {
                            $imgPath = './assets/user.png';
                        }
                        else {
                            $imgPath = './assets/'.$imgPath;
                        }
                        ?>
                        <form action="./update.php" method="post" style="display:inline-block; width:min-content;">
                            <input style="display: none" type="text" name="editId" value="<?php echo $result['id'] ?>">
                            <button name='editButton' type="submit" style="">
                                <img src="<?php echo $imgPath?>" alt="user" height=60 width=60>
                            </button>
                        </form>
                    </td>
                    <td>
                        <?php echo $result['employeeFName'] . ' ' . $result['employeeLName'] ?>
                    </td>
                    <td>
                        <?php echo $result['employeeEmail'] ?>
                    </td>
                    <td>
                        <?php echo $result['employeeJobTitle'] ?>
                    </td>
                    <td>
                        <?php
                        echo $result['add1'] . ' ' . $result['add2'] . '<br>' . $result['city'] . ', ' . $result['state'] . ', ' . $result['country'];
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $result['reportsFName'] . ' ' . $result['reportsLName'] . ',' . $result['reportsJobTitle'];
                        ?>
                    </td>
                    <td>
                        <form action="./sessionId.php" method="post" style="display:inline-block; width:min-content;">
                            <input style="display: none" type="text" name="editId" value="<?php echo $result['id'] ?>">
                            <button name='editButton' type="submit">Edit</button>
                        </form>

                        <form action="./sessionId.php" method="post" style="display:inline-block; width:min-content;">
                            <input style="display: none" type="text" name="deleteId" value="<?php echo $result['id'] ?>">
                            <button name='deleteButton' type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>
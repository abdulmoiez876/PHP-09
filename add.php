<?php
include './config.php';
if (isset($_POST['add'])) {
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $extension = $_POST['extension'];
    $email = $_POST['email'];
    $officeCode = (int)$_POST['officeCode'];
    $reportsTo = $_POST['reportsTo'];
    $jobTitle = $_POST['jobTitle'];

    $targetDir = "assets/";
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $idQuery = "SELECT max(employeeNumber) as latestId FROM employees";
    $execId = mysqli_query($connection, $idQuery);
    $resultId = mysqli_fetch_assoc($execId)['latestId'];
    $resultId = (int)$resultId + 1;

    $query = "INSERT INTO employees (employeeNumber, firstName, lastName, extension, email, officeCode, reportsTo, jobTitle, picPath) VALUES ('$resultId', '" . $firstName . "', '" . $lastName . "','" . $extension . "' ,'" . $email . "' ,'" . $officeCode . "' ,'" . $reportsTo . "' , '" . $jobTitle . "', '" . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . "')";
    $exec = mysqli_query($connection, $query);
    if ($exec) {
        echo '<br>';
        echo 'added';
        echo '<br>';
    } else {
        echo '<br>';
        echo 'not added successfully';
        echo '<br>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Employee</title>
    <style>
        .flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        form {
            width: 300px;
            display: flex;
            flex-direction: column;
            row-gap: 2px;
        }
    </style>
</head>

<body>
    <form action="add.php" method="post" enctype="multipart/form-data">
        <input type="file" value="Upload Image" name='fileToUpload'>

        <div class="flex">
            <label for="fname">First Name: </label>
            <input type="text" name="fname" id="fname">
        </div>

        <br>
        <div class="flex">
            <label for="lname">Last Name: </label>
            <input type="text" name="lname" id="lname">
        </div>

        <br>
        <div class="flex">
            <label for="extension">Extension: </label>
            <input type="text" name="extension" id="extension">
        </div>

        <br>

        <div class="flex">
            <label for="email">Email: </label>
            <input type="email" name="email" id="email">
        </div>

        <br>

        <div class="flex">
            <label for="officeCode">Office Code: </label>
            <input type="number" name="officeCode" id="officeCode" min=1 max=7>
        </div>

        <br>

        <div class="flex">
            <label for="reportsTo">Reports To: </label>
            <select name="reportsTo" id="reportsTo">
                <?php
                $query = "SELECT firstName, lastName, employeeNumber from employees";
                $exec = mysqli_query($connection, $query);
                while ($result = mysqli_fetch_assoc($exec)) {
                ?>
                    <option value=<?php echo $result['employeeNumber'] ?>><?php echo $result['firstName'] . ' ' . $result['lastName'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>

        <br>

        <div class="flex">
            <label for="jobTitle">Job Title: </label>
            <input type="text" name="jobTitle" id="jobTitle">
        </div>

        <button type="submit" name='add'>Add</button>
    </form>
    <form action="./lab9.php">
        <input type="submit" value="Go Back" />
    </form>
</body>

</html>

<?php

session_start();

require '../model/User.php';

$_SESSION['globalErrMsg'] = "";
$_SESSION['firstNameErrMsg'] = "";
$_SESSION['lastNameErrMsg'] = "";
$_SESSION['emailErrMsg'] = "";
$_SESSION['phoneErrMsg'] = "";
$_SESSION['usernameErrMsg'] = "";
$_SESSION['passwordErrMsg'] = "";
$_SESSION['roleErrMsg'] = "";

function getAdminDashboardData()
{
    $userModel = new User();

    return [
        "total_users" => $userModel->countAll(),
        "students" => $userModel->countByRole("Student"),
        "moderators" => $userModel->countByRole("Moderator")
    ];
}

function getAllUsersForAdmin()
{
    $userModel = new User();

    return $userModel->getAll();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $action = $_POST['action'] ?? "";

    if ($action === "add_user") {

        $firstName = htmlspecialchars($_POST['first_name'] ?? "");
        $lastName = htmlspecialchars($_POST['last_name'] ?? "");
        $email = htmlspecialchars($_POST['email'] ?? "");
        $phone = htmlspecialchars($_POST['phone'] ?? "");
        $username = htmlspecialchars($_POST['username'] ?? "");
        $password = $_POST['password'] ?? "";
        $role = htmlspecialchars($_POST['role'] ?? "");

        $flag = true;

        if (empty($firstName)) {
            $flag = false;
            $_SESSION['firstNameErrMsg'] =
                "Please fill up the first name properly";
        }

        if (empty($lastName)) {
            $flag = false;
            $_SESSION['lastNameErrMsg'] =
                "Please fill up the last name properly";
        }

        if (empty($email)) {
            $flag = false;
            $_SESSION['emailErrMsg'] =
                "Please fill up the email properly";
        }
        else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $flag = false;
                $_SESSION['emailErrMsg'] =
                    "Please enter a valid email address";
            }
        }

        if (empty($phone)) {
            $flag = false;
            $_SESSION['phoneErrMsg'] =
                "Please fill up the phone number properly";
        }

        if (empty($username)) {
            $flag = false;
            $_SESSION['usernameErrMsg'] =
                "Please fill up the username properly";
        }

        if (empty($password)) {
            $flag = false;
            $_SESSION['passwordErrMsg'] =
                "Please fill up the password properly";
        }

        if (empty($role)) {
            $flag = false;
            $_SESSION['roleErrMsg'] =
                "Please select a role";
        }

        if ($flag) {

            $userModel = new User();

            if ($userModel->emailExists($email)) {

                $_SESSION['emailErrMsg'] =
                    "Email already exists";

                header("Location: ../view/admin-users.php");
                exit();
            }

            if ($userModel->usernameExists($username)) {

                $_SESSION['usernameErrMsg'] =
                    "Username already exists";

                header("Location: ../view/admin-users.php");
                exit();
            }

            if (
                strlen($password) < 8 ||
                !preg_match("/[A-Z]/", $password) ||
                !preg_match("/[a-z]/", $password) ||
                !preg_match("/[0-9]/", $password) ||
                !preg_match("/[\W_]/", $password)
            ) {

                $_SESSION['passwordErrMsg'] =
                    "Password must be at least 8 characters and contain uppercase, lowercase, number and special character";

                header("Location: ../view/admin-users.php");
                exit();
            }

            $passwordHash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $data = [
                "first_name" => $firstName,
                "last_name" => $lastName,
                "email" => $email,
                "phone" => $phone,
                "username" => $username,
                "password" => $passwordHash,
                "role" => $role
            ];

            $newUserId = $userModel->create($data);

            if ($newUserId) {

                $_SESSION['globalErrMsg'] =
                    "User added successfully";

                header("Location: ../view/admin-users.php");
                exit();
            }
            else {

                $_SESSION['globalErrMsg'] =
                    "User creation failed";

                header("Location: ../view/admin-users.php");
                exit();
            }
        }
        else {

            $_SESSION['globalErrMsg'] =
                "Please correct the errors";

            header("Location: ../view/admin-users.php");
            exit();
        }
    }

    elseif ($action === "update_user") {

        $id = (int)($_POST['id'] ?? 0);

        $firstName = htmlspecialchars($_POST['first_name'] ?? "");
        $lastName = htmlspecialchars($_POST['last_name'] ?? "");
        $email = htmlspecialchars($_POST['email'] ?? "");
        $phone = htmlspecialchars($_POST['phone'] ?? "");
        $username = htmlspecialchars($_POST['username'] ?? "");
        $role = htmlspecialchars($_POST['role'] ?? "");

        $flag = true;

        if ($id <= 0) {

            $flag = false;

            $_SESSION['globalErrMsg'] =
                "Invalid user ID";
        }

        if (empty($firstName)) {

            $flag = false;

            $_SESSION['firstNameErrMsg'] =
                "Please fill up the first name properly";
        }

        if (empty($lastName)) {

            $flag = false;

            $_SESSION['lastNameErrMsg'] =
                "Please fill up the last name properly";
        }

        if (empty($email)) {

            $flag = false;

            $_SESSION['emailErrMsg'] =
                "Please fill up the email properly";
        }
        else {

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $flag = false;

                $_SESSION['emailErrMsg'] =
                    "Please enter a valid email address";
            }
        }

        if (empty($phone)) {

            $flag = false;

            $_SESSION['phoneErrMsg'] =
                "Please fill up the phone number properly";
        }

        if (empty($username)) {

            $flag = false;

            $_SESSION['usernameErrMsg'] =
                "Please fill up the username properly";
        }

        if (empty($role)) {

            $flag = false;

            $_SESSION['roleErrMsg'] =
                "Please select a role";
        }

        if ($flag) {

            $userModel = new User();

            $user = $userModel->findById($id);

            if (!$user) {

                $_SESSION['globalErrMsg'] =
                    "User not found";

                header("Location: ../view/admin-users.php");
                exit();
            }

            if ($userModel->emailExists($email, $id)) {

                $_SESSION['emailErrMsg'] =
                    "Email already exists";

                header("Location: ../view/admin-users.php");
                exit();
            }

            if ($userModel->usernameExists($username, $id)) {

                $_SESSION['usernameErrMsg'] =
                    "Username already exists";

                header("Location: ../view/admin-users.php");
                exit();
            }

            $data = [
                "first_name" => $firstName,
                "last_name" => $lastName,
                "email" => $email,
                "phone" => $phone,
                "username" => $username,
                "role" => $role
            ];

            $result = $userModel->updateByAdmin(
                $id,
                $data
            );

            if ($result) {

                $_SESSION['globalErrMsg'] =
                    "User updated successfully";

                header("Location: ../view/admin-users.php");
                exit();
            }
            else {

                $_SESSION['globalErrMsg'] =
                    "User update failed";

                header("Location: ../view/admin-users.php");
                exit();
            }
        }
        else {

            $_SESSION['globalErrMsg'] =
                "Please correct the errors";

            header("Location: ../view/admin-users.php");
            exit();
        }
    }

    else {

        $_SESSION['globalErrMsg'] =
            "Something went wrong.";

        header("Location: ../view/admin-users.php");
        exit();
    }
}

else {

    $_SESSION['globalErrMsg'] =
        "Something went wrong.";

    header("Location: ../view/admin-users.php");
    exit();
}

?>


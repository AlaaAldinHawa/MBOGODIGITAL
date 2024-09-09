<!DOCTYPE html>
<html lang="nl">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/templates/head.php' ?>
</head>

<body class="bg-stone-950">
    <!-- Modal voor het resetten van wachtwoorden -->
    <div id="loginModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <!-- Modal header -->
            <div class="flex justify-between items-center border-b pb-2">
                <h3 class="text-xl font-semibold">Wachtwoord wijzigen</h3>
                <button class="text-gray-500 hover:text-gray-700" onclick="toggleModal('loginModal')">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="mt-4">
                <form method="POST" action="<?php echo $changeSecretUrl ?>">
                    <input type="hidden" id="id" name="id">
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Nieuw wachtwoord
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="password" type="password" placeholder="******************">
                    </div>
                    <div class="flex items-center justify-between">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit" name="login">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/topbar.php' ?>

    <div class="mt-6 mx-auto px-4 bg-stone-950">
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/menu.php' ?>
        <div class="p-6 text-medium text-stone-50 rounded w-full min-h-screen">
            <h3 class="text-lg font-bold text-stone-100 text-white mb-2">Gebruikers beheren</h3>
            <p class="mb-2 text-red-400">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </p>
            <div class="flex space-x-4">
                <form method="POST" action="<?php echo $newUrl ?>">
                    <button
                        class=" mt-6 shadow bg-stone-700 hover:bg-stone-300 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                        type="submit">
                        Gebruiker toevoegen
                    </button>
                </form>
                <form method="POST" action="<?php echo $uploadFormUrl ?>">
                    <button
                        class=" mt-6 shadow bg-stone-700 hover:bg-stone-300 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                        type="submit">
                        Eduarte upload
                    </button>
                </form>
            </div>
            <br>
            <table class="table-auto w-full bg-gray-800 text-white">
                <thead>
                    <tr class="bg-stone-800">
                        <th class="px-4 py-2 text-left">Delete</th>
                        <th class="px-4 py-2 text-left">Reset</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Voornaam</th>
                        <th class="px-4 py-2 text-left">Achternaam</th>
                        <th class="px-4 py-2 text-left">Enabled</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user) {
                        ?>
                        <tr class="even:bg-stone-900 odd:bg-stone-950">
                            <td class="px-4 py-2">
                                <a href="<?php echo $deleteUrl ?>?id=<?php echo $user["id"]; ?>"
                                    onclick="return confirm('Weet je zeker dat je deze roll wil verwijderen?');">
                                    <img src=" /images/trash.svg" alt="Trash" />
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                <?php
                                $userIdParameter = "'" . $user['id'] . "'";
                                ?>
                                <a onclick="toggleModal('loginModal', <?php echo $userIdParameter ?>)">
                                    <img src=" /images/lock.svg" alt="Reset Password" />
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                <a class="underline" href="<?php echo $detailUrl ?>?id=<?php echo $user["id"]; ?>">
                                    <?php echo $user["email"]; ?>
                                </a>
                            </td>
                            <td class="px-4 py-2"><?php echo $user["firstName"]; ?></td>
                            <td class="px-4 py-2"><?php echo $user["lastName"] . " " . $user["prefix"]; ?></td>
                            <td class="px-4 py-2"><?php echo $user["enabled"]; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function toggleModal(modalID, id) {
            console.log("modalID: " + modalID);
            console.log("id: " + id);
            document.getElementById('id').value = id;
            document.getElementById(modalID).classList.toggle('hidden');
        }
    </script>

</body>

</html>
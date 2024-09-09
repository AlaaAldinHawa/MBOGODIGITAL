<!DOCTYPE html>
<html lang="nl">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/templates/head.php' ?>
</head>

<body class="bg-stone-950">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/topbar.php' ?>

    <div class="mt-6 mx-auto px-4 bg-stone-950">
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/menu.php' ?>
        <div class="p-6 text-medium text-stone-50 rounded w-full min-h-screen">
            <h3 class="text-lg font-bold text-stone-100 text-white mb-2">Opleidingen beheren</h3>
            <p class="mb-2 text-red-400">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </p>
            <form method="POST" action="<?php echo $newUrl ?>">
                <button
                    class=" mt-6 shadow bg-stone-700 hover:bg-stone-300 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                    type="submit">
                    Opleiding toevoegen
                </button>
            </form>
            <br>
            <table class="table-auto w-full bg-gray-800 text-white">
                <thead>
                    <tr class="bg-stone-800">
                        <th class="px-4 py-2 text-left">Delete</th>
                        <th class="px-4 py-2 text-left">Crebo nummber</th>
                        <th class="px-4 py-2 text-left">Naam opleiding</th>
                        <th class="px-4 py-2 text-left">Niveau</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($educations as $education) {
                        ?>
                        <tr class="even:bg-stone-900 odd:bg-stone-950">
                            <td class="px-4 py-2">
                                <a href="/admin/educations/delete?id=<?php echo $education["id"]; ?>"
                                    onclick="return confirm('Weet je zeker dat je deze roll wil verwijderen?');">
                                    <img src=" /images/trash.svg" alt="Trash" />
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                <a class="underline" href="/admin/educations/detail?id=<?php echo $education["id"]; ?>">
                                    <?php echo $education["creboNumber"]; ?>
                                </a>
                            </td>
                            <td class="px-4 py-2"> <?php echo $education["name"]; ?></td>
                            <td class="px-4 py-2"> <?php echo $education["level"]; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
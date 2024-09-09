<!DOCTYPE html>
<html lang="nl">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/templates/head.php' ?>
</head>

<body class="bg-stone-950">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/topbar.php' ?>

    <div class="mt-6 mx-auto px-4 bg-stone-950">
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/menu.php' ?>
        <div class="p-6 text-medium text-stone-50 rounded w-full md:w-3/5 lg:w-2/5 min-h-screen">
            <h3 class="text-lg font-bold text-stone-100 text-white mb-2">Gebruiker
                <?php echo $editmode ? "bewerken" : "toevoegen" ?>
            </h3>
            <p class="mb-2"></p>
            <br>
            <form method="POST" action="<?php echo $actionUrl ?>" class="w-full">
                <input type="hidden" name="id" value="<?php echo isset($idValue) ? $idValue : "" ?>">
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="duoNumber">
                            DUO nummer
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="duoNumber" name="duoNumber" type="text"
                            value="<?php echo isset($duoNumberValue) ? $duoNumberValue : "" ?>">
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="firstName">
                            Voornaam
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="firstName" name="firstName" type="text"
                            value="<?php echo isset($firstNameValue) ? $firstNameValue : "" ?>">
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="prefix">
                            Tussenvoegsels
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="prefix" name="prefix" type="text" value="<?php echo isset($prefixValue) ? $prefixValue : "" ?>">
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="lastName">
                            Achternaam
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="lastName" name="lastName" type="text"
                            value="<?php echo isset($lastNameValue) ? $lastNameValue : "" ?>">
                    </div>
                </div>
                <?php if (!$editmode) { ?>
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="secret">
                                Wachtwoord
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input
                                class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                id="secret" name="secret" type="password" value="<?php echo isset($secretValue) ? $secretValue : "" ?>">
                        </div>
                    </div>               
                <?php } ?>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="phone">
                            Telefoonnummer
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="phone" name="phone" type="text" value="<?php echo isset($phoneValue) ? $phoneValue : "" ?>">
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="email">
                            Email
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="email" name="email" type="text" value="<?php echo isset($emailValue) ? $emailValue : "" ?>">
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3"></div>
                    <label class="md:w-2/3 block text-gray-500 font-bold">
                        <input class="mr-2 leading-tight" type="checkbox" id="changeSecretAtLogon" name="changeSecretAtLogon" <?php echo $changeSecretAtLogonValue == 1 ? "checked" : "" ?>>
                        <span class="text-sm">
                            Wachtwoord wijzigen na inloggen
                        </span>
                    </label>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3"></div>
                    <label class="md:w-2/3 block text-gray-500 font-bold">
                        <input class="mr-2 leading-tight" type="checkbox" id="enabled" name="enabled" <?php echo $enabledValue == 1 ? "checked" : "" ?>>
                        <span class="text-sm">
                            Account actief
                        </span>
                    </label>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                            for="roleId">
                            Rol
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="roleId" id="roleId"
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
                            <?php 
                                isset($roleIdValue) ? null : $roleIdValue = 0;
                                foreach ($roles as $role) { ?>
                                <option 
                                    value="<?php echo $role["id"] ?>"
                                    <?php echo $role["id"] == $roleIdValue ? "selected" : "" ?>>
                                    <?php echo $role["name"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                            for="educationId">
                            Opleiding
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="educationId" id="educationId"
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
                            <?php 
                                isset($educationIdValue) ? null : $educationIdValue = 0;
                                foreach ($educations as $education) { ?>
                                <option 
                                    value="<?php echo $education["id"] ?>"
                                    <?php echo $education["id"] == $educationIdValue ? "selected" : "" ?>>
                                    <?php echo $education["creboNumber"] . " " . $education["name"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="cohort">
                            Cohort
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            name="cohort" id="cohort" type="number" min="2020" max="2050" value="<?php echo isset($cohortValue) ? $cohortValue : date("Y") ?>">
                    </div>
                </div>
                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <button
                            class="shadow bg-stone-700 hover:bg-stone-300 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                            type="submit">
                            <?php echo $editmode ? "Bewerken" : "Toevoegen" ?>
                        </button>
                        <button
                            class="shadow bg-stone-700 hover:bg-stone-300 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                            type="reset" onclick="window.location='<?php echo "/admin/users/overview" ?>';return false;">
                            Annuleren
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

</body>

</html>
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
            <h3 class="text-lg font-bold text-stone-100 text-white mb-2">Opleiding overzicht</h3>
            <p class="mb-2"></p>
            <form method="GET" action="<?php echo $editUrl ?>">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <button
                    class=" mt-6 shadow bg-stone-700 hover:bg-stone-300 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                    type="submit">
                    Opleiding bewerken
                </button>
                <button
                    class="shadow bg-stone-700 hover:bg-stone-300 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                    type="reset" onclick="window.location='<?php echo $overviewUrl ?>';return false;">
                    Terug
                </button>
            </form>
            <br>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="name">
                        Crebo nummer
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($creboNumber) ? $creboNumber : "" ?>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="name">
                        Naam opleiding
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($name) ? $name : "" ?>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="name">
                        Niveau
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($level) ? $level : "" ?>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="name">
                        Omschrijving
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($description) ? $description : "" ?>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="name">
                        Inschrijving tot ...
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($registerUntil) ? $registerUntil : "" ?>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="name">
                        Diplomeren tot ...
                    </label>
                </div>
                <div class="md:w-2/3">
                    <?php echo isset($graduateUntil) ? $graduateUntil : "" ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
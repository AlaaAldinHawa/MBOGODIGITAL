<!DOCTYPE html>
<html lang="nl">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/templates/head.php' ?>
</head>

<body class="bg-stone-950">
    <!-- Modal -->
    <div id="loginModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <!-- Modal header -->
            <div class="flex justify-between items-center border-b pb-2">
                <h3 class="text-xl font-semibold">Login</h3>
                <button class="text-gray-500 hover:text-gray-700" onclick="toggleModal('loginModal')">&times;</button>
            </div>

            <div class="m-2 font-bold text-red-400">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </div>
            <!-- Modal body -->
            <div class="mt-4">
                <form method="POST" action="/auth/login/">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            Emailadres
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="email" name="email" type="email" placeholder="Emailadres">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Wachtwoord
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

    <script>
        function toggleModal(modalID) {
            document.getElementById(modalID).classList.toggle('hidden');
        }

        document.addEventListener("DOMContentLoaded", function () {
            toggleModal('loginModal');
            console.log("DOM is fully loaded and parsed");
        });
    </script>

</body>

</html>
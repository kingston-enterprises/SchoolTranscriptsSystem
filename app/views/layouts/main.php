<?php

use kingston\icarus\Application;

use kingstonenterprises\app\models\User;

if (!Application::isGuest()) {
    $user = new User;
    $user = $user->findOne([
        'id' => Application::$app->session->get('user')
    ]);
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <link rel="stylesheet" href="/css/output.css" />
</head>

<body class="m-0 p-0 bg-blue-500">
    <nav class="m-0 p-3 bg-blue-800 flex flex-row justify-between text-blue-50 text-2xl font-bold">
        <div class="p-2">
            <a href="/">School Transcripts System</a>
        </div>
        <div>
            <ul class="flex flex-row justify-around">

                <?php if (Application::isGuest()) : ?>
                    <li class="mx-2 p-2 border rounded-md bg-blue-400">
                        <a href="/auth/login/">Login</a>
                    </li>
                    <li class="mx-2 p-2 border rounded-md bg-blue-400">
                        <a href="/auth/register/">Register</a>
                    </li>
                <?php else : ?>
                    <li class="mx-2 p-2 border rounded-md bg-blue-400">
                        <a href="/dashboard">
                            <?php echo $user->getDisplayName() ?>
                        </a>
                    </li>
                    <li class="mx-2 p-2 border rounded-md bg-blue-400">
                        <a href="/auth/logout">
                            Logout
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <?php if (Application::$app->session->getFlash('success')) : ?>
        <div class="bg-green-100 rounded-lg py-5 px-6 mb-4 text-base text-green-700" role="alert">
            <p><?php echo Application::$app->session->getFlash('success') ?></p>
        </div>
    <?php elseif (Application::$app->session->getFlash('warning')) : ?>
        <div class="bg-orange-100 rounded-lg py-5 px-6 mb-4 text-base text-orange-700" role="alert">
            <p><?php echo Application::$app->session->getFlash('warning') ?></p>
        </div>
    <?php  elseif (Application::$app->session->getFlash('error')) : ?>
        <div class="bg-orange-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700" role="alert">
            <p><?php echo Application::$app->session->getFlash('error') ?></p>
        </div>
    <?php endif; ?>
    {{content}}
</body>

</html>
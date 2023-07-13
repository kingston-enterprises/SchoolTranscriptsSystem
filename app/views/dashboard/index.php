<?php

use kingston\icarus\Application;
?>
<title><?php echo $title ?></title>

<!-- Main section -->
<section id="dashboard" class="w-full h-full container flex justify-center items-center my-2 px-6 mx-auto" aria-label="Dashboard Section">
    <div class="w-8/12 block rounded-lg shadow-lg backdrop-blur-xl bg-white/30 py-10 md:py-12 px-4 md:px-6">
        <div class="w-full mx-auto ">
            <div class="p-5 mb-2 flex flex-row flex-wrap items-center justify-center lg:justify-start">
                <img class="m-2 h-32 rounded-full" src="/img/person-icon.png" alt="default Profile Picture">
                <div class="">

                    <h1> <?php echo $user->getDisplayName(); ?> </h1>

                    <h2>ID: <?php echo $user->email; ?></h2>
                    <h2><?php echo $user->id_number; ?></h2>
                    <h2>since: <?php echo $user->joined; ?></h2>
                    <h2>role: <?php echo $user->role->getDisplayName(); ?></h2>

                    <div class="p-3 flex flex-row flex-wrap">

                        <a class="text-blue-500 mx-1 underline text-sm" href="/update/profile">
                            Edit Profile
                        </a>
                    </div>

                    <div class="flex flex-row flex-wrap">


                        <?php
                        if (Application::$app->session->get('role') == 1) { // admin actions
                        ?>
                            <div class="m-3 bg-white shadow border rounded-lg p-4" aria-label="total visitors stats">
                                <a href="/courses">

                                    <div class="flex items-center" aria-label="total visitors">
                                        <span class="text-xl sm:text-xl leading-none font-bold text-gray-900"><?php echo $courses; ?></span>
                                        <h3 class="text-base font-normal text-gray-500">Courses</h3>
                                    </div>
                                </a>
                            </div>

                            <div class="m-3 bg-white shadow border rounded-lg p-4" aria-label="total visitors stats">
                                <a href="/users">
                                    <div class="flex items-center" aria-label="total visitors">
                                        <span class="text-xl sm:text-xl leading-none font-bold text-gray-900"><?php echo $users; ?></span>
                                        <h3 class="text-base font-normal text-gray-500">users</h3>
                                    </div>
                                </a>
                            </div>

                            <div class="m-3 bg-white shadow border rounded-lg p-4" aria-label="total visitors stats">
                                <a href="/announcements">
                                    <div class="flex items-center" aria-label="total announcements">
                                        <span class="text-xl sm:text-xl leading-none font-bold text-gray-900"><?php echo $announcements; ?></span>
                                        <h3 class="text-base font-normal text-gray-500">Announcements</h3>
                                    </div>
                                </a>
                            </div>
                        <?php
                        } elseif (Application::$app->session->get('role') == 2) { // teacher actions
                        ?>
                            <div class="m-3 bg-white shadow border rounded-lg p-4" aria-label="total visitors stats">
                                <a href="/announcements">
                                    <div class="flex items-center" aria-label="total announcements">
                                        <span class="text-xl sm:text-xl leading-none font-bold text-gray-900"><?php echo $announcements; ?></span>
                                        <h3 class="text-base font-normal text-gray-500">Announcements</h3>
                                    </div>
                                </a>
                            </div>

                            <div class="m-3 bg-white shadow border rounded-lg p-4" aria-label="total visitors stats">
                                <a href="/grades">
                                    <div class="flex items-center" aria-label="total announcements">
                                        <h3 class="text-base font-normal text-gray-500">Grades</h3>
                                    </div>
                                </a>
                            </div>

                        <?php
                        } elseif (Application::$app->session->get('role') == 3) { // student actions
                        ?>
                            <div class="m-3 bg-white shadow border rounded-lg p-4" aria-label="total visitors stats">
                                <a href="/registration">
                                    <div class="flex items-center" aria-label="total announcements">
                                        <h3 class="text-base font-normal text-gray-500">Registration</h3>
                                    </div>
                                </a>
                            </div>

                            <div class="m-3 bg-white shadow border rounded-lg p-4" aria-label="total visitors stats">
                                <a href="/grades/view/">
                                    <div class="flex items-center" aria-label="total announcements">
                                        <h3 class="text-base font-normal text-gray-500">Results</h3>
                                    </div>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</section>
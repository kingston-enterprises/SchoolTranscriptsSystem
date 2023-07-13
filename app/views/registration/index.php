<?php

namespace kingston\icarus\form;

$form = new Form();



?>
<title><?php echo $title ?></title>

<!-- Main section -->
<section id="dashboard" class="h-screen p-10" aria-label="Dashboard Section">
    <div class="container w-full flex justify-center text-gray-800 px-4 md:px-12">

        <div class="w-10/12 rounded-lg shadow-lg py-10 md:py-8 bg-white px-4 md:px-6">
            <div class="p-5 flex flex-row flex-wrap items-center justify-center lg:justify-start">
                <div class="m-3 bg-white shadow border rounded-lg p-4" aria-label="total visitors stats">
                    <a href='/registration/create/' class="flex items-center cursor-pointer " aria-label="total visitors">
                        <h3 class="text-base font-normal text-gray-500">Add Course Registration</h3>
                    </a>
                </div>

            </div>
            <div class="flex flex-col">
                <?php
                if ($registration->count() == 0) { ?>
                    <div class="p-5 w-12/12 flex flex-row flex-wrap items-center justify-between border-y lg:justify-start">
                        No Courses registered
                    </div>

                <?php } else { ?>
                    <h3>Registered Courses</h3>
                    <?php
                    foreach ($registration->getIterator() as $key => $reg) {
                    ?>
                        <div class="p-5 w-12/12 flex flex-row flex-wrap items-center justify-between border-y lg:justify-start">
                            <div class="w-5/12 flex flex-col">
                                <h4><?php echo $reg->course->getDisplayName(); ?></h4>
                                <p>Instructor: <?php echo $reg->course->leader->getDisplayName(); ?></p>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

</section>
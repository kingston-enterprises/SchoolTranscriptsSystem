<?php

namespace kingston\icarus\form;

$form = new Form();

?>
<title><?php echo $title ?></title>

<!-- Section: Login -->
<section id="login" class="w-full h-8/12 container flex justify-center items-center my-2 px-6 mx-auto" aria-label="Login Section">
    <div class="w-96 block rounded-lg shadow-lg backdrop-blur-xl bg-white/30 py-10 md:py-12 px-4 md:px-6">
        <div class="flex flex-col">
            <?php
            if ($courses->count() == 0) { ?>
                <div class="p-5 w-12/12 flex flex-row flex-wrap items-center justify-between border-y lg:justify-start">
                    No Courses exist
                </div>
                <?php } else {
                $form = Form::begin('', 'post');
                foreach ($courses->getIterator() as $key => $course) { ?>
                    <div class="p-5 w-12/12 flex flex-row flex-wrap items-center justify-between border-y lg:justify-start">
                        <div class="max-w-lg mx-auto ">
                            <div>
                                <input type="checkbox" id="<?php echo $course->title ?>" name="<?php echo $course->id ?>" checked>
                                <label for="<?php echo $course->title ?>"><?php echo $course->title ?></label>
                            </div>



                            <?php  ?>
                        </div>
                    </div>
                <?php
                }
                ?>
                <button type="submit" class="block w-full p-3 font-bold bg-blue-600 text-white
            text-xs
            leading-tight
            uppercase
            rounded
            shadow-md
            hover:bg-blue-700 hover:shadow-lg
            focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
            active:bg-blue-800 active:shadow-lg
            transition
            duration-150
            ease-in-out" aria-label="Contact Section Form Submit Button">Register</button>
            <?php
                Form::end();
            }
            ?>
        </div>

    </div>
</section>
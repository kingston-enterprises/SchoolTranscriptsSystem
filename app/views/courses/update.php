<?php

namespace kingston\icarus\form;

$form = new Form();

?>
<title><?php echo $title ?></title>

<!-- Section: Login -->
<section id="login" class="w-full h-8/12 container flex justify-center items-center my-2 px-6 mx-auto" aria-label="Login Section">
    <div class="w-96 block rounded-lg shadow-lg backdrop-blur-xl bg-white/30 py-10 md:py-12 px-4 md:px-6">
        <div class="max-w-lg mx-auto ">
            <?php $form = Form::begin('', 'post') ?>
            <?php echo $form->field($model, 'title') ?>
            <?php echo $form->field($model, 'code') ?>
            <select class="form-control" name="instructor">
                <?php foreach ($instructors->getIterator() as $key => $instructor) { ?>
                    <option class="form-control" value="<?php echo $instructor->id ?>"><?php echo $instructor->firstname . $instructor->lastname ?></option>
                <?php } ?>
            </select>

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
            ease-in-out" aria-label="Contact Section Form Submit Button">Update</button>

            <?php Form::end() ?>
        </div>
    </div>
</section>
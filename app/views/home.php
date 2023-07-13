<title><?php echo $title ?></title>

<!-- Landing Area -->
<section id="landing-area" class="w-full h-full container flex justify-center items-center my-2 px-6 mx-auto" aria-label="Landing Area">
    <div class="w-8/12 flex flex-col justify-center align-center rounded-lg shadow-lg backdrop-blur-xl bg-white/30 py-10 md:py-12 px-4 md:px-6">

        <?php
        if ($announcements->count() == 0) { ?>
            <div class="flex justify-center align-center max-w-lg mx-auto ">
                <h1 class="text-blue-50 text-2xl font-bold">No Anouncements</h1>
            </div>

        <?php }
        foreach ($announcements->getIterator() as $key => $announcement) { ?>
            <div class="my-5  rounded-lg shadow-lg backdrop-blur-xl bg-white/30 py-10 md:py-12 px-4 md:px-6">

                <div class="m-3  p-2flex  justify-center align-center max-w-lg mx-auto ">
                    <h1 class="text-xl font-bold border-b"><?php echo $announcement->title; ?></h1>
                    <p class="my-5 text-md"><?php echo $announcement->body; ?></p>
                </div>
                <div class="flex border-t flex-col justify-center align-center max-w-lg mx-auto ">
                    <p class="mx-3 text-s">Posted: <?php echo date_format(date_create($announcement->created_at), 'l jS \of F Y h:i A'); ?></p>
                    <p class="mx-3 text-s">Posted By: <?php echo $announcement->user->getDisplayName(); ?></p>
                    <p class="mx-3 text-s">Last Edited: <?php echo date_format(date_create($announcement->updated_at), 'l jS \of F Y h:i A'); ?></p>
                    
                </div>

            </div>
        <?php
        }
        ?>
    </div>

    </div>
</section>
<?php

use kingston\icarus\Application;
use kingstonenterprises\app\models\Pdf;


// Instantiate and use the FPDF class
$pdf = new Pdf();

// Define alias for number of pages
$pdf->AliasNbPages();
$pdf->AddPage();


$pdf->Ln(20);

$pdf->Cell(60, 10, 'Name', 1, 0);
$pdf->Cell(60, 10, $user->getDisplayName(), 1, 1);
$pdf->Cell(60, 10, 'Email', 1, 0);
$pdf->Cell(60, 10, $user->email, 1, 1);
$pdf->Cell(60, 10, 'Student ID', 1, 0);
$pdf->Cell(60, 10, $user->id_number, 1, 1);
$pdf->Ln(5);

$pdf->Cell(60, 10, 'Course', 1, 0);
$pdf->Cell(30, 10, 'Course Code', 1, 0);
$pdf->Cell(30, 10, 'Grade', 1, 1);
foreach ($user->grades as $grade) {
    $pdf->Cell(60, 10,  $grade->course_title, 1, 0);
    $pdf->Cell(30, 10,  $grade->course_code, 1, 0);
    $pdf->Cell(30, 10,  $grade->grade, 1, 1);
}
$pdf->Output('',$user->id_number . '-transcripts.pdf');
exit();
?>


<title><?php echo $title ?></title>

<!-- Main section -->
<section id="dashboard" class="w-full h-full container flex justify-center items-center my-2 px-6 mx-auto" aria-label="Dashboard Section">
    <div class="w-8/12 block rounded-lg shadow-lg backdrop-blur-xl bg-white/30 py-10 md:py-12 px-4 md:px-6">
        <div class="w-full mx-auto ">
            <div class="p-5 mb-2 flex flex-row flex-wrap items-center justify-center lg:justify-start">
                <div class="w-5/12 flex flex-col">
                    <h4><?php echo $user->getDisplayName(); ?></h4>
                </div>

                <div class="w-5/12 flex flex-col">
                    <p><?php echo $user->id_number; ?></p>
                </div>

                <div class="w-5/12 flex flex-col">
                    <p><?php
                        foreach ($user->grades as $grade) {
                        ?>
                    <table>
                        <tr>
                            <th>Course ID</th>
                            <th>Grade</th>
                        </tr>
                        <tr>
                            <td><?php echo $grade->course_id ?></td>
                            <td><?php echo $grade->grade ?></td>
                        </tr>
                    </table>
                <?php
                        } ?>
                </p>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

</section>
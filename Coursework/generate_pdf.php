<?php
define('PDF_CREATOR', 'TCPDF');
require_once('TCPDF-main/tcpdf.php');

// Create a new TCPDF object
$pdf = new TCPDF();

// Set document infor
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Task List PDF');
$pdf->SetSubject('Task List');
$pdf->SetKeywords('Task, List, PDF');

// Add a page
$pdf->AddPage();

// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enterpriseCW";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch task data from the database
$sql = "SELECT * FROM tasklist ORDER BY taskDate ASC";
$result = $conn->query($sql);

// Add task data to the PDF
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $taskName = $row["taskName"];
        $taskDescription = $row["taskDescription"];
        $taskDate = $row["taskDate"];
        $whoCanView = $row["whoCanView"];
        $taskComplete = $row["taskComplete"];

        // Add task data to the PDF
        $pdf->Cell(0, 10, "Task Name: $taskName", 0, 1);
        $pdf->Cell(0, 10, "Task Description: $taskDescription", 0, 1);
        $pdf->Cell(0, 10, "Task Date: $taskDate", 0, 1);
        $pdf->Cell(0, 10, "Who Can View: $whoCanView", 0, 1);
        $pdf->Cell(0, 10, "Task Complete: $taskComplete", 0, 1);
        $pdf->Ln(); // Add a new line
    }
}

// Close and output PDF
$pdf->Output('generated_pdf.pdf', 'D');
?>

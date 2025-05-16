<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$conn = new mysqli("localhost", "root", "", "formulaire");
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

$sql = "SELECT * FROM clients";
$result = $conn->query($sql);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->fromArray(['ID', 'Partenaire', 'Nom Président', 'Activité', 'Projet', 'Budget Débloqué', 'Avancement', 'Chef de Projet'], NULL, 'A1');

$rowNum = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->fromArray([
        $row['id'],
        $row['partenaire'],
        $row['nom_president'],
        $row['activite'],
        $row['projet'],
        $row['budget_debloque'],
        $row['avancement'],
        $row['chef_de_projet']
    ], NULL, 'A' . $rowNum);
    $rowNum++;
}

foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="clients.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>

<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use Mpdf\Mpdf;

$id = $_GET['id'] ?? null;
if (!$id) die("NIK tidak ditemukan");

// 1. Ambil data dari DB
include '../koneksi.php';
$id = $_GET['id'];
$result = $koneksi->query("SELECT * FROM slip_gaji WHERE nik = '$id'");
if ($result && $result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    die("Data tidak ditemukan untuk NIK: $id");
}

// 2. Load template
$spreadsheet = IOFactory::load('template.xlsx');
$sheet = $spreadsheet->getActiveSheet();
$sheet->getStyle('D3:D20')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('I3:I15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

// 3. Isi data ke sel yang sesuai
$sheet->setCellValue('D3', $data['nik']);
$sheet->setCellValue('D4', $data['nama']);
$sheet->setCellValue('D5', $data['bagian']);
$bulan = $data['bulan'];
$tahun = $data['tahun'];

$bulan_indo = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
$namaBulan = isset($bulan_indo[$bulan]) ? $bulan_indo[$bulan] : $bulan;

$sheet->setCellValue('I3', "$namaBulan, $tahun");
$sheet->setCellValue('I4', number_format($data['gp_hk_24']));
$sheet->setCellValue('D16', number_format($data['ot_20']));

$sheet->setCellValue('D10', number_format($data['gaji_pokok']));
$sheet->setCellValue('D11', number_format($data['tj_jab']));
$sheet->setCellValue('D12', number_format($data['tj_skill']));
$sheet->setCellValue('D13', number_format($data['tj_bagian']));
$sheet->setCellValue('D14', number_format($data['tj_kehadiran']));
$sheet->setCellValue('D15', number_format($data['uang_makan']));

$sheet->setCellValue('I10', number_format($data['potongan_hk']));
$bpjs = $data['bpjs_ket'] + $data['pensiun'];
$sheet->setCellValue('I11', number_format($bpjs));
$sheet->setCellValue('I12', number_format($data['bpjs_kes']));
$sheet->setCellValue('I13', number_format($data['pph_21']));
$sheet->setCellValue('I14', number_format($data['gp']));
$sheet->setCellValue('I15', number_format($data['cos']));

$total_pendapatan = $data['gaji_pokok'] + $data['ot_20'] + $data['tj_jab'] + $data['tj_skill'] + $data['tj_bagian'] + $data['tj_kehadiran'] + $data['uang_makan'];
$total_kewajiban = $data['potongan_hk'] + $data['bpjs_ket'] + $data['bpjs_kes'] + $data['pensiun'] + $data['pph_21'] + $data['gp'] + $data['cos'];
$gaji_terima = $total_pendapatan - $total_kewajiban;

$sheet->setCellValue('D20', $gaji_terima);

$pageSetup = $sheet->getPageMargins();
$pageSetup->setTop(0.5);
$pageSetup->setBottom(0.5);
$pageSetup->setLeft(0.5);
$pageSetup->setRight(0.5);

// 4. Proses HTML
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Html($spreadsheet);
ob_start();
$writer->save('php://output');
$html = ob_get_clean();

$style_override = "
<style>
    table {
        width: 100% !important;
        table-layout: auto !important;
        border-collapse: collapse !important;
        margin: 0 auto !important;
    }
    
    td {
        padding: 5px 6px !important; 
        font-family: Arial, sans-serif !important;
        font-size: 8.5pt !important;
        white-space: nowrap !important;
        vertical-align: middle !important;
    }
    
    img {
        height: 45px !important;
        width: auto !important;
    }
</style>
";

$html = $style_override . $html;

// 5. Kirim ke mPDF
$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => [100, 150], 
    'margin_left' => 5,
    'margin_right' => 5,
    'margin_top' => 5,
    'margin_bottom' => 5,
]);

$mpdf->WriteHTML($html);
$mpdf->Output('Slip-Gaji-' . $data['nik'] . '.pdf', 'I');
exit;
?>
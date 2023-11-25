<?php
// Server-side code (PHP)

// Check if the request method is POST and the request body is not empty
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(file_get_contents('php://input'))) {
    // Get the PDF data from the request body
    $pdfData = file_get_contents('php://input');

    // Specify the folder path to save the PDF
    $folderPath = 'D:/customer/';

    if (!is_writable($folderPath)) {
        echo 'Folder is not writeable';
        exit;
    }

    // Generate a unique filename for the PDF using the current timestamp
    $fileName = 'invoice_' . time() . '.pdf';

    // Combine the folder path and filename
    $filePath = $folderPath . $fileName;

    // Save the PDF file
    $result = file_put_contents($filePath, $pdfData);

    // Check if the file was saved successfully
    if ($result !== false) {
        echo 'PDF saved successfully';
    } else {
        echo 'Error saving PDF';
    }
} else {
    echo 'Invalid request';
}
?>

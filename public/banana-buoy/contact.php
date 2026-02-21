<?php

require_once __DIR__ . '/../../src/banana-buoy/models/ContactsModel.php';
require_once __DIR__ . '/../../src/banana-buoy/views/ContactView.php';
require_once __DIR__ . '/../../src/banana-buoy/views/ErrorView.php';

use BananaBuoy\Models\ContactsModel;
use BananaBuoy\Views\ContactView;
use BananaBuoy\Views\ErrorView;

try {
    $contactsModel = new ContactsModel();
    $submitted = false;

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $message = $_POST['message'] ?? '';

        // In a real application, you would:
        // 1. Validate and sanitize input
        // 2. Send email to the contact address
        // 3. Store the message in a database
        // 4. Add the sender's email to contacts list if they opt in

        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // For now, just mark as submitted
            $submitted = true;

            // Log the contact attempt (in production, send actual email)
            error_log("Contact form submission: $name ($email) - Subject: $subject");
        }
    }

    $contactEmail = $contactsModel->getContactEmail();

    $view = new ContactView();
    $view->render([
        'contactEmail' => $contactEmail,
        'submitted' => $submitted
    ]);
} catch (Exception $e) {
    error_log("Error loading contact page: " . $e->getMessage());

    $view = new ErrorView(
        'Error Loading Contact',
        'There was an error loading the contact page. Please refresh and try again.',
        500
    );
    $view->render();
}
